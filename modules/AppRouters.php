<?php

$app = \Slim\Slim::getInstance();

/*
  $app->get('/', 'mainPage');
  $app->get('/:alias', 'contentPage');
  $app->get('/newslist', 'newsPage');
  $app->get('/content/news/:alias', 'contentPage');
  $app->get('/page/:alias', 'singlePage');
  $app->get('/registration-volunteer.html', 'volunteerPage');
  $app->post('/volunteer/validate', 'validate_registration');
  $app->post('/volunteer/insert', 'insert_volunteer');
 */

$app->get('/', 'HomeCtrl::view');
$app->get('/newslist', 'ContentCtrl::view');
$app->get('/news/', 'ContentCtrl::view');
$app->get('/content/news/:alias', 'ContentCtrl::detail');
$app->map('/content/:pid/:type/:title', 'ContentCtrl::detail_v2')->via('POST', 'GET');
$app->get('/news/:title_prefix', 'ContentCtrl::detail_v3');
$app->get('/page/:alias', 'ContentCtrl::singlePage');

$app->get('/newslist/:tahun', 'ContentCtrl::view');
$app->get('/newslist/:tahun/:bulan', 'ContentCtrl::view');

$app->get('/search', 'ContentCtrl::view');

$app->get('/registration-volunteer.html', 'VolunteerCtrl::view');
$app->post('/volunteer/validate', 'VolunteerCtrl::validate');
$app->post('/volunteer/insert', 'VolunteerCtrl::insert');


$app->get('/captcha_large', 'CaptchaCtrl::show_captcha_large');
$app->get('/captcha_small', 'CaptchaCtrl::show_captcha_small');
$app->get('/captcha/value', 'CaptchaCtrl::show_value');

$app->get('/img/resize', 'ImageCtrl::resize');
$app->get('/img/:filename', 'ImageCtrl::show_image');
$app->get('/img/resource', 'ImageCtrl::show_image');

$app->map('/rss', 'RSS_ctrl::view')->via('POST', 'GET');
$app->map('/rssfeed', 'RSS_ctrl::view')->via('POST', 'GET');
$app->map('/rssfeed/', 'RSS_ctrl::view')->via('POST', 'GET');
$app->map('/rss.xml', 'RSS_ctrl::view')->via('POST', 'GET');


$app->map('/newsletter/unsubscribe', 'NewsletterCtrl::unsubscribe')->via('POST', 'GET');
$app->map('/newsletter/autosend', 'NewsletterCtrl::autosend')->via('POST', 'GET');
$app->map('/newsletter/register', 'NewsletterCtrl::register')->via('POST', 'GET');

$app->post('/api/fake_filename', function() {
   $app = \Slim\Slim::getInstance();
   $request = $app->request();

   echo Helper::create_fake_filename($request->params('file'));
});

$app->get('/fix', function() {
   $datacontent = izy::findAll('tb_content');
   foreach ($datacontent as $content) {
      if ($content->metakey == "") {
         $content->metakey = $content->title;
      }
      if ($content->metadesc == "") {
         $content->metadesc = $content->introtext;
      }
      izy::store($content);
   }
   echo 'done';
});

//-- letakkan ini di bawah, bikin bug aja
$app->get('/:alias', 'ContentCtrl::detail');
