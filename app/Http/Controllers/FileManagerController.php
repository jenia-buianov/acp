<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;

class FileManagerController extends Controller
{
    public static $folder_static = 'filemanager.';
    public $folder = 'filemanager.';
    private $Editextensions = array('html','php','txt','css','js','sql');
    public $extensions = array('xls','xlsx','php','html','jpg','png','jpeg','bmp','tif','psd','docx','mp3','flac','mp4','wav','mpeg','mov','wmv','avi','mkv','flv','mpg','3gp', 'wma','txt','css','js','zip','rar','gz');
    public $icons = array('file-excel-o','file-excel-o','code','code','file-image-o','file-image-o','file-image-o','file-image-o','file-image-o','file-image-o','file-word-o','file-audio-o','file-audio-o','file-video-o','file-video-o','file-video-o','file-video-o','file-video-o','file-video-o','file-video-o','file-video-o','file-video-o','file-video-o','file-audio-o','file-text','code','code','file-archive-o','file-archive-o','file-archive-o');



    protected function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' kB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }
        return $bytes;
    }

    protected function getFiles($path){
        if ($path!=='.') $dir = opendir(dirname(__FILE__)."/../../../".$path);
        else $dir = opendir(dirname(__FILE__)."/../../../");

        $files_ = $icon = $url = $size = $post = array();
        while($name = readdir($dir))  $files_[] = $name;
        sort($files_);
        foreach($files_ as $key=>$name)
        {
            if (is_file(dirname(__FILE__)."/../../../".$path.'/'.$name))
            {
                $getExtenstion = explode('.',$name);
                if (in_array($getExtenstion[count($getExtenstion)-1],$this->extensions)) $icon[] = $this->icons[array_search($getExtenstion[count($getExtenstion)-1],$this->extensions)];
                else $icon[] = 'file-o';
                $size[] = $this->formatSizeUnits((int)filesize(dirname(__FILE__)."/../../../".$path.'/'.$name));
                $ph = 'module/filemanager/download';
                $post[] = data_to_attribute(array('path'=>mb_substr(urlencode($path.'/'.$name),1)));
            }
            else {
                $post[] = data_to_attribute(array('path'=>urlencode($path.'/'.$name)));
                $ph = 'module/filemanager/open';
                $icon[] = 'folder';
                $size[] = '-';
            }

            $url[] = $ph;
        }
        return array(
            'path'=>$path,
            'url'=>$url,
            'size'=>$size,
            'files'=>$files_,
            'icon'=>$icon,
            'post'=>$post
        );
    }


    public  function startModule($title, Request $request){


        if (!empty($request->path)) $path = urldecode($request->path);
        else $path = '.';
        $response = $this->getFiles($path);
        $response['title'] = translate($title);

        $this->render($this->folder.'index', $response,url('assets/custom/js/filemanager.js'),'',translate($title));
        $this->setShow(0);
    }

    public function info(Request $request){
        if (!empty($request->path)) $path = urldecode($request->path);
        else $path = '.';

        if ($path!=='.') $dir = opendir(dirname(__FILE__)."/../../../".$path);
        else $dir = opendir(dirname(__FILE__)."/../../../");

        $files_ = $icon = $url = $size = $post = array();
        while($name = readdir($dir))  $files_[] = $name;
        sort($files_);
        $icon = $size = '';
        if(isset($request->file) and !empty($request->file)) $file = htmlspecialchars($request->file,3);
        else $file = htmlspecialchars($request->q,3);
        foreach($files_ as $key=>$name) {
            if ($name==$file){
                if (is_file(dirname(__FILE__) . "/../../../" . $path . '/' . $name)) {
                    $getExtenstion = explode('.',$name);
                    if (in_array($getExtenstion[count($getExtenstion)-1],$this->extensions)) $icon = $this->icons[array_search($getExtenstion[count($getExtenstion)-1],$this->extensions)];
                    else $icon = 'file-o';
                    $size = $this->formatSizeUnits((int)filesize(dirname(__FILE__)."/../../../".$path.'/'.$name));
                }else {
                    $size = '-';
                    $icon = 'folder';
                }
            }
        }

        $this->renderJson(array('action'=>'update','target'=>'#fileInfo','html'=>view($this->folder.'info')->with(
            array(
                'file'=>$path . '/' . $file,
                'name'=>$file,
                'path'=>$path,
                'size'=>$size,
                'icon'=>$icon
            ))->render()));
        $this->setShow(0);
    }

    public function open(Request $request){
        if (!empty($request->path)) $path = urldecode($request->path);
        else $path = '.';
        $this->renderJson(array('action'=>'update','target'=>'#DivFileManager','html'=>view($this->folder.'files')->with($this->getFiles($path))->render()));
        $this->renderJson(array('action'=>'setValue','target'=>'#path','val'=>$path));
        $this->setShow(0);
    }

    public function folder(Request $request){
        if (!empty($request->path)) $path = urldecode($request->path);
        else $path = '.';
        $name = htmlspecialchars($request->folder,3);
        if (is_dir(dirname(__FILE__) . "/../../../" . $path . '/' . $name)) {
                $this->renderJson(array(
                    'action'=>'notification',
                    'text'=>translate('folder_exist'),
                    'type'=>'danger'
                ));
                $this->setShow(0);
                return ;
        }
        mkdir(dirname(__FILE__) . "/../../../" . $path . '/' . $name,0700);
        $this->renderJson(array(
            'action'=>'notification',
            'text'=>translate('folder_created').' '.$name,
            'type'=>'success'
        ));

        $this->renderJson(array('action'=>'update','target'=>'#DivFileManager','html'=>view($this->folder.'files')->with($this->getFiles($path))->render()));
        $this->setShow(0);
    }

    public function upload(Request $request){
        if (!empty($_FILES['file']))
        {
            if ($_POST['path']=='.') $_POST['path'] = '';
            $file = $_FILES['file']['tmp_name'];
            $filename = $_FILES['file']['name'];
            if(!empty($file)) {
                ini_set('memory_limit', '32M');
                $maxsize = "100000000";
                $size = filesize($_FILES['file']['tmp_name']);
                $ext = explode('.',$filename);
                $nName = array();
                for ($i=0;$i<count($ext)-1;$i++){
                    $nName[] = $ext[$i];
                }
                $new = str2url(implode($nName)).'.'.$ext[count($ext)-1];
                $to = dirname(__FILE__).'/../../../'.$_POST['path'].$new;
                if ($size<=$maxsize) {
                    copy($file, $to);
                    $this->renderJson(array(
                        'action'=>'notification',
                        'text'=>translate('uploaded').' '.$new,
                        'type'=>'success'
                    ));
                    $this->renderJson(array('action'=>'update','target'=>'#DivFileManager','html'=>view($this->folder.'files')->with($this->getFiles($_POST['path']))->render()));
                    $this->setShow(0);
                    return ;
                }
                else {
                    $this->renderJson(array(
                        'action'=>'notification',
                        'text'=>translate('too_big'),
                        'type'=>'danger'
                    ));
                    $this->setShow(0);
                    return ;
                }
            }
            exit;
        }
    }

    public function download(Request $request)
    {
        if ($request->isMethod('post')){
            $this->renderJson(array('action'=>'redirect','href'=>url('module/filemanager/download/?path='.$request->path)));
            $this->setShow(0);
            return ;
        }
        $file = urldecode(htmlspecialchars($request->path, 3));
        $type = explode('/', $file);
        $fn = explode('.', $type[count($type) - 1]);
        $filename = $url = array();
        for ($i = 0; $i < count($fn) - 1; $i++)
        $filename[] = $fn[$i];
        for ($i = 0; $i < count($type) - 1; $i++)
            if(!empty($type[$i]) and $type[$i]!=='.') $url[] = $type[$i];

        $filename = implode('.',$filename).'.'.$fn[count($fn)-1];

        return response()->download(storage_path('/../'.$file), $filename);
    }

    public function search(Request $request){
        if (!empty($request->path) and $request->path!='.') $path = mb_substr(urldecode($request->path),1);
        else $path = '';
        $query = htmlspecialchars($request->q,3);
        if (!empty($query)) $query = dirname(__FILE__) . "/../../../" . $path."/*$query*";
        else {
            $this->open($request);
            return ;
        }

        foreach (glob($query) as $filename) {
            $fname = explode('/',$filename);
            $name = $fname[count($fname)-1];
            $files_[] = $name;
            if (is_file($filename)) {
                $getExtenstion = explode('.', $filename);
                if (in_array($getExtenstion[count($getExtenstion) - 1], $this->extensions)) $icon[] = $this->icons[array_search($getExtenstion[count($getExtenstion) - 1], $this->extensions)];
                else $icon[] = 'file-o';
                $size[] = $this->formatSizeUnits((int)filesize($filename));
                $ph = 'module/filemanager/download';
                $post[] = data_to_attribute(array('path' => mb_substr(urlencode($path.'/'.$name), 1)));
            }
            else {
                    $post[] = data_to_attribute(array('path'=>urlencode($path.'/'.$name)));
                    $ph = 'module/filemanager/open';
                    $icon[] = 'folder';
                    $size[] = '-';
                }
            $url[] = $ph;
        }

        if(!empty($files_))
        $this->renderJson(array('action'=>'update','target'=>'#DivFileManager','html'=>view($this->folder.'files')->with(
            array(
                'path'=>$path,
                'url'=>$url,
                'size'=>$size,
                'files'=>$files_,
                'icon'=>$icon,
                'post'=>$post
            ))->render()));
        else $this->renderJson(array('action'=>'update','target'=>'#DivFileManager','html'=>translate('not_found')));
        $this->setShow(0);
    }

    public function rename(Request $request){
        if (!empty($request->path)) $path = urldecode($request->path);
        else $path = '.';
        if (!is_file(dirname(__FILE__) . "/../../../" . $path."/".htmlspecialchars($request->old,3)) and !is_dir(dirname(__FILE__) . "/../../../" . $path."/".htmlspecialchars($request->old,3)))
            return ;
        rename(dirname(__FILE__) . "/../../../" . $path."/".htmlspecialchars($request->old,3),dirname(__FILE__) . "/../../../" . $path."/".htmlspecialchars($request->q,3));
        $this->open($request);
        $this->info($request);

    }

}