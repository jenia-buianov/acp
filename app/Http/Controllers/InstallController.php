<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
class InstallController extends Controller
{
    private $folder = 'install.';

    public function preload(){

        return $this->template->render($this->folder.'start',array());

    }
}
