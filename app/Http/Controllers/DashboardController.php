<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private $folder = 'dashboard.';
    private static $folder_static = 'dashboard.';

    public function __construct()
    {
        parent::__construct();
    }

    public function preload(){
        return $this->template->render('install.preload',array('title'=>translate('dashboard')));
    }


    public function index(){
        return $this->template->render($this->folder.'start',array('title'=>translate('dashboard')));
    }
}
