<?php
/**
 * Created by PhpStorm.
 * User: jenia
 * Date: 04.05.2017
 * Time: 11:09
 */

namespace App\Libraries;

use App\Models\ChatModel;
use App\Models\LangModel;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\UserModel;
use App\Models\EmailModel;
use App\Models\OnlineConsultantModel;
use App\Models\NotificationModel;

class Template extends BaseController{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private static $_lang;
    private static $_response = array();
    private static $_userId = 0;
    public $template;

    function __construct()
    {
        session_start();
        $this->template = $this;
    }


    function __destruct()
    {
        if(!empty(self::$_response)){
			self::$_response = array_reverse(self::$_response);
			echo json_encode(self::$_response);
		}
    }


    public function view($view,$data){
        return view($view)->with($data)->render();
    }

    public function renderJson($data){
        self::$_response[] = $data;
    }

    public function render($view,$data = array(),$js = null,$target = '#main-content .wrapper'){

		if(!isAjax()) {
				if(!empty(config('database.connections.DB0.host'))) {
                    echo $this->view('template.header', $data);
                    if (isset($_SESSION['user']) and !empty($_SESSION['user']))
                    {
                        $_SESSION['user'] = (int)$_SESSION['user'];
                        $user = UserModel::getUserById($_SESSION['user']);
                        $data['user'] = $user;
                        $data['countOCMessages'] = OnlineConsultantModel::myNewOnlineConsultantMessages();
                        $data['countEMessages'] = EmailModel::myNewEmailMessages($_SESSION['user']);
                        $data['countCMessages'] = ChatModel::myNewChatMessages($_SESSION['user']);
                        $data['countNotifications'] = NotificationModel::myNewNotifications($_SESSION['user']);

                        $data['OCMessages'] = OnlineConsultantModel::getLastMessages(5);
                        $data['EMessages'] = EmailModel::getLastMessages($_SESSION['user'],3);
                        $data['CMessages'] = ChatModel::getLastMessages($_SESSION['user'],3);
                        $data['Notifications'] = NotificationModel::getLastNotifications($_SESSION['user'],5);
                        $data['languages'] = LangModel::getLanguages();
                        $data['titleLang'] = LangModel::getLanguageTitle(lang());
                    }
					echo $this->view($view,$data);
					echo $this->view('template.footer',$data);
				}else{
					echo $this->view('template.install',$data);
					echo $this->view($view,$data);
					echo $this->view('template.install_footer',$data);
				}
        }else {
            $action = array(
                'action'=>'load',
                'html'=>view($view)->with($data)->render(),
                'target'=>$target
            );
            if (!is_null($js) or !empty($js)) $action['js'] = $js;
            $this->renderJson($action);
        }
        return ;
    }



}