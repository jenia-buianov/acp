<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            $this->template->renderJson(array('action'=>'delete','target'=>'a'));
            $this->template->renderJson(array(
                'action'=>'add',
                'target'=>'text:eq(2)',
                'html'=>'<button class="btn btn-danger" type="button"  style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em" onclick="next(3)">'.__('install.next').'</button>'
            ));
            if((int)$request->selected==1){


                // IF ISSET DATABASE

                $request->main = (int)$request->main-1;
                $html = __('install.db_select',['s'=>$request->hosts[(int)$request->main].'.'.$request->db[(int)$request->main]]).'';
                $post = http_build_query(array(
                    'host'=>$request->hosts[(int)$request->main],
                    'user'=>$request->users[(int)$request->main],
                    'db'=>$request->db[(int)$request->main],
                    'pass'=>$request->pass[(int)$request->main]
                ));

                $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, url('select.php'));
                curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($curl, CURLOPT_POST, true);
                curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
                $out = curl_exec($curl);
                $resp = json_decode($out);

                //print_r($out);
                //exit;
                if (isset($resp->noTables) and $resp->noTables==1){
                    $html.='<div class="bg-danger" id="alert" style="display: block">'.__('install.not_found_tables').'</div>';
                }
                else{
                    $html.='<div style="margin-top: 2em"></div>'.$resp->tables;
                }

                $html.='<button class="btn btn-danger" type="submit" style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em">'.__('install.finish').'</button>';
                $this->template->renderJson(array('action'=>'update','target'=>'text:eq(3) p','html'=>$html));

                //END IF ISSET DATABASE


            }else{

                // IF NOT ISSET DATABASE
                $this->template->renderJson(array('action'=>'add','target'=>'text:eq(3) p','html'=>'<button class="btn btn-danger" type="submit" style="position: absolute; bottom: 0px; right: 2em;margin-bottom: 2em">'.__('install.finish').'</button>'));
                $this->template->renderJson(array('action'=>'update','target'=>'text:eq(3) p',
                    'html'=>__('install.step4').'<br>
                    <br>
                    <div class="bg-danger" id="alert"></div>

                    <div class="form-group">
                        <label class="sr-only">'.__('install.name').'</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-male" aria-hidden="true"></i>
                            </div>
                            <input type="text" class="form-control" name="adminName" placeholder="'.__('install.name').'" must="1" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only">'.__('install.login').'</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-user" aria-hidden="true"></i>
                            </div>
                            <input type="text" class="form-control" name="adminLogin" value="admin" placeholder="'.__('install.login').'" must="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only">'.__('install.email').'</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                            </div>
                            <input type="email" class="form-control" name="adminEmail" value="" placeholder="'.__('install.email').'" must="1">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="sr-only">'.__('install.password').'</label>
                        <div class="input-group">
                            <div class="input-group-addon">
                                <i class="fa fa-key" aria-hidden="true"></i>
                            </div>
                            <input type="password" class="form-control" name="adminPassword" placeholder="'.__('install.password').'" must="1">
                        </div>
                    </div>'
                ));
            }
        }
        return ;
    }

    function lastStep(Request $request){

        $response = array('error'=>'','html'=>'');

        //if ($request->values['name']!==0)
        $data = makeData(array(),array(),$request->values,$response,array(),array('user[]','password[]','databases[]','host[]'),array('db'));
        if ($data['db']==0){
            $must = array('name','email','url','db','adminName','adminEmail','adminPassword','adminLogin');
        }
        else $must = array('name','email','url','db');

        $data = makeData($must,array(),$request->values,$response,array(),array('user[]','password[]','databases[]','host[]'),array('db'));
        $response = array('error'=>'','html'=>'');
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

        $db_file = "<?php \n return [
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

        $file = fopen(dirname(__FILE__).'/../../../config/database.php','w');
        fwrite($file, $db_file);
        fclose($file);

        DB::table('acp_users')->insert(array('groupId'=>1,'lang'=>App::getLocale(), 'login'=>$data['adminLogin'],'email'=>$data['adminEmail'],'password'=>bcrypt($data['adminPassword']),'name'=>$data['adminName']));
        rename(dirname(__FILE__).'/../../../web.php',dirname(__FILE__).'/../../../routes/web.php');
        $this->template->renderJson(array('action'=>'redirect','href'=>'/'));

    }

    function rows(Request $request){
        $post = http_build_query(array(
            'host'=>$request->host,
            'user'=>$request->user,
            'db'=>$request->db,
            'pass'=>$request->pass,
            'table'=>$request->table,
            'sel'=>$request->sel
        ));

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, url('row.php'));
        curl_setopt($curl, CURLOPT_ENCODING, "gzip, deflate");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        $out = curl_exec($curl);
        $resp = json_decode($out);
        $this->template->renderJson(array('action'=>'css','target'=>'.rows_'.$request->table,'css'=>array('display'=>'block')));
        $this->template->renderJson(array('action'=>'update','target'=>'.rows_'.$request->table,'html'=>$resp->r));
    }

}
