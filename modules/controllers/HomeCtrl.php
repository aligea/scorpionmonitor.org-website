<?php
class HomeCtrl{
	static function view(){
	    $smarty = AppModules::init_smarty();

 		$smarty->assign('dataslideshow', Slideshow_Model::getAll());
	    $smarty->assign('recentnews', Content_Model::fetch_content($rowindex = 0, $jumlah_item=6));

	    $smarty->display(basepath."/templates/$smarty->path_user/index.tpl");
	}
}
?>