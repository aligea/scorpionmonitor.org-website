<?php
class VolunteerCtrl{
	static function view(){
		$smarty = AppModules::init_smarty();
		

		$setting = $smarty->getTemplateVars('setting');
		$metadesc = ($content['metadesc'] != "")? $content['metadesc'] : $setting['metadesc'];
		$metakey = ($content['metakey'] != "")? $content['metakey'] : $setting['metakey'];

		$og = $smarty->getTemplateVars('og');

		$og['type'] = 'website';
		$og['title'] = 'Volunteer Registration';
		$og['description'] = 'Registration for being voulunteer';
		$smarty->assign('og', $og);

		$smarty->assign('meta_title', 'Registration Form to be Volunteer | ' . $smarty->getTemplateVars('setting')['metatitle']);
	    $smarty->assign("meta_keyword", $metakey);
	    $smarty->assign("meta_description", $metadesc);

	    $smarty->assign('content', $content);
	    $smarty->display(basepath."/templates/$smarty->path_user/volunteer.tpl");
	}
	static function validate(){
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
	}
	static function insert(){
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

	    self::send_email_to_owner($obj);
	    self::send_email_to_volunteer($obj);


	    $result = 'berhasil';
	  } catch(Exception $e) {
	    izy::rollback();
	    $result = $e->getMessage();
	  }
	  echo $result;
	  exit();
	}
	static function send_email_to_volunteer($myVolunteer = stdClass){
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
	}
	static function send_email_to_owner($myVolunteer = stdClass){
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
	}
}

?>