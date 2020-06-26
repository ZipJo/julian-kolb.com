<?php
	session_start();
	$_SESSION['already_sent'] = $_POST['alreadysent'];
	if (isset($_POST['send']) && $_POST['send'] == "true" && $_SESSION['already_sent'] != 'true'){
		$name = $_POST['name'];
		$mail = $_POST['mail'];
		$subject = $_POST['betreff'];
		$content = nl2br($_POST['nachricht']);
		$reciever = "Julian Kolb <hello@julian-kolb.com>";
		//$reciever = "form-test <test@jonas-brueggen.de>";

		$content .= "<br /><br />---------------<br />Diese Email wurde automatisch mit dem Formular auf julian-kolb.com erzeugt.";

		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf-8' . "\r\n";

		// zusätzliche Header
		$header .= 'To: ' . $reciever . "\r\n";
		$header .= 'From: ' . $name .  ' <' . $mail . '>' . "\r\n";
		$header .= 'Cc: ' . $name .  ' <' . $mail . '>' . "\r\n";

		// verschicke die E-Mail
		mail($reciever, $subject, $content, $header);
		$_SESSION['already_sent'] = 'true';
		echo 'true';
	} else if ( $_SESSION['already_sent'] == 'true' ){
		echo 'false';
	}
?>