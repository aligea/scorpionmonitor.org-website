<?php
session_start();

require 'config.php';
require 'libraries/class/izyredbean.php';
require 'libraries/Slim-2.6.2/Slim/Slim.php';
require 'modules/app-module.php';

$app = new \Slim\Slim();

$app->hook('slim.before', 'initApp');
$app->hook('slim.before.dispatch', 'authLoginUser');

//-- load module yang di request
$path = explode('/', $app->request()->getResourceUri());
$module_folder = basepath.'/modules/'.$path[1];
if(is_dir($module_folder)){
	//echo $module_folder;
	$filelist = scandir($module_folder);
	foreach ($filelist as $file) {
		if(pathinfo($file, PATHINFO_EXTENSION) == 'php'){
			include_once $module_folder.'/'.$file;
		}
	}	
}

$app->map('/uploadimage', function(){
    $parent_dir = realpath(basepath.'/..');
    $target_dir = $parent_dir.'/images/uploads';
    if(!is_dir($target_dir)){
        mkdir($target_dir);
    }
	 $target_dir = $parent_dir.'/images/uploads/'.date('Y-m-d');
	 if(!is_dir($target_dir)){
        mkdir($target_dir);
    }
	 
    $filename = pathinfo($_FILES['file']['name'], PATHINFO_FILENAME);
    //$filename = md5(rand(100, 200));
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
    $target_file = $target_dir.'/'.$filename.'.'.$ext;
	 
	 /*
	 //-- biar gak double
	 if(is_file($target_file)){
		$oldfilename = $filename;
		$newfilename = $filename.'_'.time();
		$target_file = $target_dir.'/'.$newfilename.'.'.$ext;
	 }
	 */
	 
    if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)){
        echo str_replace($parent_dir, baseurlroot, $target_file);
    }else{
        echo "Sorry, there was an error uploading your file.";
    }  

})->via('POST', 'GET')->name('novalidate');




$app->run();
?>