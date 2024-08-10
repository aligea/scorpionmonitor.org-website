<?php  

class MailerCtrl{

	static function kirim_email_registrasi($data_email){
		
		$emailadmin = $_SESSION['config']['emailadmin'];
		$emailwebsite = $_SESSION['config']['emailwebsite'];
		$namawebsite = $_SESSION['config']['namawebsite'];
		$namaperusahaan = $_SESSION['config']['namaperusahaan'];

		$headers = array();
		$headers['addReplyTo'] = array('email'=>$emailwebsite , 'nama'=>$namaperusahaan);
		$headers['setFrom'] = array('email'=>$emailwebsite , 'nama'=>$namaperusahaan);

		$to = $emailadmin;
		$subject = "Pendaftaran dari Member $nama";
		$message = '<table width="100%" height="176" border="0" cellpadding="0" cellspacing="0">
					  <tr>
						  <td width="200">Nama</td>
						  <td width="400">: ' . $data_email->nama . '</td>
					  </tr>
					  <tr>
						  <td>Username</td>
						  <td>:  ' . $data_email->username . '</td>
					  </tr>
					  <tr>
						  <td>Email</td>
						  <td>:  ' . $data_email->email . '</td>
					  </tr>
					  <tr>
						  <td>Games</td>
						  <td>:  ' . $data_email->produk . '</td>
					  </tr>
					  <tr>
						  <td>Referal</td>
						  <td>:  ' . $data_email->referral . '</td>
					  </tr>
					  <tr>
						  <td>Bank</td>
						  <td>:  ' . $data_email->bank . '</td>
					  </tr>
					  <tr>
						  <td>Pemilik Rekening</td>
						  <td>:  ' . $data_email->nama_rekening . '</td>
					  </tr>
					  <tr>
						  <td>Nomor Rekening</td>
						  <td>: ' . $data_email->no_rekening . '</td>
					  </tr>
					  <tr>
						  <td>No. Telpon</td>
						  <td>:  ' . $data_email->no_telpon . '</td>
					  </tr>
					  <tr>
						<td>Tgl. Daftar</td>
						<td>: ' . $data_email->tgldaftar . '</td>
					  </tr>
					</table>
					
					';
		MailerCtrl::sent_mail($to, $subject, $message, $headers);

		// -- Kirim email ke custumer bahwa dia sudah daftar
		$headers = array();
		$headers['addReplyTo'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);
		$headers['setFrom'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);

		$to = $data_email->email;
		$subject = "Pendaftaran di Website $namaperusahaan";
		$message = "<p>Hello, </p>
		<p>Selamat Bergabung di $namawebsite, Silahkan lakukan pembayaran dan jangan lupa isi Form Deposit di Website kami, CS kami selalu siap melayani anda.</p>
		
		<p>Regards,</p>
		<p>Admin</p>
		";

		MailerCtrl::sent_mail($to, $subject, $message, $headers);

	}

	static function kirim_email_deposit($data_email){

		$emailadmin = $_SESSION['config']['emailadmin'];
		$emailwebsite = $_SESSION['config']['emailwebsite'];
		$namawebsite = $_SESSION['config']['namawebsite'];
		$namaperusahaan = $_SESSION['config']['namaperusahaan'];

		// -- Kirim email ke custumer bahwa dia sudah daftar
		$headers = array();
		$headers['addReplyTo'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);
		$headers['setFrom'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);

		$to = $data_email->email;
		$subject = "Deposit di Website $namaperusahaan";
		$message = "<p>Hello, </p>
			<p>Kami sudah menerima Email Konfirmasi bahwa sudah dilakukan Pembayaran ke Rekening kami, Kami akan segera memproses Akun Bapak / ibu secepatnya</p>
			<p>Regards,</p>
			<p>Admin</p>
			";

		MailerCtrl::sent_mail($to, $subject, $message, $headers);
		
		// -- Kirim email ke admin bahwa dari email website bahwa ada custemer yg dafar
		$headers['addReplyTo'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);
		$headers['setFrom'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);

		$to = $emailadmin;
		$subject = "Deposit dari Member $nama";
		$message = '<table width="100%" height="176" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		    <td>ID Games/Username</td>
		    <td>:  ' . $data_email->username . '</td>
		  </tr>
		  <tr>
		    <td>Email</td>
		    <td>:  ' . $data_email->email . '</td>
		  </tr>
		  <tr>
		    <td>Bank</td>
		    <td>:  ' . $data_email->bank . '</td>
		  </tr>
		  <tr>
		    <td>Pemilik Rekening</td>
		    <td>:  ' . $data_email->nama_rekening . '</td>
		  </tr>
		  <tr>
		    <td>Nomor Rekening</td>
		    <td>: ' . $data_email->no_rekening . '</td>
		  </tr>
		  <tr>
		    <td>Produk</td>
		    <td>: ' . $data_email->produk . '</td>
		  </tr>
		  <tr>
		    <td>Tgl. Deposit</td>
		    <td>: ' . $data_email->tanggal . '</td>
		  </tr>
		  <tr>
		    <td>Jumlah Deposit</td>
		    <td>: ' . $data_email->jumlah . '</td>
		  </tr>
		</table>';

		MailerCtrl::sent_mail($to, $subject, $message, $headers);
	}

