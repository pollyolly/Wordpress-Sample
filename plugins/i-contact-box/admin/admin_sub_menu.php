<?php
function icb_admin_menu(){
	add_menu_page(
		'iContact Box',
		'iContact Box',
		'activate_plugins',
		'contact-box',
		'icb_contact_page_handler'
	);
	add_submenu_page(
		'contact-box',
		'Topic List',
		'Topic List',
		'activate_plugins',
		'contact-box',
		'icb_contact_page_handler'
	);
	add_submenu_page(
		'contact-box',
		'Add Topics',
		'Add Topics',
		'activate_plugins',
		'contact-topic-form',
		'icb_contact_topic_form_handler'
	);
	add_submenu_page(
		'contact-box',
		'Message List',
		'Message List',
		'activate_plugins',
		'contact-box-message',
		'icb_contact_message_page_handler'
	);
	add_submenu_page(
		'contact-box',
		'Subscribe List',
		'Subscribe List',
		'activate_plugins',
		'contact-box-subscribe',
		'icb_contact_subscribe_page_handler'
	);
	add_submenu_page(
		'contact-box',
		'Settings',
		'Settings',
		'manage_options',
		'contact_box_setting_options',
		'icb_setting_options_page_handler'
	);
	add_action( 'admin_init', 'contact_box_settings');
}
add_action('admin_menu', 'icb_admin_menu' );

function contact_box_settings(){
	register_setting( 'contact-box_settings_group', 'icb_host');
	register_setting( 'contact-box_settings_group', 'icb_port');
	register_setting( 'contact-box_settings_group', 'icb_username');
	register_setting( 'contact-box_settings_group', 'icb_password');
	register_setting( 'contact-box_settings_group', 'icb_secure');
	register_setting( 'contact-box_settings_group', 'icb_fromname');
	// register_setting( 'contact-box_settings_group', 'icb_toemail');

	add_settings_section( 'mail_setting_options_section', 'SMTP Settings', 'contact_smtp_setting_option_callback', 'contact_box_setting_options');

	add_settings_field( 'mail-host-name', 'Host', 'contact_host_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
	add_settings_field( 'mail-port-number', 'Port', 'contact_port_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
	add_settings_field( 'mail-user-name', 'Username', 'contact_username_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
	add_settings_field( 'mail-pass-word', 'Password', 'contact_password_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
	add_settings_field( 'mail-secure-name', 'Secure', 'contact_secure_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
	add_settings_field( 'mail-from-name', 'From Name', 'contact_fromname_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
	// add_settings_field( 'mail-to-email', 'To Email', 'contact_toemail_field_callback', 'contact_box_setting_options', 'mail_setting_options_section');
}
function contact_smtp_setting_option_callback(){
	echo "Customize email smtp";
}
function contact_host_field_callback(){
	echo '<input type="text" name="icb_host" value="'. esc_attr( get_option('icb_host') ).'" placeholder="Host" required/>';
}
function contact_port_field_callback(){
	echo '<input type="number" name="icb_port" value="'. esc_attr( get_option('icb_port') ).'" placeholder="Port" required/>';
}
function contact_username_field_callback(){
	echo '<input type="email" name="icb_username" value="'. esc_attr( get_option('icb_username') ).'" placeholder="Email" required/>';
}
function contact_password_field_callback(){
	echo '<input type="password" name="icb_password" value="'. esc_attr( get_option('icb_password') ).'" placeholder="Password" required/>';
}
function contact_secure_field_callback(){
	echo '<input type="text" name="icb_secure" value="'. esc_attr( get_option('icb_secure') ).'" placeholder="SSL or TLS" required/>';
}
function contact_fromname_field_callback(){
	echo '<input type="text" name="icb_fromname" value="'. esc_attr( get_option('icb_fromname') ).'" placeholder="From Name" required/>';
}
// function contact_toemail_field_callback(){
// 	echo '<input type="email" name="toemail" value="'. esc_attr( get_option('icb_toemail') ).'" placeholder="Email" required/>';
// }
function icb_setting_options_page_handler(){
	include_once (plugin_dir_path(__FILE__)  . 'contact-setting-options-form.php');
}
?>