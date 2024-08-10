<?php
define('with_watermark', false);
class ImageCtrl extends AppModules{
	static function show_image($filename = ""){
		$app = \Slim\Slim::getInstance();
		$app->response->headers->set('Content-Type', 'image/jpg');
		
		if($filename == ""){
			$filename = $app->request->params('file');
		}
		$filename = Helper::get_filename($filename);
		$pathfile = Helper::fix_path($filename);
		return self::outputImage($pathfile);
	}
	static function resize(){
		require basepath.'/libraries/class/classimage.php';
		$app = \Slim\Slim::getInstance();
		$app->response->headers->set('Content-Type', 'image/jpg');
	   
	    $width = $_GET['w'];
	    $height = $_GET['h'];
		$source = Helper::get_filename($_REQUEST['file']);
		if($source == ''){
			return $source;
		}
		$source = Helper::fix_url($source); 
		$sourcepath = Helper::fix_path($source);
		$cache_directory = self::create_temp_directory($width, $height);
		$cache_filename = self::create_cache_file($source);
		$cache_path = $cache_directory.'/'.$cache_filename;//-- bentuk path local komputer/bukan url
	
		if(is_file($cache_path)){
			return self::outputImage($cache_path);
		}

		$img = new SimpleImage;
		$img->load($sourcepath);
		$img->resize($width, $height);
		$img->save($cache_path);
		$img->output();
	}
	static function create_temp_directory($width, $height){
		//-- jika folder images/ temp tidak ada, maka create folder tsb dulu
		if(!is_dir(basepath.'/images/temp')){
			mkdir(basepath.'/images/temp');
		}

		//-- sesuaikan nama folder dengan ukuran gambar
		$foldername = $width.'x'.$height;
		$directory_path = basepath.'/images/temp/'.$foldername;
		if(!is_dir($directory_path)){
			mkdir($directory_path);
		}
		return $directory_path;
	}
	static function create_cache_file($source){
		//-- sesuaikan nama file gambar yang baru
		$uniqmaker = md5($source);
		$filename = $uniqmaker.'_'.Helper::friendlyString(pathinfo($source, PATHINFO_FILENAME));
		$newfilename = $filename.'.'.pathinfo($source, PATHINFO_EXTENSION);
		return $newfilename;
	}
	
	//-- yang lama karna bugs; (11-05-2020); nama file bisa double;
	static function create_cache_file_lama($source){
		//-- sesuaikan nama file gambar yang baru
		$uniqmaker = substr(crypt($source, 'izy'), 0, 8);
		$filename = $uniqmaker.'_'.Helper::friendlyString(pathinfo($source, PATHINFO_FILENAME));
		$newfilename = $filename.'.'.pathinfo($source, PATHINFO_EXTENSION);
		return $newfilename;
	}
	
	static function outputImage($outputfile){
		if(with_watermark){
			return self::outputImage_with_watermark($outputfile);
		}
		//$outputfile = Helper::fix_url($outputfile);
		$outputfile = Helper::fix_path($outputfile);
		header('Content-Type:image/jpeg');
		//header('Content-Length: ' . filesize($outputfile));
		readfile($outputfile);
	}
	static function outputImage_with_watermark($outputfile){
		$outputfile = Helper::fix_path($outputfile);
		$image_info = getimagesize($outputfile);
		$image_type = $image_info[2];
		if($image_type == IMAGETYPE_JPEG ) {
         	$imagetobewatermark = imagecreatefromjpeg($outputfile);
      	} elseif($image_type == IMAGETYPE_GIF ) {
         	$imagetobewatermark = imagecreatefromgif($outputfile);
      	} elseif($image_type == IMAGETYPE_PNG ) {
        	$imagetobewatermark = imagecreatefrompng($outputfile);
      	}
		$watermarktext = $_SESSION['config']['namaperusahaan'];
		$font =  basepath.'/libraries/fonts/chocolate_covered_raindrops/ChocolatCoveredRaindrops.ttf';
		
		$fontsize = "10";
		$white = imagecolorallocate($imagetobewatermark, 255, 255, 255);

		//-- membuat text di pojok kanan bawah
		$angle = 0;$x=0;$y=10;
		$width = imagesx($imagetobewatermark);
		$height = imagesy($imagetobewatermark);
		$y = $height - 5;
		$x = $width - 165;

		imagettftext($imagetobewatermark, $fontsize, $angle, $x, $y, $white, $font, $watermarktext);
		header("Content-type:image/png");
		imagepng($imagetobewatermark);
		imagedestroy($imagetobewatermark);		
	}




}

?>