	static function kirim_email_withdraw($data_email){
		
		// ubah ini variabel saja untuk kirim email
		$emailadmin = $_SESSION['config']['emailadmin'];
		$emailwebsite = $_SESSION['config']['emailwebsite'];
		$namawebsite = $_SESSION['config']['namawebsite'];
		$namaperusahaan = $_SESSION['config']['namaperusahaan'];

		// -- Kirim email ke custumer bahwa dia sudah daftar
		$headers = array();
		$headers['addReplyTo'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);
		$headers['setFrom'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);

		$to = $data_email->email;
		$subject = "Withdraw di Website $namaperusahaan";
		$message = "<p>Hello, </p>
					<p>Kami sudah menerima Email Konfirmasi bahwa anda telah melakukan request Withdraw dari Rekening kami, Kami akan segera memproses Akun Bapak / ibu secepatnya</p>
					<p>Regards,</p>
					<p>Admin</p>
					";

		MailerCtrl::sent_mail($to, $subject, $message, $headers);

		// -- Kirim email ke admin dari email website bahwa ada custemer yg withdraw
		$headers['addReplyTo'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);
		$headers['setFrom'] = array('email'=>$emailadmin , 'nama'=>$namaperusahaan);

		$to = $emailadmin;
		$subject = "withdraw dari Member $nama";
		$message = '<table width="100%" height="176" border="0" cellpadding="0" cellspacing="0">
		  <tr>
		    <td>ID Games</td>
		    <td>:  ' . $data_email->nama . '</td>
		  </tr>
		  <tr>
		    <td>Email</td>
		    <td>:  ' . $data_email->email . '</td>
		  </tr>
		  <tr>
		    <td>Bank</td>
		    <td>:  ' . $data_email->bank . '</td>
		  </tr>
		  <tr>
		    <td>Pemilik Rekening</td>
		    <td>:  ' . $data_email->nama_rekening . '</td>
		  </tr>
		  <tr>
		    <td>Nomor Rekening</td>
		    <td>: ' . $data_email->no_rekening . '</td>
		  </tr>
		  <tr>
		    <td>Produk</td>
		    <td>: ' . $data_email->produk . '</td>
		  </tr>
		  <tr>
		    <td>Tgl. Withdraw</td>
		    <td>: ' . $data_email->tanggal . '</td>
		  </tr>
		  <tr>
		    <td>Jumlah Withdraw</td>
		    <td>: ' . $data_email->jumlah . '</td>
		  </tr>
		</table>';

		MailerCtrl::sent_mail($to, $subject, $message, $headers);
	}

	static function sent_mail($to,$subject,$body,$headers = array()){

		include_once basepath."/libraries/PHPMailer-master/PHPMailerAutoload.php";

		$mail = new PHPMailer;

		//setting mail
		$mail->isSMTP();
		$mail->SMTPDebug = 0;
		$mail->Debugoutput = 'html';
		$mail->Host = $_SESSION['mail_config']['Host'];
		$mail->Port = $_SESSION['mail_config']['Port'];
		$mail->SMTPSecure = $_SESSION['mail_config']['SMTPSecure'];
		$mail->SMTPAuth = true;
		$mail->Username = $_SESSION['mail_config']['Username'];
		$mail->Password = $_SESSION['mail_config']['Password'];
		
		if (!empty($headers['setFrom'])) {
			$mail->setFrom($headers['setFrom']['email'],$headers['setFrom']['nama']);
		}
		
		if (!empty($headers['addReplyTo'])) {
			$mail->addReplyTo($headers['addReplyTo']['email'],$headers['addReplyTo']['nama']);
		}

		//create email content
		$mail->addAddress($to);
		//Set the subject line
		$mail->Subject = $subject;

		$mail->msgHTML($body);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'This is a plain-text message body';

		if (!$mail->send()) {
		    // echo "Mailer Error: " . $mail->ErrorInfo;
		} else {
		    // echo "Message sent!";
		}
		$mail->clearAddresses();
	    $mail->clearAttachments();
	    
	}
}


?>