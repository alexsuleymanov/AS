<?php
	namespace ASweb\Mail;
	
	class Mail{
		public static function mailhtml($from, $fromadr, $to, $subj, $text, $files = array(), $smtp = array())
		{
/*
			$smtp = array(
				'host' => "mail.asweb.com.ua",
				'auth' => 'login',
				'username' => 'mail@asweb.com.ua',
				'password' => 'mail261984',
				'port' => 25,
			);
*/
			if (count($smtp)){
				$transport = new \Zend_Mail_Transport_Smtp($smtp["host"], $smtp);
				\Zend_Mail::setDefaultTransport($transport);
			}

			$mail = new \Zend_Mail('utf-8');

			$mail->setBodyText(strip_tags($text));
			$mail->setBodyHtml($text);
			$mail->setFrom($fromadr, $from);
			$mail->addTo($to);
			$mail->setSubject($subj);

			foreach($files as $k => $v){
	            $attach = new \Zend_Mime_Part(file_get_contents($v["tmp_name"]));
				$attach->type = mime_content_type($v["tmp_name"]);
				$attach->disposition = \Zend_Mime::DISPOSITION_INLINE;
				$attach->encoding = \Zend_Mime::ENCODING_BASE64;
				$attach->filename = $v["name"];
				$mail->addAttachment($attach);
			}

			try{
				if($transport)
					return $mail->send($transport);
				else
					return $mail->send();
			}catch(Exception $exception){
				return false;
			}
		}
	}