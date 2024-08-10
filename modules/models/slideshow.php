<?php
class Slideshow_Model{
	static function getAll(){
		$slideshow = array();
		$folderpath = basepath.'/images/slideshow'; 
		$image_folder = scandir($folderpath);
		foreach ($image_folder as $file) {
		  $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
		  if($ext == 'jpg' || $ext == 'png' || $ext =='jpeg'){
		  	$fakefile = Helper::create_fake_filename(baseurl.'/images/slideshow/'.$file);
		  	
		  	/*
		  	* diubah pada 2023-02-18
		  	* yang lama --> $slideshow[] = baseurl.'/img/resize?w=970&h=300&file='.$fakefile;
		  	* ini karna file jelek sangat terkompress		  	
		  	*/
		  	
		  	$slideshow[] = baseurl.'/img/resize?w=970&h=400&file='.$fakefile;
		  	//$slideshow[] = baseurl.'/img/'.$fakefile;
		  }
		  
		}
		



		//$slideshow[] = baseurl.'/img/resize?w=970&h=300&file=[baseurlroot]/images/slideshow/1.jpg';
		//$slideshow[] = baseurl.'/img/resize?w=970&h=300&file=[baseurlroot]/images/slideshow/2.jpg';
		return $slideshow;
	}

}
?>