<?php
/**
 * Created by PhpStorm.
 * User: jenia
 * Date: 04.05.2017
 * Time: 11:09
 */

namespace App\Libraries;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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

    public function render($view,$data = array(),$js = null,$target = '.body'){

		if(!isAjax()) {
				if(!empty(config('database.connections.DB0.host'))) {
                    echo $this->view('template.header', $data);
                    if (isset($_SESSION['user']) and !empty($_SESSION['user']))
                    {
                        echo $this->view('template.top_bar',$data);
                        echo $this->view('template.left_bar',$data);
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