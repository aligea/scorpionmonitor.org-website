<?php
if (!defined('basepath')) {
	exit('<!DOCTYPE html><html><head><title>403 Forbidden</title></head><body><p>Directory access is forbidden.</p></body></html>');
}

//-- router
$app->get('/', 'mainPage');
$app->get('/:alias', 'contentPage');
$app->get('/newslist', 'newsPage');
$app->get('/content/news/:alias', 'contentPage');
$app->get('/page/:alias', 'singlePage');
$app->get('/registration-volunteer.html', 'volunteerPage');
$app->post('/volunteer/validate', 'validate_registration');
$app->post('/volunteer/insert', 'insert_volunteer');


//-- controller
function mainPage(){
	require_once basepath.'/libraries/smarty/Smarty.class.php';
    
    $smarty = newSmarty();
 
    $recentnews = fetchLastNews();

    $smarty->assign('nav_index', 'active');
    $smarty->assign('recentnews', $recentnews);
    $smarty->display(basepath."/templates/".$_SESSION['path']."/index.tpl");
}

function volunteerPage(){
    require_once basepath.'/libraries/smarty/Smarty.class.php';
    
    $smarty = newSmarty();
    $content = izy::getRow("SELECT * FROM tb_content WHERE type='page' AND state=1 AND alias=?", array('volunteer-info'));

    $smarty->assign('content', $content);

    $smarty->assign('metadesc', $content['metadesc']);
    $smarty->assign('metakey', $content['metakey']);
    $smarty->assign('metatitle', $content['title']);

    $smarty->assign('nav_volunteer', 'active');
    $smarty->display(basepath."/templates/".$_SESSION['path']."/volunteer.tpl");
}

function contentPage($aliashtml){
 	require_once basepath.'/libraries/smarty/Smarty.class.php';

    $smarty = newSmarty();

    $alias = str_replace('.html', '', $aliashtml);
    $content = izy::getRow("SELECT * FROM tb_content WHERE type='news' AND state=1 AND alias=?", array($alias));
    if(!$content){
    	$app = \Slim\Slim::getInstance();
        $app->pass();
    }
    izy::exec('update tb_content set hits=hits+1 where id=?', array($content['id']));

    $newslist = fetchLastNews();

    $smarty->assign('newslist', $newslist);
    $smarty->assign('content', $content);

    $smarty->assign('metadesc', $content['metadesc']);
    $smarty->assign('metakey', $content['metakey']);
    $smarty->assign('metatitle', $content['title']);
    $smarty->assign('nav_newslist', 'active');
    $smarty->display(basepath."/templates/".$_SESSION['path']."/content.tpl");
}

function singlePage($aliashtml){
    require_once basepath.'/libraries/smarty/Smarty.class.php';

    $smarty = newSmarty();

    $alias = str_replace('.html', '', $aliashtml);
    $content = izy::getRow("SELECT * FROM tb_content WHERE type='page' AND state=1 AND alias=?", array($alias));
    if(!$content){
        $app = \Slim\Slim::getInstance();
        $app->pass();
    }
    izy::exec('update tb_content set hits=hits+1 where id=?', array($content['id']));

    $active_nav = array();
    $active_nav[$content['alias']] = 'active';

    $smarty->assign('content', $content);

    $smarty->assign('metadesc', $content['metadesc']);
    $smarty->assign('metakey', $content['metakey']);
    $smarty->assign('metatitle', $content['title']);
    $smarty->assign('active_nav', $active_nav);
    $smarty->display(basepath."/templates/".$_SESSION['path']."/page.tpl");
}

function newsPage(){
	include basepath.'/libraries/PHP-Pagination-master/Pagination.class.php';
	require_once basepath.'/libraries/smarty/Smarty.class.php';

    $smarty = newSmarty();

    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;
	$rpp = 6;

	$sql = "SELECT COUNT(id) as numrow FROM tb_content WHERE type='news' AND state=1 ORDER BY created DESC ";
	$row1 = izy::getRow($sql);
	$totaldata = (int)$row1['numrow'];

	$startpage = ($page == 1)? 0 : ($page * $rpp) - $rpp;
	$sql = "SELECT id, alias, title, introtext, images, created 
		FROM tb_content WHERE type='news' ORDER BY publish_up DESC, id DESC LIMIT $startpage, $rpp";
	$newsdata = izy::getAll($sql);

	//-- penyesuaian gambar
	foreach ($newsdata as $key => $value) {
    	$newsdata[$key]['image_small'] = resizeImage($newsdata[$key]['images'], $width=200, $height=150);
    }

	 // instantiate; set current page; set number of records
    $pagination = (new Pagination());
    $pagination->setCurrent($page);
    $pagination->setTotal($totaldata);
	$pagination->setRPP($rpp);

    // grab rendered/parsed pagination markup
    $markup = $pagination->parse();

	$smarty->assign('newsdata', $newsdata);
    $smarty->assign('pagination', $markup);
    $smarty->assign('nav_newslist', 'active');
    $smarty->display(basepath."/templates/".$_SESSION['path']."/newslist.tpl");
}

