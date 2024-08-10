<?php
class AppModules {
	function __construct(){
		$this->init_controllers();
		$this->init_routers();
	}

	static function init_controllers(){
		$folderpath = basepath.'/modules/controllers'; 
		$controller_folder = scandir($folderpath);
		foreach ($controller_folder as $file_controller) {
		  if(pathinfo($file_controller, PATHINFO_EXTENSION) == 'php'){
		    include_once $folderpath.DIRECTORY_SEPARATOR.$file_controller;
		  }
		}		
	}

	static function init_models(){
		$folderpath = basepath.'/modules/models'; 
		$foldertarget = scandir($folderpath);
		foreach ($foldertarget as $file) {
		  if(pathinfo($file, PATHINFO_EXTENSION) == 'php'){
		    include_once $folderpath.DIRECTORY_SEPARATOR.$file;
		  }
		}		
	}
	static function init_helpers(){
		$folderpath = basepath.'/modules/helpers'; 
		$foldertarget = scandir($folderpath);
		foreach ($foldertarget as $file) {
		  if(pathinfo($file, PATHINFO_EXTENSION) == 'php'){
		    include_once $folderpath.DIRECTORY_SEPARATOR.$file;
		  }
		}		
	}

	static function init_routers(){
		include basepath.'/modules/AppRouters.php';
	}

	static function init_smarty(){
		require_once basepath.'/libraries/smarty/Smarty.class.php';	

		$smarty = new Smarty;
	    //$smarty->caching = FALSE;
	    
	    $smarty->assign('waktu_server', date("F d, Y H:i:s", time()));
	    $smarty->assign('basepath', basepath);
	    $smarty->assign('baseurl', baseurl);
	    $smarty->assign('baseurlroot', baseurlroot);
	    $smarty->assign('config', $_SESSION['config']);

	    //-- ambil data setting
	   	$allsetting = izy::load('tb_settings', 1);
		$settings = json_decode($allsetting->value, true);

		$smarty->assign('settings', $settings);
		$smarty->assign('setting', $settings);
		$smarty->assign('metadesc', $settings['metadesc']);
		$smarty->assign('metakey', $settings['metakey']);
		$smarty->assign('metatitle', $settings['metatitle']);

		$_SESSION['lang'] = 'en';
		$_SESSION['path'] = 'default';

		$smarty->assign('lang', $_SESSION['lang']);
		$smarty->assign('path', $_SESSION['path']);

		$path_user =  $_SESSION['path'] = 'default';
	    $smarty->path_user = $path_user;
	    $smarty->assign("allsettings", $allsettings);
	    $smarty->assign("path_user", $path_user);
	    $smarty->assign("favico", Helper::fix_url($settings['favico']));
	    $smarty->assign("meta_keyword", $settings['metakey']);
	    $smarty->assign("meta_description", $settings['metadesc']);
	    $smarty->assign("meta_title", $settings['metatitle']);
	    $smarty->assign("runningtext", $settings["pengumuman"]);
	    $smarty->assign("logo", Helper::fix_url($settings['logo']));

	    $smarty->assign('og', array(
	    	'type'=>'website',
	    	'title'=>$settings['metatitle'],
	    	'url'=>Helper::selfURL(),
	    	'image'=>Helper::fix_url($settings['logo']),
	    	'site_name'=> $_SESSION['config']['namaperusahaan'],
	    	'description'=>$settings['metadesc']
	    ));



	    //-- matikan sistem kalo offline
	    if($settings['maintenance'] == 'offline'){
	        die('offline');
	    }

	    return $smarty;
	}
}

?>