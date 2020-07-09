<?php 
/**

 * @package iReport Form

 * @version 1.0

 */

/*

Plugin Name: iReport Form

Plugin URI:

Description: iReport Form Shortcode to use just copy and paste -> [rf_shortcode]

Author: John Mark

Version: 1.0

Author URI:

*/

function add_style_js(){
    wp_register_style('jmr_css', plugins_url('/assets/rf-style.css', __FILE__));
    wp_register_script('jmr_js', plugins_url('/assets/rf-script.js', __FILE__), array('jquery'), 1.0, true);
    wp_localize_script('jmr_js', 'ajaxUrl', array(
      'ajax_url' => admin_url('admin-ajax.php')
   ));
   wp_enqueue_style('jmr_css');
   wp_enqueue_script('jmr_js');
}
add_action('wp_enqueue_scripts', 'add_style_js');

function add_admin_style(){
    wp_register_style('jmr_admin_css', plugins_url('/assets/rf-admin-style.css', __FILE__));
   wp_enqueue_style('jmr_admin_css');
}
add_action('admin_enqueue_scripts', 'add_admin_style');

function add_report_form_shortcode($atts, $content = null) {
	$atts = shortcode_atts( array(), $atts, 'rf_shortcode'
	);
	ob_start();
		include_once (plugin_dir_path(__FILE__) . '/forms/report-form.php');
	return ob_get_clean();
}
add_shortcode('rf_shortcode','add_report_form_shortcode');

//Make sure gmail allowed Less security Apps (Sign in & Activit - Device activity & notifications - Allow less secure apps: ON)
/*add_action( 'phpmailer_init', 'my_phpmailer' );
function my_phpmailer( $phpmailer ) {
    $phpmailer->isSMTP();
    $phpmailer->Host = esc_attr( get_option('host') );
    $phpmailer->SMTPAuth = true; // Force it to use Username and Password to authenticate
    $phpmailer->Port = esc_attr( get_option('port') );
    $phpmailer->Username = esc_attr( get_option('username') );
    $phpmailer->Password = esc_attr( get_option('password') );
    // Additional settings…
    $phpmailer->SMTPSecure = esc_attr( get_option('secure') ); // Choose SSL or TLS, if necessary for your server
    // $phpmailer->From = "sampleou@gmail.com";
    $phpmailer->FromName = esc_attr( get_option('fromname') );
}*/

add_action('wp_ajax_nopriv_save_report_form','save_report_form');
add_action('wp_ajax_save_report_form','save_report_form');
function save_report_form(){
	$title = wp_strip_all_tags($_POST['title']);
	$description = wp_strip_all_tags($_POST['description']);
	$to = esc_attr( get_option('toemail') );
	wp_mail($to, $title, $description, null, null);
	$my_post = array(
		'post_title' => $title,
		'post_content' => $description,
        	'post_date' => $post_date,
        	'post_status' => 'pending',
		'post_type' => 'error-report'
	);
	wp_insert_post( $my_post );
}

function error_report_post_type(){
	$labels = array(
		'name' 				=> 'Error Reports List',
		'singular_name' 	=> 'Error Report List',
		'menu_name' 		=> 'Error Report List',
		'name_admin_bar' 	=> 'Error Report List'
	);
	$args = array(
		'labels' 		=> $labels,
		'show_ui' 		=> true,
		'publicly_queryable'	=>false,
		'exclude_from_search'	=>true,
		'show_in_menu'		=> true,
		//'capability_type'	=> 'post',
		'hierarchical'		=> false,
		'menu_position'		=> 26,
		'menu_icon'			=> 'dashicons-info',
		//'supports'			=> array('title')
	);
/*
'public' => true,
        'publicly_queryable' => false,
        'exclude_from_search' => true,
*/
	register_post_type('error-report', $args);
}
add_action('init', 'error_report_post_type');

function custom_postype_column( $columns ){
    $arrcolumn = array(
        'cb' => '<input type="checkbox"/>',
        'title'=>'Title',
        'report' => 'Report',
        'date' => 'Date' );
    return $arrcolumn;
}
add_filter('manage_error-report_posts_columns', 'custom_postype_column');

function custom_postype_column_name( $column, $post_id ){
    switch( $column ){
        case 'report':
            echo get_the_excerpt();
     	break;
    }
}
add_action('manage_error-report_posts_custom_column','custom_postype_column_name', 1, 2);

add_filter( 'post_row_actions', 'remove_row_actions', 10, 1 );
function remove_row_actions( $actions )
{
    if( get_post_type() === 'error-report' )
        unset( $actions['edit'] );
        unset( $actions['view'] );
        //unset( $actions['trash'] );
        unset( $actions['inline hide-if-no-js'] );
	unset( $actions['hide-if-no-js']);
    return $actions;
}

/* Add submenu page */
function add_settings_subpage(){
	add_submenu_page(
		'edit.php?post_type=error-report',
		'Settings',
		'Settings',
		'manage_options',
		'error_report_settings_page',
		'settings_subpage_callback');
		add_action( 'admin_init', 'jmr_custom_postype_settings');
}
add_action( 'admin_menu', 'add_settings_subpage' );

function jmr_custom_postype_settings(){
	register_setting( 'jmr_postype_settings_group', 'host');
	register_setting( 'jmr_postype_settings_group', 'port');
	register_setting( 'jmr_postype_settings_group', 'username');
	register_setting( 'jmr_postype_settings_group', 'password');
	register_setting( 'jmr_postype_settings_group', 'secure');
	register_setting( 'jmr_postype_settings_group', 'fromname');
	register_setting( 'jmr_postype_settings_group', 'toemail');

	add_settings_section( 'mail_setting_options_section', 'SMTP Settings', 'smtp_setting_option_callback', 'error_report_settings_page');

	add_settings_field( 'mail-host-name', 'Host', 'host_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
	add_settings_field( 'mail-port-number', 'Port', 'port_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
	add_settings_field( 'mail-user-name', 'Username', 'username_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
	add_settings_field( 'mail-pass-word', 'Password', 'password_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
	add_settings_field( 'mail-secure-name', 'Secure', 'secure_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
	add_settings_field( 'mail-from-name', 'From Name', 'fromname_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
	add_settings_field( 'mail-to-email', 'To Email', 'toemail_field_callback', 'error_report_settings_page', 'mail_setting_options_section');
}
function smtp_setting_option_callback(){
	echo "Customize email smtp";
}
function host_field_callback(){
	echo '<input type="text" name="host" value="'. esc_attr( get_option('host') ).'" placeholder="Host" required/>';
}
function port_field_callback(){
	echo '<input type="number" name="port" value="'. esc_attr( get_option('port') ).'" placeholder="Port" required/>';
}
function username_field_callback(){
	echo '<input type="email" name="username" value="'. esc_attr( get_option('username') ).'" placeholder="Email" required/>';
}
function password_field_callback(){
	echo '<input type="password" name="password" value="'. esc_attr( get_option('password') ).'" placeholder="Password" required/>';
}
function secure_field_callback(){
	echo '<input type="text" name="secure" value="'. esc_attr( get_option('secure') ).'" placeholder="SSL or TLS" required/>';
}
function fromname_field_callback(){
	echo '<input type="text" name="fromname" value="'. esc_attr( get_option('fromname') ).'" placeholder="From Name" required/>';
}
function toemail_field_callback(){
	echo '<input type="email" name="toemail" value="'. esc_attr( get_option('toemail') ).'" placeholder="Email"/>';
}
function settings_subpage_callback(){
	include_once (plugin_dir_path(__FILE__)  . 'forms/settings-form.php');
}
/* Add submenu page */