function validate_registration(){
    /*$app = \Slim\Slim::getInstance();
    $request = $app->request();
    $id = $request->params('id');*/

  $email = $_REQUEST['email'];

    $arrayToJs = array();
    $i = 0;
    
    $row = izy::findOne('tb_volunteer', 'email=?', array($email));

    if($row->id >0){
        $arrayToJs[$i][0] = 'email';
        $arrayToJs[$i][1] = false;
        $arrayToJs[$i][2] = "This name is already taken.!";
    }else{
        $arrayToJs[$i][0] = 'email';
        $arrayToJs[$i][1] = true;
    }
    
    echo json_encode($arrayToJs);
  exit();
}

function insert_volunteer(){
  $obj = izy::dispense('tb_volunteer');
  $obj->email = $_REQUEST['email'];
  $obj->nama = $_REQUEST['nama'];
  $obj->kelamin = $_REQUEST['kelamin'];
  $obj->alamat = $_REQUEST['alamat'];
  $obj->kota = $_REQUEST['kota'];
  $obj->telp = $_REQUEST['telp'];
  $obj->tgldaftar = date("Y-m-d G:i:s");
  $obj->info = $_REQUEST['info'];

  $result = "";
  izy::begin();
  try {
    $data_id = izy::store($obj);
    
    izy::commit();

    send_email_to_owner($obj);
    send_email_to_volunteer($obj);


    $result = 'berhasil';
  } catch(Exception $e) {
    izy::rollback();
    $result = $e->getMessage();
  }
  echo $result;
  exit();
}

function send_email_to_volunteer($myVolunteer = stdClass){
  $temp = izy::findOne('tb_content', "alias='greeting-volunteer'");


  $to  = $myVolunteer->email;

  // subject
  $subject = $temp->title;

  // message
  $message = $temp->fulltext;

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  //$headers .= 'From: SCORPION-THE WILDLIFE TRADE MONITORING GROUP' . "\r\n";

  // Mail it
  mail($to, $subject, $message, $headers);
};
function send_email_to_owner($myVolunteer = stdClass){
  // multiple recipients
  $to  = 'info@scorpionmonitor.org' . ', '; // note the comma
  $to .= 'gununggea@gmail.com' . ', '; // note the comma
  $to .= 'alibangungea@gmail.com';

  // subject
  $subject = 'Volunteer Registration '.date("d M, Y G:i:s");

  // message
  $message = '
  <html>
  <head>
    <title>Volunteer Registration</title>
  </head>
  <body>
    <p>The information from registered volunteer on website, '.$myVolunteer->tgldaftar.' </p>
    <table cellpadding="2" cellspacing="2" border="0" width="750">
      <tr>
        <td width="100">Email</td>
        <td>: '.$myVolunteer->email.'</td>
      </tr>
      <tr>
        <td>Name</td>
        <td>: '.$myVolunteer->nama.'</td>
      </tr>
      <tr>
        <td>Gender</td>
        <td>: '.$myVolunteer->kelamin.'</td>
      </tr>
      <tr>
        <td>City</td>
        <td>: '.$myVolunteer->kota.'</td>
      </tr>
      <tr>
        <td>Address</td>
        <td>: '.$myVolunteer->alamat.'</td>
      </tr>
      <tr>
        <td>Phone</td>
        <td>: '.$myVolunteer->telp.'</td>
      </tr>
      <tr>
        <td>Message</td>
        <td>: '.$myVolunteer->info.'</td>
      </tr>
    </table>
    <p>This is an automatic email, <br /> Ali Bangun</p>
  </body>
  </html>
  ';

  // To send HTML mail, the Content-type header must be set
  $headers  = 'MIME-Version: 1.0' . "\r\n";
  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

  // Additional headers
  //$headers .= 'From: SCORPION-THE WILDLIFE TRADE MONITORING GROUP' . "\r\n";


  // Mail it
  mail($to, $subject, $message, $headers);
};
?>