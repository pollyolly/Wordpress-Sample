<?php
add_action( 'phpmailer_init', 'contact_box_phpmailer' );
function contact_box_phpmailer( $phpmailer ) {
	$phpmailer->isSMTP();
	// $phpmailer->ChartSet = "utf-8";
    $phpmailer->Host = esc_attr( get_option('icb_host') );
    $phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
    $phpmailer->Port = esc_attr( get_option('icb_port') );
    $phpmailer->Username = esc_attr( get_option('icb_username') );
    $phpmailer->Password = esc_attr( get_option('icb_password') );
    // Additional settings…
    $phpmailer->SMTPSecure = esc_attr( get_option('icb_secure') ); // Choose SSL or TLS, if necessary for your server
    // $phpmailer->From = "sampleou@gmail.com";
	$phpmailer->FromName = esc_attr( get_option('icb_fromname') );
	// $phpmailer->SMTPDebug = 2;
}