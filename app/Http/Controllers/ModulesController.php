<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use App\Models\ModulesModel;
use App\Models\UserModel;

class ModulesController extends Controller
{

    public function openModule(Request $request)
    {
        $_SESSION['user'] = (int)$_SESSION['user'];
        $user = UserModel::getUserById($_SESSION['user']);
        $module = ModulesModel::getModuleByPage(htmlspecialchars($request->name,3),$user->groupId,$_SESSION['user']);
        if (!count($module)){

            $this->template->render(DashboardController::$folder_static.'start',array('title'=>translate('dashboard')));
            $this->template->renderJson(array(
                'action'=>'notification',
                'text'=>translate('no_access_to_module'),
                'type'=>'danger'
            ));
            return ;
        }

        $class = (string)$module->controller.'Controller';
        app('App\Http\Controllers\\'.$class)->startModule($module->title,$request);
    }

    public function startAction(Request $request)
    {
        $_SESSION['user'] = (int)$_SESSION['user'];
        $user = UserModel::getUserById($_SESSION['user']);
        $module = ModulesModel::getModuleByPage(htmlspecialchars($request->name,3),$user->groupId,$_SESSION['user']);
        if (!count($module)){

            $this->template->render(DashboardController::$folder_static.'start',array('title'=>translate('dashboard')));
            $this->template->renderJson(array(
                'action'=>'notification',
                'text'=>translate('no_access_to_module'),
                'type'=>'danger'
            ));
            return ;
        }

        $class = (string)$module->controller.'Controller';
        $action = (string)$request->action;
        app('App\Http\Controllers\\'.$class)->$action($request);
    }
}