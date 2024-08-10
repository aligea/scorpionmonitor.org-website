<?php
class RSS_ctrl{
	static function view(){
		include_once basepath.'/libraries/class/rss_factory.inc.php';
		$app = \Slim\Slim::getInstance();
		$app->response->headers->set('Content-Type', 'text/xml');

		 //-- ambil data setting
	   	$allsetting = izy::load('tb_settings', 1);
		$settings = json_decode($allsetting->value);

		$aStoriesRSS = array();
		$datacontent = Content_Model::artikel_terakhir(200);
		foreach ($datacontent as $iID => $value) {
			$content = (object)$value;
			$url_gambar = baseurl.'/img/resize?w=200&h=150&file='.$content->url_gambar;
			$image = sprintf('<div><img src="%s" alt="%s"></div>',
				$url_gambar,
				$content->judul);

		    $aStoriesRSS[$iID]['Guid'] = $content->id;
		    $aStoriesRSS[$iID]['Title'] = $content->title;
		    $aStoriesRSS[$iID]['Link'] = baseurl.'/content/news/'.$content->alias.'.html';
		    $aStoriesRSS[$iID]['Desc'] = $image.$content->introtext;
		    $aStoriesRSS[$iID]['DateTime'] = $content->created;
		}

		//header('Content-Type:text/xml; charset=utf-8');
		//header('Content-Type:image/jpeg');
		$oRssFactory = new RssFactory();
		echo $oRssFactory->GenRssByData(
			$aStoriesRSS, 
			$settings->nama, 
			baseurl, 
			$sRssIcon = Helper::fix_url($settings->logo));
	}
}
?>