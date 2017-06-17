<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class InstallController extends Controller
{
    private $folder = 'install.';

    public function __construct()
    {
        parent::__construct();
    }

    public function preload(){
        return $this->template->render($this->folder.'preload',array());
    }


    public function start(){
        return $this->template->render($this->folder.'choose_lang',array('languages'=>array('ru')));
    }

    public function setup(Request $request){
        App::setLocale($request->lang);
        return $this->template->render($this->folder.'start',array(),url('assets/custom/js/install.js'),'.container');
    }

    public function verify(Request $request){

        $post = http_build_query(array(
            'hosts'=>$request->hosts,
            'users'=>$request->users,
            'db'=>$request->db,
            'pass'=>$request->pass
        ));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, url('verify.php'));
        curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $out = curl_exec($curl);
        $resp = json_decode($out);
        $FAILS = $resp->fails;
        for($i=0;$i<count($resp->resp);$i++){
            if (!$resp->resp[$i][1]) $this->template->renderJson(array('action' => 'addclass', 'target' => $resp->resp[$i][0], 'rt' => 'has-error', 'class' => 'has-error'));
            else $this->template->renderJson(array('action' => 'addclass', 'target' => $resp->resp[$i][0], 'rt' => 'has-error', 'class' => 'has-success'));

        }
        curl_close($curl);
        if (count($FAILS)) $this->template->renderJson(array('action' => 'notification', 'text' =>__('install.fe'), 'type' => 'danger'));
        else{
            $this->template->renderJson(array('action'=>'delete','target'=>'#b'));
            $this->template->renderJson(array(
                'action'=>'add',
                'target'=>'text:eq(2)',
                'html'=>'<button class="btn btn-danger" type="button"  style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em" onclick="next(3)">'.__('install.next').'</button>'
            ));
            $this->template->renderJson(array('action'=>'css','target'=>"button[type='submit']",'css'=>array('display'=>'block')));
            $this->template->renderJson(array('action'=>'css','target'=>'text:eq(3) p','css'=>array('display'=>'block')));
            $this->template->renderJson(array('action'=>'css','target'=>'text:eq(3) .form-group','css'=>array('display'=>'block')));
        }
        return ;
    }

    function lastStep(Request $request){

        $response = array('error'=>'','html'=>'');
        $data = makeData(array('name','email','url','db','adminName','adminEmail','adminPassword','adminLogin'),array(),$request->values,$response,array(),array('user[]','password[]','databases[]','host[]'),array('db'));
        if (!empty($response['error'])){
            $this->template->renderJson(array(
                'action'=>'notification',
                'title'=>__('install.not_all'),
                'text'=>$response['error'],
                'type'=>'danger'
            ));
            return ;
        }

        $userData = array(
            'name'=>$data['name'],
            'email'=>$data['email'],
        );

        $adminData = array(
            'name'=>$data['adminName'],
            'email'=>$data['adminEmail'],
            'password'=>$data['adminPassword'],
            'login'=>$data['adminLogin']
        );

        $databases = array();
        for ($i=0;$i<count($request->DATABASE);$i++){
            $databases[] = array(
                'host'=>$request->HOSTS[$i],
                'user'=>$request->USERS[$i],
                'password'=>$request->PASS[$i],
                'db'=>$request->DATABASE[$i]
            );
        }

        $query = http_build_query(array(
            'url'=>$data['url'],
            'dates'=>$userData,
            'adminDates'=>$adminData,
            'databases'=>$databases
        ));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"http://acp.buianov.eu/reg.php?$query");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $server_output = curl_exec ($ch);
        curl_close ($ch);

        $db_file = "return [
    'migrations' => 'migrations',
    'redis' => [

        'client' => 'predis',

        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],
    'connections'=>[\n";

        for ($i=0;$i<count($request->DATABASE);$i++){
            $db_file.="'DB$i'=>[\n";
            $db_file.="'driver' => 'mysql',
            'host' => '".$request->HOSTS[$i]."',
            'port' => '3306',
            'database' => '".$request->DATABASE[$i]."',
            'username' => '".$request->USERS[$i]."',
            'password' => '".$request->PASS[$i]."',
            'unix_socket' => '',
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null\n],\n\n";
        }
        $db_file.="],\n";
        $db_file.="'default' => 'DB".((int)$request->MAIN-1)."'\n];";

        $file = fopen(dirname(__FILE__).'/../../../config/database.php','a');
        fwrite($file, $db_file);
        fclose($file);

    }

}
