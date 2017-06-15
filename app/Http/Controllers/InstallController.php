<?php

namespace App\Http\Controllers;

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
        return $this->template->render($this->folder.'start',array(),url('assets/custom/js/install.js'));
    }
}
