<?php
class CaptchaCtrl{
	static function show_captcha_large(){
		include_once basepath.'/libraries/securimage/securimage.php';
		$app = \Slim\Slim::getInstance();
		$app->response->headers->set('Content-Type', 'image/jpg');

		$img = new securimage();
		$img->ttf_file = basepath.'/libraries/securimage/elephant.ttf';
		$img->image_width = 145;
		$img->image_height = 40;
		$img->code_length = 4;
		$img->font_size = 24;
		$img->text_angle_minimum = -20;
		$img->text_angle_maximum = 20;

		$img->show();
		$_SESSION['captcha_large'] = $img->getCode();
	}

	static function show_captcha_small(){
		include_once basepath.'/libraries/securimage/securimage.php';
		$app = \Slim\Slim::getInstance();
		$app->response->headers->set('Content-Type', 'image/jpg');

		$img = new securimage();
		$img->ttf_file = basepath.'/libraries/securimage/elephant.ttf';
		$img->image_width = 56;
		$img->image_height = 26;
		$img->code_length = 2;
		$img->font_size = 16;
		$img->text_angle_minimum = 0;
		$img->text_angle_maximum = 0;
		$img->draw_lines = false;
		$img->draw_lines_over_text = false;
		$img->arc_linethrough = false;


		$img->show();
		$_SESSION['captcha_small'] = $img->getCode();
	}	

	static function validate_captcha_large($word){
		if(strtolower($word) == strtolower($_SESSION['captcha_large'])){
			return true;
		}else{
			return false;
		}
	}
	static function validate_captcha_small($word){
		if(strtolower($word) == strtolower($_SESSION['captcha_small'])){
			return true;
		}else{
			return false;
		}
	}
	static function show_value(){
		//echo $_SESSION['securimage_code_value'];
		//print_r($_SESSION);
		var_dump($config);
	}
}
?>