<?php
//Contact Form
add_action('wp_ajax_nopriv_icb_form_save','icb_form_save');
add_action('wp_ajax_icb_form_save','icb_form_save');
function icb_form_save(){
	global $wpdb;
	$icb_messages = "{$wpdb->prefix}icb_messages";
	$notif = array();
	$crf_code = icb_generateCRF($_POST['icb_code']);
	$crf = wp_strip_all_tags($_POST['icb_crf_code']);
	if(($crf_code == $_SESSION['_icb_crf_']) && ($crf == $_SESSION['_icb_crf_'])){
		$subject = wp_strip_all_tags($_POST['icb_topic']);
		$topicemail = $wpdb->get_row("SELECT email FROM dilc_icb_topics WHERE topic = '$subject'");
		$email = wp_strip_all_tags($_POST['icb_email']);
		$fullname = wp_strip_all_tags($_POST['icb_fullname']);
		$message = wp_strip_all_tags($_POST['icb_message']);
		// $to = $topicemail;
		$header = 'Content-Type: text/html; charset=UTF-8';
		$content =  'Email: '.$email.'<br>'.
					'Fullname: '.$fullname.'<br>'.
					'Subject: '.$subject.
					'<br>===================<br>'.
					'Message:<br>'.$message;
		wp_mail($topicemail->email, $subject, $content, $header);
		$values = array(
						'subject' => $subject,
						'email' => $email,
						'fullname' => $fullname,
						'message' => $message
					);
		$format = array('%s','%s','%s','%s');
		$result = $wpdb->insert($icb_messages, $values, $format);
		if($result){
			$notif[] = "Message sent successfully.";
		} 
		else { $notif[] = "Can't record message."; }
	} else {
		$notif[] = "Captcha is invalid.";
	}
	echo json_encode($notif); 
	die();
}
add_action('wp_ajax_nopriv_icb_topic_list','icb_topic_list');
add_action('wp_ajax_icb_topic_list','icb_topic_list');
function icb_topic_list(){
	global $wpdb;
	$results = $wpdb->get_results("SELECT DISTINCT topic FROM dilc_icb_topics WHERE stat = 'Active'");
	echo json_encode($results); 
	die();
}
//Subscribe Form
add_action('wp_ajax_nopriv_icb_email_save','icb_email_save');
add_action('wp_ajax_icb_email_save','icb_email_save');
function icb_email_save(){
	global $wpdb;
	$notif = array();
	$icb_email = "{$wpdb->prefix}icb_email";
	$fullname = wp_strip_all_tags($_POST['icb_srb_fullname']);
	$email = wp_strip_all_tags($_POST['icb_srb_email']);
	$crf = wp_strip_all_tags($_POST['icb_srb_crf']);
	$crf_code = icb_generateCRF($_POST['icb_crf_code']);
	$client_email = $wpdb->get_row("SELECT email FROM {$icb_email} WHERE email = '$email' LIMIT 1");
	if(($crf_code != $_SESSION['_icb_email_crf_']) && ($crf != $crf_code)){ $notif[] = "Captcha is invalid."; }
	elseif($client_email->email == $email){ $notif[] = "Your email already subscribed."; }
	elseif(($crf_code == $_SESSION['_icb_email_crf_']) && ($crf == $crf_code)) {
		$values = array(
			'fullname' => $fullname,
			'email' => $email
		);
		$result = $wpdb->insert($icb_email, $values, array('%s', '%s'));
		if($result){ $notif[] = "You are now Subscribed.";} 
		else { $notif[] = "Failed to Subscribe."; }
	} 
	echo json_encode($notif);
	die();
}
//ReCaptcha
add_action('wp_ajax_nopriv_icb_getcaptcha_session','icb_getcaptcha_session');
add_action('wp_ajax_icb_getcaptcha_session','icb_getcaptcha_session');
function icb_getcaptcha_session(){
	$captcha = generateCaptcha();
	$captcha2 = generateCaptcha();
	$_SESSION['_icb_crf_'] = $captcha['crf'];
	$_SESSION['_icb_email_crf_'] = $captcha2['crf'];
	session_write_close();
	$captchaValue = array("image" =>$captcha['image'], "image2"=>$captcha2['image'], "crf"=>$captcha['crf'],"subscribe_crf"=>$captcha2['crf']);
	echo json_encode($captchaValue);
	die();
}
function icb_generateCRF($data){
	$salt = "$%shKlMnt_UVWx89";
	return md5($data . $salt);
}
function generateCaptcha(){
	$text = '';
	for ($i = 0; $i < 5; $i++) {
		$text .= chr(rand(97, 122));
	}
	$dir = plugins_url('/assets/fonts/', __FILE__);
	$fontSize = 16;
	// Create image width dependant on width of the string
	$width  = imagefontwidth($fontSize) * strlen($text);
	// Set height to that of the font
	$height = imagefontheight($fontSize);
	// Create the image pallette
	$image = imagecreate($width,$height);
	// random number 1 or 2
	//$num = rand(1,2);
	//if($num==1) {
	//	$textFont = "Capture it 2.ttf"; // font style
	//}
	//else {
		$textFont = "Molot.otf";// font style
	//}
// random number 1 or 2
//	$num2 = rand(1,2);
//	if($num2==1) {
//		$textColor = imagecolorallocate($image, 113, 193, 217);// color
//	}
//	else {
//		$textColor = imagecolorallocate($image, 163, 197, 82);// color
//	}
	$textColor = imagecolorallocate($image, 0, 0, 0);
	$backgroundWhite = imagecolorallocate($image, 255, 255, 255); // background color white
	imagefilledrectangle($image,0,0,399,99,$backgroundWhite);// create rectangle white
	$getfont = imageloadfont($dir.$textFont); //load font
	imagestring($image, $getfont, 7, 3, $text, $textColor); //write text
	$crf = icb_generateCRF($text);
	ob_start();
	imagepng($image);
	$image_data = ob_get_contents();
	imagedestroy($image);
	ob_end_clean();
	return array("crf" => $crf, "image" => base64_encode($image_data));
}
