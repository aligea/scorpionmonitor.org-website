<?php
class NewsletterCtrl {
	static function unsubscribe(){
		izy::exec("DELETE FROM tb_newsletter_subscriber WHERE email=?", array($_REQUEST['email']));
		echo 'Success to unsubscribe our newsletter. You will not received the newsletter.';
	}
	static function autosend(){
		//-- ambil content terakhir
		$content = izy::findOne('tb_content', " type='news' AND state=1 ORDER BY id DESC");
		
		//-- cek apakah konten tsb sudah pernah di kirim
		if($content->access > 0){
			return;
		}
		
		//-- another news 
		$anothernews = '';
		$params .= " AND A.id <> '".$content->id."' ";
	    $params .= " AND MONTH(publish_up) = '".date('m', strtotime($content->publish_up))."' ";
	    $params .= " AND YEAR(publish_up) = '".date('Y', strtotime($content->publish_up))."' ";
	    $datanews = Content_Model::fetch_content(1, 4, $params);
	   
	    foreach ($datanews as $key => $value) {
	    	$news = (object)$value;
	    	$anothernews .= '
	    		<tr valign="top" style="border-bottom:1px solid #000;">
		            <td width="20%">
		            	<a href="'.baseurl.'/content/news/'.$news->alias.'.html"><img src="'.baseurl.'/img/resize?w=200&h=150&file='.Helper::fix_url($news->images).'" style="width:100%" /></a>
		            </td>
		            <td>
		            	<a href="'.baseurl.'/content/news/'.$news->alias.'.html" style="color:#dd4814;">'.html_entity_decode($news->title).'</a>
		            </td>
		        </tr>';
	    }
		
		//$to = 'alibangun_gea@ymail.com';
		$subject = 'Scorpion Foundation Newsletter - '.$content->title;
		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"></head>
		<body style="font-family:Verdana, Geneva, sans-serif;font-size:medium;">
		<table cellpadding="2" cellspacing="2" width="100%" border="0">		    
		    <tr>
		    	<td colspan="3">
		        <h3 style="color:#dd4814;">'.$content->title.'</h3>
		        <div align="center"><img src="'.Helper::fix_url($content->images).'" /></div>
		        <div align="justify">'.Helper::fix_content_url($content->fulltext).'</div>        
		        </td>
		    </tr>
		    
		  <tr style="display:;background-color:#ccc;">
		    	<td align="left" colspan="2"><a href="'.baseurl.'/content/news/'.$content->alias.'.html">Click here to see this on our website</a></td>
		        <td align="right"><a href="'.baseurl.'/newsletter/unsubscribe?email={$email}">Unsubscribe newsletter</a></td>
		    </tr>
		    
		    <tr>
		    	<td colspan="3">
		        	<div style="font-weight:bold;margin-bottom:10px;margin-top:10px;">See also :</div>
		        	<table border="0" cellpadding="2" cellspacing="2">'.$anothernews.'</table>
		        </td>
		    </tr>
			
		    <tr>
		    	<td colspan="3" align="center">
		            <table border="0" cellspacing="10" cellpadding="10">
		            	<tr valign="top">
		                	<td>
		                        <div align="center">
		                        <h4>Donate Now!</h4>
		                        <a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=WNVC9V9LKLNZY"><img src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" alt="image of paypal"></a>
		                        </div>
		                    </td>
		                    <td align="center">
		                        <div><a href="http://www.scorpionmonitor.org"><img height="100" alt="logo of scorpion" src="http://scorpionmonitor.org/images/logo-scorpion.jpg"></a></div>
		                        <div><a href="http://www.scorpionmonitor.org" style="color:#000;">www.scorpionmonitor.org</a></div>            
		                    </td>
		                </tr>
		            </table>
		        </td>
		    </tr>
		    <tr>
		   	<td colspan="3" align="center">
		      <div style="background-color:#021315;padding:10px;font-size:smaller;">
		        <div>
		        	<a href="https://www.facebook.com/scorpionmonitor" title="Facebook"><img src="http://scorpionmonitor.org/images/icons/fb-icon.png"></a> 
		            <a href="https://twitter.com/scorpionmonitor" title="Twitter"><img src="http://scorpionmonitor.org/images/icons/twitter-icon.png"></a> 
		            <a href="https://instagram.com/scorpionmonitor" title="Instagram"><img src="http://scorpionmonitor.org/images/icons/instagram-icon.png"></a> 
		            <a href="mailto:info@scorpionmonitor.org" title="Email"><img src="http://scorpionmonitor.org/images/icons/email-icon.png"></a> 
		            <a href="http://scorpionmonitor.org/rss" title="RSS"><img src="http://scorpionmonitor.org/images/icons/rss-icon.png"></a> 
		        </div>
		      	<div><a href="http://scorpionmonitor.org" style="color:#dd4814;">SCORPION - THE WILDLIFE TRADE MONITORING GROUP</a></div>
		        <div>
		        	<span style="color:#fff;">&copy;'.date('Y').' All Rights Reserved.</span> 
		            <a href="http://scorpionfoundation.org" style="color:#dd4814">Yayasan Scorpion Indonesia</a>
				</div>
		      </div>	        	
		            
		              
		 	 </td>
			</tr>
		</table>
		</body>
		</html>
		';
		
		//echo $body;return;
		

		//-- ambil listing newsletter
		$subsciber_data = izy::find('tb_newsletter_subscriber', "status=1");
		foreach ($subsciber_data as $subsciber) {
			self::sent_mail($subsciber->email, $subject, $body);
		}

		//-- update
		$content->access += 1;
		izy::store($content);

	}

	static function sent_mail($to, $subject, $body, $headers = array()){
		include_once basepath."/libraries/PHPMailer-master/PHPMailerAutoload.php";

		//-- penyesuaian
		$body = str_replace('{$email}', $to, $body);

		$mail = new PHPMailer;


		//setting mail
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = 'srv9.niagahoster.com';
		$mail->Port = 465;
		$mail->SMTPSecure = 'ssl';
		$mail->SMTPAuth = true;
		$mail->Username = 'newsletter@scorpionmonitor.org';
		$mail->Password = 'email123456';
		
		$mail->setFrom('newsletter@scorpionmonitor.org');
		$mail->addReplyTo('info@scorpionmonitor.org');
		
		//create email content
		$mail->addAddress($to);
		//Set the subject line
		$mail->Subject = $subject;

		$mail->msgHTML($body);
		

		if (!$mail->send()) {
		     echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		     echo "Message sent!";
		}
		$mail->clearAddresses();
	    $mail->clearAttachments();
	}
	
	static function register(){
		$app = \Slim\Slim::getInstance();
		$request = $app->request();

		$subsciber = izy::dispense('tb_newsletter_subscriber');
		$subsciber->email = $request->params('email');
		izy::store($subsciber);
	}
}
?>