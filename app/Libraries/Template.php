<?php
/**
 * Created by PhpStorm.
 * User: jenia
 * Date: 04.05.2017
 * Time: 11:09
 */

namespace App\Libraries;

class Template{

    private static $_lang;
    private static $_response = array();
    private static $_userId = 0;



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

    public function render($view,$data = array()){

		if(!isAjax()) {
				if(!empty(config('database.connections.DB1.host'))){
					echo $this->view('template.header',$data);
					echo $this->view($view,$data);
					echo $this->view('template.footer',$data);
				}else{
					echo $this->view('template.install',$data);
					echo $this->view($view,$data);
					echo $this->view('template.install_footer',$data);
				}
        }else {
            $this->renderJson(array('action'=>'load','html'=>view($view)->with($data)->render()));
        }
        return ;
    }



}