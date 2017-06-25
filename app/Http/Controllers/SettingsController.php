<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\StandardModel;

class SettingsController extends Controller
{
    public function allSettings(Request $request){
        $fnc =  $request->name;
        $this->$fnc($request);
    }

    private function smtp(Request $request){

        $response = array('error'=>'','html'=>'');
        $data = makeData(array('host','port','con','user','password'),array('host'=>'smtp_host','port'=>'smtp_port','con'=>'smtp_type','user'=>'smtp_username','password'=>'smtp_password'), $request->values,$response);
        if (!empty($response['error']))
        {
            $this->template->renderJson(array(
                'action'=>'notification',
                'title'=>__('install.not_all'),
                'text'=>$response['error'],
                'type'=>'danger'
            ));
            return ;
        }

        foreach ($data as $k=>$v){
            StandardModel::insertValue($k,$v);
        }
        return $this->template->renderJson(array('action'=>'delete','target'=>'modal'));

    }
}