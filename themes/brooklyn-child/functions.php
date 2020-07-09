<?php
require_once('ilcapi/ilcCurl.php');
require_once('ilcapi/yourlsapi.php');
/*
* Theme CSS
*/
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css', array(), '2.0' );
    wp_enqueue_style( 'animate-style', get_stylesheet_directory_uri() . '/animate.min.css' );
}
add_action('admin_enqueue_scripts', 'my_admin_enqueue_styles');
function my_admin_enqueue_styles(){
   wp_enqueue_style( 'admin-style-css', get_template_directory_uri() . '/myadmin_style.css' );
}
/*
* Theme Script
*/
add_action( 'wp_enqueue_scripts', 'my_theme_js');
function my_theme_js() {
   remove_action('wp_head', 'wp_print_scripts');
   remove_action('wp_head', 'wp_print_head_scripts');
   remove_action('wp_head', 'wp_enqueue_scripts');

   wp_register_script('my-jsscript', get_stylesheet_directory_uri() . '/js/myJs.js', array('jquery'),'1.0',true);
   wp_register_script('swfobject', get_stylesheet_directory_uri() . '/js/swfobject.js', array('swfobject'),'2.3',true);
   
   //News Line
  // wp_register_script('jqmarquee', get_stylesheet_directory_uri() . '/js/jquery.marquee.min.js', array('jqmarquee'),'1.5',true);
   wp_localize_script('my-jsscript', 'ajaxUrl', array(
      'ajax_url' => admin_url('admin-ajax.php')
   ));

   add_action('wp_footer', 'wp_print_scripts');
   add_action('wp_footer', 'wp_enqueue_scripts');
   add_action('wp_footer', 'wp_print_head_scripts');

   wp_enqueue_script('swfobject');
//   wp_enqueue_script('jqmarquee');
   wp_enqueue_script('my-jsscript');
}
add_action( 'wp_enqueue_scripts', 'remove_small_style_scripts', 11);
function remove_small_style_scripts(){
   if(!is_admin()){
        wp_deregister_style('siteorigin-panels-front');
        wp_dequeue_style('siteorigin-panels-front');
        wp_deregister_style('sow-button-base');
        wp_dequeue_style('sow-button-base');
	wp_dequeue_script('ut-parallax');
	wp_deregister_script('cd-pf-custom-js');
	wp_dequeue_script('cd-pf-custom-js');
        remove_action('wp_head', 'sow-button-base');
   }
}

/*
* Filter Team Category from Archive
*/
add_action('pre_get_posts', 'hide_team_archive');
function hide_team_archive($query){
    if(is_archive()){
      $other_term = get_term_by('name','team','category');
      $other_term_id = $other_term->term_id;
      $query->set('cat', '-'.$other_term_id);
    }
  return $query;
}
/*
* Add theme custom image size
*/
add_action( 'after_setup_theme', 'custom_imagesize' );
function custom_imagesize() {
    add_image_size( "ilcimage-size", 865, 9999 ); // 865 px wide (and max 9999 height)
    add_image_size( "ilcfeatured-image-size", 368);
}
add_filter( 'image_size_names_choose', 'ilc_imagecustom_sizes' );
function ilc_imagecustom_sizes( $sizes ) {
    return array_merge( $sizes, array(
        'ilcimage-size' => __( 'ILC Image size' ),
	'ilcfeatured-image-size' => __( 'ilc featured-image size' ),
    ) );
}
/*
* System Authentication
*/
/*
* Define Authentication Functions
*/
/*
* Set Authentication Cookies
*/
add_action('wp_ajax_nopriv_setWebsiteCookies', 'setWebsiteCookies'); 
add_action('wp_ajax_setWebsiteCookies', 'setWebsiteCookies');
function setWebsiteCookies(){
	mm_auth();
	uvlapi_auth();
	hapi_auth();
}
/*
* Hepldesk API Authentication Function
*/
function hapi_auth(){
	$auth_url =  HAPI_AUTH_URL . '/getAuthentication';
        $credentials = array("System" => WP_ILCWEBSITE, "Certificate" => WP_CERTIFICATE);
		try {
			if(empty($_COOKIE["_hapi_api_"]) OR $_COOKIE["_hapi_api_"] == "null" OR !isset($_COOKIE["_hapi_api_"])){
				$obj = json_decode(curlingData($auth_url, $credentials));
				$sToken = $obj->GetAuthentication->ReturnMessage->SessionToken;
				$domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
                        	setcookie("_hapi_api_", json_encode($sToken), time() + (84000 * 1), '/',$domain);
			}
		} catch(Exception $e) {
			var_dump("Error message:" . $e);
		}
	}
/*
* Uvle API Authentication Function
*/
function uvlapi_auth(){
	$auth_url = UVLAPI_AUTH_URL. '/getAuthentication';
	$credentials = array("System"=> WP_UVLESYSTEM, "Certificate"=> WP_CERTIFICATE_2);
	try{
		if(empty($_COOKIE["_uvlapi_api_"]) OR $_COOKIE["_uvlapi_api_"] == "null" OR !isset($_COOKIE["_hapi_api_"])){
			$obj = json_decode(curlingData($auth_url, $credentials));
			$sToken = $obj->GetAuthentication->ReturnMessage->SessionToken;
			$domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
                        setcookie("_uvlapi_api_", json_encode($sToken), time() + (84000 * 1), '/',$domain);
		}
	}
	catch(Exception $e){
		var_dump("Error message:" . $e);
	}
}
/*
* Multimedia Dashboard API Authentication Function
*/
function mm_auth(){
        $auth_url = MM_URL . '/getAuthentication';
        $credentials = array("System" => WP_ILCWEBSITE, "Certificate"=> MM_CERT);
        try {
		if(empty($_COOKIE["_auth_api_"]) OR $_COOKIE["_auth_api_"] == "null" OR !isset($_COOKIE["_auth_api_"])){
			$obj = json_decode(curlingData($auth_url, $credentials));
                	$authToken = $obj->GetAuthentication->ReturnMessage->AuthenticationToken;
                	mm_login($authToken);
			$domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
			setcookie("_auth_api_", json_encode($authToken), time() + (84000 * 1), '/',$domain);
		}
        }
        catch(Exception $e) {
                var_dump("Error Message:" .$e);
        }
}
/*
* Multimedia Dashboard API Login Function
*/
function mm_login($authToken){
        $auth_url = MM_URL . '/login';
        $credentials = array("AuthenticationToken" => $authToken, "Username"=> MM_USER, "Password"=> MM_PASS);
        try {
		if(empty($_COOKIE["_login_api_"]) OR $_COOKIE["_login_api_"] == "null" OR !isset($_COOKIE["_login_api_"])){
			$obj = json_decode(curlingData($auth_url, $credentials));
                	$sToken = $obj->Login->ReturnMessage->SessionToken;
                        $domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
                        setcookie("_login_api_", json_encode($sToken), time() + (84000 * 1), '/',$domain);
                }
        }
        catch(Exception $e) {
                var_dump("Error Message:" .$e);
        }
}
/*
* Multimedia Dashboard
*/
/*
* MM Total Events Per Month Function
*/
add_action('wp_ajax_nopriv_getTotalEventsPerMonth', 'getTotalEventsPerMonth'); 
add_action('wp_ajax_getTotalEventsPerMonth', 'getTotalEventsPerMonth');
function getTotalEventsPerMonth(){
	$authToken = json_decode(stripslashes($_COOKIE["_auth_api_"]), true);
	$sToken = json_decode(stripslashes($_COOKIE["_login_api_"]), true);
        $year = $_POST["getTotalEventsPerMonth"];
        $GraphData  = array();
	$credentials = array("AuthenticationToken" => $authToken, "SessionToken" => $sToken, "Year" => $year);
        $url = MM_URL . '/countEventsPerMonth';
        try{
             $data = json_decode(curlingData($url, $credentials));
		//var_dump($data);
             $ReturnMessage = $data->CountEventsPerMonth->ReturnMessage;
             $ErrorCode = $data->CountEventsPerMonth->ErrorCode;
	     $GraphData = getTotalEventsPerMonthData($data);
	     $Message = "";
	     if($ErrorCode != 0 ){
	          $Message = $ReturnMessage;
	     }
             echo json_encode(array(
	          "GraphData" => $GraphData,
		  "ReturnMessage" => $Message,
		  "ErrorCode" => $ErrorCode
             )); die();
        } catch(Exception $e){
                echo "Error message:" . $e;
        }
}
/*
* MM Total Events Per Month Data Function
*/
function getTotalEventsPerMonthData($data){
	$Month = array("JAN", "FEB", "MAR", "APR", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC");
	$EventCount = $data->CountEventsPerMonth->ReturnMessage->EventCount;
	$column = array();
	$dataCol = array();
	$graphData = array();
	foreach($EventCount as $value){
    		foreach($value->ServiceData as $val){ //Get All ServiceCount in each Service Name
        	$column [] = $val->ServiceCount; //Assign all the data in array
    		}
	}
	$p = 0;
	$l = 0;
	foreach($Month as $months){
    		$dataCol = []; //Reset array
    		$k = 0; //Reset k
    		$dataCol["category"] = $months;
        	//0=[0],12=[1], 24=[2],36=[3],48=[4], 60=[5]
        	for($i = $p;count($column) > $i; $i = $i + 12){ //Increment by 12 to get the data respectively
                	$dataCol["total"] += $column[$i]; //Get the total of service count
                	$dataCol["column".$k++] = $column[$i]; //Add all data in a column array
        	}
        $p++; //increment the starting position of index $i in column
    	$graphData[]= $dataCol;
	}
	return $graphData;
}
/*
* MM No. Of Events Per Month Function
*/
add_action('wp_ajax_nopriv_getNoOfEventsPerMonth', 'getNoOfEventsPerMonth'); 
add_action('wp_ajax_getNoOfEventsPerMonth', 'getNoOfEventsPerMonth');
function getNoOfEventsPerMonth(){
	$authToken = json_decode(stripslashes($_COOKIE["_auth_api_"]), true);
        $sToken = json_decode(stripslashes($_COOKIE["_login_api_"]), true);
	$year = $_POST["getNoOfEventsPerMonth"];
        $GraphData  = array();
        $credentials = array("AuthenticationToken" => $authToken, "SessionToken" => $sToken, "Year" => $year);
        $url = MM_URL . '/getNoOfEventsPerMonth';
	try{
             $data = json_decode(curlingData($url, $credentials));
             $ReturnMessage = $data->GetNoOfEventsPerMonth->ReturnMessage;
             $ErrorCode = $data->GetNoOfEventsPerMonth->ErrorCode;
             $Message = "";
             if($ErrorCode != 0 ){
                  $Message = $ReturnMessage;
             }
             echo json_encode(array(
                  "GraphData" => $ReturnMessage->NoOfEventsPerMonth,
                  "ReturnMessage" => $Message,
                  "ErrorCode" => $ErrorCode
             )); die();
        } catch(Exception $e){
                echo "Error message:" . $e;
        }
}
/*
* MM Average Of Events Per Month Function
*/
add_action('wp_ajax_nopriv_getAverageOfEventsPerMonth', 'getAverageOfEventsPerMonth'); 
add_action('wp_ajax_getAverageOfEventsPerMonth', 'getAverageOfEventsPerMonth');
function getAverageOfEventsPerMonth(){
	$authToken = json_decode(stripslashes($_COOKIE["_auth_api_"]), true);
        $sToken = json_decode(stripslashes($_COOKIE["_login_api_"]), true);
	$year = $_POST["getAverageOfEventsPerMonth"];
        $GraphData  = array();
	$dataCol = array();
        $credentials = array("AuthenticationToken" => $authToken, "SessionToken" => $sToken, "Year" => $year);
        $url = MM_URL . '/countEventsPerMonth';
        try{
             $data = json_decode(curlingData($url, $credentials));
		//var_dump($data);
	     //$GraphData = getAverageOfEventsPerMonthData($data);
             $ReturnMessage = $data->CountEventsPerMonth->ReturnMessage;
	     $EventCount = $data->CountEventsPerMonth->ReturnMessage->EventCount;
             $ErrorCode = $data->CountEventsPerMonth->ErrorCode;
	     foreach($EventCount as $eventData){
		    $k = 0;
		    $total = 0;
		    $dataCol["ServiceName"] = $eventData->ServiceName;
		    foreach($eventData->ServiceData as $serviceData){
		        $total += $serviceData->ServiceCount;
			$k++;
			if($k == 12 ){
			   $dataCol["ServiceCount"] = round($total / 12, 2);
			}
		    }
		$GraphData[] = $dataCol;
	     }
             $Message = "";
             if($ErrorCode != 0 ){
                  $Message = $ReturnMessage;
             }
             echo json_encode(array(
                  "GraphData" => $GraphData,
                  "ReturnMessage" => $Message,
                  "ErrorCode" => $ErrorCode
             )); die();
        } catch(Exception $e){
                echo "Error message:" . $e;
        }
}

//GOOGLE SHEET
add_action('wp_ajax_nopriv_getMMGooglesheet', 'getMMGooglesheet'); 
add_action('wp_ajax_getMMGooglesheet', 'getMMGooglesheet');
function getMMGooglesheet(){
	$sheetno = $_POST["mmYear"];
	$gsheet = 'https://spreadsheets.google.com/feeds/list/'.GOOGLE_SHEET_MM_KEY.'/'.$sheetno.'/public/values?alt=json';
	try{
	$raw = json_decode(GoogleSheet($gsheet));
	$obj = $raw->feed->entry;
	foreach ($obj as $value) {
		$data[] = array("month" => $value->{'gsx$months'}->{'$t'},
						"videorecording" => $value->{'gsx$videorecording'}->{'$t'},
						"videoconferencing" => $value->{'gsx$videoconferencing'}->{'$t'},
						"videostreaming" => $value->{'gsx$videostreaming'}->{'$t'},
						"totals" => $value->{'gsx$videorecording'}->{'$t'} + $value->{'gsx$videoconferencing'}->{'$t'} + $value->{'gsx$videostreaming'}->{'$t'}
						);
	}
		echo json_encode($data); die();
	} catch(Exception $e){
		echo "Error message:" . $e;
	}
}

add_action('wp_ajax_nopriv_getSUMMonthlyData', 'getSUMMonthlyData'); 
add_action('wp_ajax_getSUMMonthlyData', 'getSUMMonthlyData');
function getSUMMonthlyData(){
	$sheetno = $_POST["smeYear"];
	$gsheet = 'https://spreadsheets.google.com/feeds/list/'.GOOGLE_SHEET_MM_KEY.'/'.$sheetno.'/public/values?alt=json';
	try{
		$raw = json_decode(GoogleSheet($gsheet));
		$obj = $raw->feed->entry;
		foreach ((array)$obj as $value) {
			$data[] = array("month"=>$value->{'gsx$months'}->{'$t'}, 
							"event"=>$value->{'gsx$videorecording'}->{'$t'} + $value->{'gsx$videoconferencing'}->{'$t'} + $value->{'gsx$videostreaming'}->{'$t'});
		}//if(!is_null($data)){
			echo json_encode($data); die();
		//}
	} catch(Exception $e){
		echo "Error message:" . $e;
	}
}

add_action('wp_ajax_nopriv_getAVEMonthlyData', 'getAVEMonthlyData'); 
add_action('wp_ajax_getAVEMonthlyData', 'getAVEMonthlyData');
function getAVEMonthlyData(){
	$sheetno = $_POST["ameYear"];
	$gsheet = 'https://spreadsheets.google.com/feeds/list/'.GOOGLE_SHEET_MM_KEY.'/'.$sheetno.'/public/values?alt=json';
	try{
		$raw = json_decode(GoogleSheet($gsheet));
		$obj = $raw->feed->entry;
		$mytotal = 0;
		$recording = 0;
		$conference = 0;
		$streaming = 0;
		foreach ((array)$obj as $value) {
			$mytotal += $value->{'gsx$videorecording'}->{'$t'} + $value->{'gsx$videoconferencing'}->{'$t'} + $value->{'gsx$videostreaming'}->{'$t'};
			$recording += $value->{'gsx$videorecording'}->{'$t'};
			$conference += $value->{'gsx$videoconferencing'}->{'$t'};
			$streaming += $value->{'gsx$videostreaming'}->{'$t'};
		} //if(!is_null($mytotal)){

			if ($mytotal != 0){
				$data = array(
				"recording"=>$recording, "conference"=>$conference, "streaming"=>$streaming,
				'total' => (((int)$recording/$mytotal)*100) + (((int)$conference/$mytotal)*100) + (((int)$streaming/$mytotal)*100));
			}
			else {
				$data = array(
				"recording"=>0, "conference"=>0, "streaming"=>0,
				'total' => 0);
				}	
		echo json_encode($data); die();
	} catch(Exception $e){
		echo "Error message:" . $e;
	}
}
//GOOGLE SHEET
/*
* Helpdesk
*/
/*
* Helpdesk Ticket Activity Function
*/
add_action('wp_ajax_nopriv_getTicketActivity', 'getTicketActivity'); 
add_action('wp_ajax_getTicketActivity', 'getTicketActivity');
function getTicketActivity(){
		$sToken = json_decode(stripslashes($_COOKIE["_hapi_api_"]), true);
		$quarter_url = HAPI_AUTH_URL . '/getTicketActivity';
		$dates = $_POST["getdate"];
		$period = $_POST["getperiod"];
		$credentials = array(
				"Date" => $dates,
				"Period" => $period,
				"SessionID" => $sToken);
			try{
				$json = curlingData($quarter_url, $credentials);
				$jsondata = json_decode($json);
				$GraphData = $jsondata->GetTicketActivity->ReturnMessage->TicketActivity;
				$ReturnMessage = $jsondata->GetTicketActivity->ReturnMessage;
                        	$ErrorCode = $jsondata->GetTicketActivity->ErrorCode;
                        	$Message = "";
                        	if($ErrorCode != 0 ){
                                $Message = $ReturnMessage;
                        	}
                        	echo json_encode(array(
                                	"GraphData" => $GraphData,
                                	"ReturnMessage" => $Message,
                                	"ErrorCode" => $ErrorCode
                        	)); die();
				//echo json_encode($obj); die();
			} catch(Exception $e){
				echo "Error message:" . $e;
			}

}
/*
* University Virtual Learning Environment
*/
/*
* Analytics Uvle Total Active Users Function
*/
add_action('wp_ajax_nopriv_getUvleTotalActiveUsers','getUvleTotalActiveUsers');
add_action('wp_ajax_getUvleTotalActiveUsers','getUvleTotalActiveUsers');
function getUvleTotalActiveUsers(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$user_url = UVLAPI_AUTH_URL . '/getTotalActiveUsers';
	$quarter = $_POST["getUvleTotalActiveUsers"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $quarter,
		"SessionID"=> $sToken
		);
		try{
			$data = json_decode(curlingData($user_url, $credentials));
			$GraphData = $data->GetTotalActiveUsers->ReturnMessage->TotalActiveUsers;
			$ReturnMessage = $data->GetTotalActiveUsers->ReturnMessage;
                        $ErrorCode = $data->GetTotalActiveUsers->ErrorCode;
			$Message = "";
                        if($ErrorCode != 0 ){
                                $Message = $ReturnMessage;
                        }
			echo json_encode(array(
                                "GraphData" => $GraphData,
                                "ReturnMessage" => $Message,
                                "ErrorCode" => $ErrorCode
                        )); die();
		} catch(Exception $e){
			var_dump("Error message:" . $e); exit;
		}
}
/*
* Analytics Uvle Top Ten Active Courses Function
*/
add_action('wp_ajax_nopriv_getUvleTopTenActiveCourses','getUvleTopTenActiveCourses');
add_action('wp_ajax_getUvleTopTenActiveCourses','getUvleTopTenActiveCourses');
function getUvleTopTenActiveCourses(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$courses_url = UVLAPI_AUTH_URL . '/getTopTenActiveCourses';
	$months = $_POST["uvleCourseMonth"];
	$period = $_POST["uvleCoursePeriod"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $period,
		"SessionID"=> $sToken);
			try{ 
			$json = curlingData($courses_url, $credentials);
			$jsondata = json_decode($json);
			$obj = $jsondata->GetTopTenActiveCourses->ReturnMessage->TopTenActiveCourses;
			$mykey="";
			$myvalue ="";
			$mydata = [];
			foreach ($obj[$months] as $key=>$value) {
				$mykey .= $key.",";
				$myvalue .= $value.",";
			}
			$values = array_filter(explode(",",$myvalue));
			$valueskey = array_filter(explode(",",$mykey));
			for($i=1; $i<=count($values)-1; $i++) {
				$mydata[] = array("x"=>$valueskey[$i],"y"=>$values[$i], "title"=>$values[0]);
			}
			$ReturnMessage = $jsondata->GetTopTenActiveCourses->ReturnMessage;
                        $ErrorCode = $jsondata->GetTopTenActiveCourses->ErrorCode;
                        $Message = "";
                        if($ErrorCode != 0 ){
                                $Message = $ReturnMessage;
                        }
			echo json_encode(array(
                                "GraphData" => $mydata,
                                "ReturnMessage" => $Message,
                                "ErrorCode" => $ErrorCode
                        )); die();

			echo json_encode($mydata); die();
		} catch(Exception $e){
			var_dump("Error message:" . $e); exit;
		}
}
/*
* Analytics Uvle Top Ten Active Courses Dropdown Function
*/
add_action('wp_ajax_nopriv_getTTCDropdown', 'getTTCDropdown'); 
add_action('wp_ajax_getTTCDropdown', 'getTTCDropdown');
function getTTCDropdown(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$courses_url = UVLAPI_AUTH_URL . '/getTopTenActiveCourses';
	$period = "";
	$period = $_POST["uvleCoursePeriod"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $period,
		"SessionID"=> $sToken
		);
	try{
	$json = curlingData($courses_url, $credentials);
	$jsondata = json_decode($json);
	$mydata = [];
	$obj = $jsondata->GetTopTenActiveCourses->ReturnMessage->TopTenActiveCourses;
	foreach($obj as $key => $value) {
		$mydata[] = array("value"=>$key,"text"=>$value->y);
	}
		echo json_encode($mydata); die(); 
	} catch(Exception $e){
		var_dump("Error message:" . $e); exit;
	}
}
/*
* Analytics Uvle Top Five Active Categories Function
*/
add_action('wp_ajax_nopriv_getUvleTopFiveActiveCategories','getUvleTopFiveActiveCategories');
add_action('wp_ajax_getUvleTopFiveActiveCategories','getUvleTopFiveActiveCategories');
function getUvleTopFiveActiveCategories(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$category_url = UVLAPI_AUTH_URL . '/getTopFiveActiveCategories';
	$months = $_POST["uvleCategoryMonth"];
	$period = $_POST["uvleCategoryPeriod"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $period,
		"SessionID"=> $sToken);
			try{ 
			$json = curlingData($category_url, $credentials);
			$jsondata = json_decode($json);
			$obj = $jsondata->GetTopFiveActiveCategories->ReturnMessage->TopFiveActiveCategories;
			$mykey="";
			$myvalue ="";
			$mydata = [];
			foreach ($obj[$months] as $key=>$value) {
				$mykey .= $key.",";
				$myvalue .= $value.",";
			}
			$values = array_filter(explode(",",$myvalue));
			$valueskey = array_filter(explode(",",$mykey));
			for($i=1; $i<=count($values)-1; $i++) {
				$mydata[] = array("x"=>$valueskey[$i],"y"=>$values[$i], "title"=>$values[0]);
			}
			$ReturnMessage = $jsondata->GetTopFiveActiveCategories->ReturnMessage;
                        $ErrorCode = $jsondata->GetTopFiveActiveCategories->ErrorCode;
                        $Message = "";
                        if($ErrorCode != 0 ){
                                $Message = $ReturnMessage;
                        }
                        echo json_encode(array(
                                "GraphData" => $mydata,
                                "ReturnMessage" => $Message,
                                "ErrorCode" => $ErrorCode
                        )); die();

			//echo json_encode($mydata); die();
		} catch(Exception $e){
			var_dump("Error message:" . $e); exit;
		}
}
/*
* Analytics Uvle Top Five Active Categories Dropdown Function
*/
add_action('wp_ajax_nopriv_getTFADropdown', 'getTFADropdown'); 
add_action('wp_ajax_getTFADropdown', 'getTFADropdown');
function getTFADropdown(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$category_url = UVLAPI_AUTH_URL . '/getTopFiveActiveCategories';
	$period = "";
	$period = $_POST["uvleCategoryPeriod"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $period,
		"SessionID"=> $sToken
		);
	try{
	$json = curlingData($category_url, $credentials);
	$jsondata = json_decode($json);
	$mydata = [];
	$obj = $jsondata->GetTopFiveActiveCategories->ReturnMessage->TopFiveActiveCategories;
	foreach($obj as $key => $value) {
		$mydata[] = array("value"=>$key,"text"=>$value->y);
	}
		echo json_encode($mydata); die(); 
	} catch(Exception $e){
		var_dump("Error message:" . $e); exit;
	}
}
/*
* Analytics Uvle Total New Users Function
*/
add_action('wp_ajax_nopriv_getUvleTotalNewUsers','getUvleTotalNewUsers');
add_action('wp_ajax_getUvleTotalNewUsers','getUvleTotalNewUsers');
function getUvleTotalNewUsers(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$user_url = UVLAPI_AUTH_URL . '/getTotalNewUsers';
	$quarter = $_POST["getUvleTotalNewUsers"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $quarter,
		"SessionID"=> $sToken
		);
		try{
			$data = json_decode(curlingData($user_url, $credentials));
			$GraphData = $data->GetTotalNewUsers->ReturnMessage->TotalNewUsers;
			$ReturnMessage = $data->GetTotalNewUsers->ReturnMessage;
             		$ErrorCode = $data->GetTotalNewUsers->ErrorCode;
             		$Message = "";
             		if($ErrorCode != 0 ){
                  		$Message = $ReturnMessage;
             		}
			echo json_encode(array(
                  		"GraphData" => $GraphData,
                  		"ReturnMessage" => $Message,
                  		"ErrorCode" => $ErrorCode
             		)); die();
		} catch(Exception $e){
			var_dump("Error message:" . $e); exit;
		}
}
/*
* Analytics Uvle Total Course Created Function
*/
add_action('wp_ajax_nopriv_getUvleTotalCourseCreated','getUvleTotalCourseCreated');
add_action('wp_ajax_getUvleTotalCourseCreated','getUvleTotalCourseCreated');
function getUvleTotalCourseCreated(){
	$sToken = json_decode(stripslashes($_COOKIE["_uvlapi_api_"]), true);
	$user_url = UVLAPI_AUTH_URL . '/getTotalCourseCreated';
	$quarter = $_POST["getUvleTotalCourseCreated"];
	$credentials = array(
		"Date" => date('Y-m-d'),
		"Period" => $quarter,
		"SessionID"=> $sToken
		);
			try{
			$json = curlingData($user_url, $credentials);
			$jsondata = json_decode($json);
			$GraphData = $jsondata->GetTotalCourseCreated->ReturnMessage->TotalCourseCreated;
			$ReturnMessage = $jsondata->GetTotalCourseCreated->ReturnMessage;
                        $ErrorCode = $jsondata->GetTotalCourseCreated->ErrorCode;
                        $Message = "";
                        if($ErrorCode != 0 ){
                                $Message = $ReturnMessage;
                        }
                        echo json_encode(array(
                                "GraphData" => $GraphData,
                                "ReturnMessage" => $Message,
                                "ErrorCode" => $ErrorCode
                        )); die();
		} catch(Exception $e){
			var_dump("Error message:" . $e); exit;
		}
}
/*
* Get Latest Post Content Function
*/
add_action('wp_ajax_nopriv_getLatestPost','getLatestPost');
//add_action('wp_ajax_getLatestPost','getLatestPost');
function getLatestPost(){
        $currentURL = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $domain2 = $_SERVER['HTTP_HOST'] . '/';
        $args = array('numberposts'=> 1, 'post_status'=>'publish');
        $recent_posts = wp_get_recent_posts($args);
        foreach ($recent_posts as $posts) {
                $array = array('postid'	=>$posts['ID'],
			'cookies'	=>$_COOKIE['_ilc_setcookie_'],
			'currentdate'	=>abs(time()),
			'nextweek'	=>abs(strtotime($posts['post_date']) + (60*60*7*24)),
			'title'		=>$posts['post_title'],
			'permalink'	=>get_permalink($posts['ID']),
			'excerpt'	=>wp_trim_words(apply_filters('the_content', get_post_field('post_content', $posts['ID'])), 50));
                $postID = $posts['ID'];
        }
	$domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
	setcookie('_ilc_setcookie_',$postID, $array['nextweek'], '/', $domain);
	echo json_encode($array); exit;
}
/*
* WP Security Measures
*/
function remove_version() {
 return '';
 }
 add_filter('the_generator', 'remove_version');

 function wrong_login() {
 return 'Wrong username or password.';
 }
 add_filter('login_errors', 'wrong_login');
/*add_action('pre_get_posts', 'removeteamCategory_archiveDrop');
function removeteamCategory_archiveDrop(){
  if(is_archive()){
   $query->set('cat',array('-464'));
}
return $query;
}*/

/*
function ut_searchform_filter( $form ) {

    $searchform = '<form role="search" method="get" class="search-form" id="searchform" action="' . esc_url( home_url( '/' ) ) . '">
        <label>
            <span>' .__( 'Search for:' , 'unitedthemes' ) . '</span>
            <input type="search" class="search-field" placeholder="' .esc_attr__( 'Google Search' , 'unitedthemes' ) . '" value="' . esc_attr( get_search_query() ) . '" name="s" title="' . __( 'Search for:' , 'unitedthemes' ) . '">
<gcse:search enableAutoComplete="true"></gcse:search>
</label>
        <input type="submit" class="search-submit" value="' . esc_attr__( 'Search' , 'unitedthemes' ) . '">
        </form>';

        return $searchform;
    }
add_filter( 'get_search_form', 'ut_searchform_filter' );
*/
/*
* Replace WP Search Input
*/
function ut_searchform_filter( $form ) {
    $searchform = '<gcse:search enableAutoComplete="true"></gcse:search>';
    return $searchform;
    }
add_filter( 'get_search_form', 'ut_searchform_filter' );

/*function my_searchwp_live_search_posts_per_page() {
	return 20;
}
add_filter( 'searchwp_live_search_posts_per_page', 'my_searchwp_live_search_posts_per_page' );*/
//Menu Search Dashicon
/*
* Add Search Input In Primary Menu
*/
function add_search_to_wp_menu ( $items, $args ) {
	if( 'primary' === $args -> theme_location ) {
		$items .= '<li class="menu-item menu-item-search img-grow">';
		$items .= '<a href="https://www.youtube.com/channel/UCd0q6H7YTyV9IAdeai2wYjA/videos" target="_blank"><span class="dashicons dashicons-video-alt3"></span></a>';
		$items .= '</li>';
		$items .= '<li class="menu-item menu-item-search img-grow">';
		$items .= '<span class="dashicons dashicons-search google-search-open"></span>';
		$items .= '</li>';
                //$items .= '<li class="menu-item mobile-google-search">';
                //$items .= '<gcse:search enableAutoComplete="true"></gcse:search>';
                //$items .= '</li>';
			}
		return $items;
	}
add_filter('wp_nav_menu_items','add_search_to_wp_menu',10,2);
/*Google Modal Search
function add_modal_search(){

		<div class="search-modal">
			<div class="search-modal-content">
				<div class="search-modal-header">
					<span class="close">&times;</span>
				</div>
			<gcse:search enableAutoComplete="true"></gcse:search>
			</div>
		</div>
 } add_action('search_modal','add_modal_search'); */
/*
* Check If Homepage Function
*/
add_action('init', 'check_if_homepage', -1000000);
function check_if_homepage(){
	$currentURL = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$domain2 = $_SERVER['HTTP_HOST'] . '/';
	if($domain2 == $currentURL){
		return true;
	} return false;
}
/*
* Add Modal Latest Post In Homepage
*/
function modal_latest_post(){
	if(check_if_homepage()){
		echo "<div id='my-latest-post'></div>";
	}
}
add_action('my_latest_post', 'modal_latest_post');
/*
* Helpdesk Modal Form
*/
function modal_helpdesk(){ 
if(is_page('multimedia-services') OR is_page('contact')) { ?>
		<div class="ordinary-modal modal-helpdesk">
			<div class="ordinary-modal-content">
				<div class="ordinary-modal-header">
					<span class="close">&times;</span>
				</div>
				<iframe src="https://helpdesk.ilc.upd.edu.ph">
					<p>Your browser does not support iframes.</p>
				</iframe>
			</div>
		</div>
<?php }
}
add_action('pop_modal_helpdesk', 'modal_helpdesk');
/*
* Google Modal Survey Form
*/
function modal_google_surveyform(){ 
     if(is_page('multimedia-services')) { ?>
		<div class="ordinary-modal modal-surveyform">
			<div class="ordinary-modal-content">
				<div class="ordinary-modal-header">
					<span class="close">&times;</span>
				</div>
				<iframe src="https://docs.google.com/a/dilc.upd.edu.ph/forms/d/e/1FAIpQLSemkmf2uuXA4WSyk-xzCYFuvuFVGM195rYS8aCwUOJl-_uhfw/viewform?c=0&w=1">
					<p>Your browser does not support iframes.</p>
				</iframe>
			</div>
		</div>
<?php }
}
add_action('pop_modal_surveyform', 'modal_google_surveyform');
/*
* Add Scroll Up Button
*/
function scroll_up_btn(){
  ?>
       <a href="#" class="myscroll-to-top"><span class="dashicons dashicons-arrow-up-alt"></span></a>
<?php
}
add_action('scroll_up_button', 'scroll_up_btn');

/*
* WP Login Logo
*/
function my_login_logo() { 
?>
    <style type="text/css">
        #login h1 a, .login h1 a {
            background-image: url('https://ilc.upd.edu.ph/wp-content/uploads/2017/04/01-ILC-icon-A-edited.png');
		height:200px;
		width:200px;
		background-size: 200px 200px;
		background-repeat: no-repeat;
        	padding-bottom: 10px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );
/*
* WP Login Logo URL
*/
function my_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'my_login_logo_url' );
/*
* Posts Social Media Links
*/
function social_share_buttons(){
        $postTitle = get_the_title();
        $postPermalink = get_permalink();
        $facebook = 'https://facebook.com/sharer/sharer.php?u=' . $postPermalink;
        $twitter = "https://twitter.com/intent/tweet?text=Share: " . $postTitle . '&amp;url=' . $postPermalink;
     ?>
        <div class="social-media-container">
            <h4>Share on</h4>
            <ul class="social-share">
                <li><a href="<?php echo $facebook; ?>" target="_blank"><span class="dashicons dashicons-facebook"></span></a></li>
                <li><a href="<?php echo $twitter; ?>" target="_blank"><span class="dashicons dashicons-twitter"></span></a></li>
            </ul>
        </div>
<?php
}
add_action('add_share_buttons', 'social_share_buttons');
/*
* Desktop Google Search Input
*/
function add_header_googlesearch(){ ?>
	 <div class="header-google-search">
             <gcse:search enableAutoComplete="true"></gcse:search>
	</div>
<?php
}
add_action('header_google_search', 'add_header_googlesearch');
/*
* Mobile Google Search Input
*/
function add_mobile_googlesearch(){ ?>
            <section>
            <div class="mobiletablet-google-search hide-on-desktop">
                <gcse:search enableAutoComplete="true"></gcse:search>
            </div>
            </section>
<?php
}
add_action('mobile_google_search', 'add_mobile_googlesearch');
/*
* Mobile Google Search Icons
*/
function add_mobile_icon_googlesearch(){ ?>
                    <style>.search-icon-sample{ 
                        position: fixed; 
                        right: 50px; 
                        top: 20px; 
                        float: left; }
			.youtube-icon-sample a span{
			position: fixed; 
                        right: 100px; 
                        top: 20px; 
                        float: left;
			color:#800000;
			}
			@media screen and (max-width: 420px) {
				.youtube-icon-sample a span {right:175px;top:70px;} 
				.search-icon-sample {right:125px;top:70px;}
			}
                    </style>
		   <div class="hide-on-desktop mobile-item-search youtube-icon-sample">
			<a href="https://www.youtube.com/channel/UCd0q6H7YTyV9IAdeai2wYjA/videos" target="_blank"><span class="dashicons dashicons-video-alt3"></span></a>
		    </div>
                    <div class="hide-on-desktop mobile-item-search mobiletable-icon-search search-icon-sample">
			<span class="dashicons dashicons-search"></span>
                    </div>
<?php
}
add_action('mobile_icon_google_search', 'add_mobile_icon_googlesearch');
/*
* More Link In Post
*/
function change_excerpt_elipsis($post){
  return '<a rel="nofollow" href="'. get_permalink($post->ID) . '" target="_blank">' . '  Read more...' . '</a>';;
}
add_filter('excerpt_more', 'change_excerpt_elipsis');
/*
* Homepage Facebook In Tab
*/
function facebook_tab(){
if(check_if_homepage()){
	?>
<script type='text/javascript'>
(function(d, s, id) {
  var js; 
  var fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = '//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

jQuery(document).ready(function($){
    $(window).bind("load resize", function(){
       //if(jQuery(document).hasClass('fb-container')){
      setTimeout(function() {
      var container_width = $('.fb-container').width();
          $('.fb-container').html('<div class="fb-page" ' +
            'data-href="https://www.facebook.com/ilcdiliman"' +
            ' data-width="' + container_width + '" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/ilcdiliman"><a href="https://www.facebook.com/ilcdiliman">Interactive Learning Center - Diliman</a></blockquote></div></div>');
            FB.XFBML.parse( );
          }, 100);
           //}
       });
});
</script>

<?php
} }
add_action('load_facebook', 'facebook_tab');
?>
<?php
add_action('ogmeta_tags', 'add_metatags');
function add_metatags(){
     if(check_if_homepage()){ 
     $description .= "The Interactive Learning Center or ILC Diliman is under the Office of the Vice Chancellor ";
     $description .= "for Academic Affairs (OVCAA) mandated to help in the development of faculty expertise ";
     $description .= "in the use of technologies in teaching and learning.  It is located at Magsaysay Avenue ";
     $description .= "corner Apacible Street.  ILC Diliman operates the on-line learning management system ";
     $description .= "of the university, as well as promotes the production and use of interactive instructional materials.";
?>
	<meta property="og:description" content="<?php echo $description ?>" />
    	<meta property="og:type" content="website" />
	<meta property="og:title" content="Interactive Learning Center" />
	<meta property="og:image" content="https://ilc.upd.edu.ph/wp-content/uploads/2017/06/2-ILC-Diliman.jpg" />
	<meta property="og:url" content="https://ilc.upd.edu.ph/" />
	<meta property="og:site_name" content="ILC Diliman" />
	<meta name="description" content="<?php echo $description ?>" />
<?php } else {
	$article_link = get_permalink($post->ID);
	$featured_img = get_the_post_thumbnail_url($post->ID);
	$article_title = get_the_title($post->ID);
	//$article_excerpt = get_the_excerpt($post->ID); 
?>
	<meta property="og:description" content="" />
        <meta property="og:type" content="article" />
        <meta property="og:title" content="<?php echo $article_title; ?>" />
        <meta property="og:image" content="<?php echo $featured_img; ?>" />
	<!-- meta property="og:image:type" content="" / -->
        <meta property="og:url" content="<?php echo $article_link; ?>" />
	<meta property="og:image:width" content="600" />
	<meta property="og:image:height" content="315" />
	<meta property="fb:app_id" content="229919550916869">
<?php
 }
}
function check_if_lo_page(){
     $url = array();
     $url = explode('/', $_SERVER['REQUEST_URI']);
     return in_array("learning-objects", $url);
}
function enable_flash_notification(){
     if(check_if_lo_page()){
?>
<style>
.btn-flash-enable:hover{transform:scale(1.2);-webkit-transform: scale(1.2);-moz-transform: scale(1.2);-o-transform: scale(1.2);}
</style>
<div class="flash-notif" style="width: 100%;height:5rem;background-color:#00573f;color:#fff;text-align:center;padding: 1rem;position: fixed;bottom:0;opacity:0.8;display:none;">
     <p style="font-size:11pt !important;margin:0px;">Please enable Adobe Flash Player to use the Learning Objects. Thank you!</p>
     <span class="btn-flash-enable" style="height:3rem;width:6rem;background-color:red;margin:0;padding:.3rem;cursor:pointer;">How to enable?</span>
</div>
<?php
 }
}
add_action('enable_flash', 'enable_flash_notification');

/**
 * WP Beginner pagination
 */
function wpbeginner_numeric_posts_nav() {

    if( is_singular() )

        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */

    if( $wp_query->max_num_pages <= 1 )

        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

    $max   = intval( $wp_query->max_num_pages ) - 4; //Temporary fix to hide empty pages

// print_r(get_previous_posts_link("test"));

    /** Add current page to the array */

    if ( $paged >= 1 )

        $links[] = $paged;

    /** Add the pages around the current page to the array */

    if ( $paged >= 3 ) {

        $links[] = $paged - 1;

        $links[] = $paged - 2;

    }

    if ( ( $paged + 2 ) <= $max ) {

        $links[] = $paged + 2;

        $links[] = $paged + 1;

    }

    echo '<ul class="blog-pagination text-center">' . "\n";

    /** Previous Post Link */

    if ( get_previous_posts_link() )

        printf( '<li class="btn btn-outline-none">%s</li>' . "\n", get_previous_posts_link("Prev") );

    /** Link to first page, plus ellipses if necessary */

    if ( ! in_array( 1, $links ) ) {

        $class = 1 == $paged ? ' class="btn btn-outline-none active"' : ' class="btn btn-outline-none"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )

            echo '<li class="btn btn-outline-none disabled">…</li>';

    }

    /** Link to current page, plus 2 pages in either direction if necessary */

    sort( $links );

    foreach ( (array) $links as $link ) {

        $class = $paged == $link ? ' class="btn btn-outline-none active"' : ' class="btn btn-outline-none"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );

    }

    /** Link to last page, plus ellipses if necessary */

    if ( ! in_array( $max, $links ) ) {

        if ( ! in_array( $max - 1, $links ) )

            echo '<li class="btn btn-outline-none disabled">…</li>' . "\n";

        $class = $paged == $max ? ' class="btn btn-outline-none active"' : ' class="btn btn-outline-none"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );

    }

    /** Next Post Link */

    if ( get_next_posts_link() )

        printf( '<li class="btn btn-outline-none">%s</li>' . "\n", get_next_posts_link("Next", $max) ); //Added $max page variable

    echo '</ul>' . "\n";

}
function wpbeginner_numeric_posts_nav_two() {

    if( is_singular() )

        return;

    global $wp_query;

    /** Stop execution if there's only 1 page */

    if( $wp_query->max_num_pages <= 1 )

        return;

    $paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;

    $max   = intval( $wp_query->max_num_pages ); //Temporary fix to hide empty pages

// print_r(get_previous_posts_link("test"));

    /** Add current page to the array */

    if ( $paged >= 1 )

        $links[] = $paged;

    /** Add the pages around the current page to the array */

    if ( $paged >= 3 ) {

        $links[] = $paged - 1;

        $links[] = $paged - 2;

    }

    if ( ( $paged + 2 ) <= $max ) {

        $links[] = $paged + 2;

        $links[] = $paged + 1;

    }

    echo '<ul class="blog-pagination text-center">' . "\n";

    /** Previous Post Link */

    if ( get_previous_posts_link() )

        printf( '<li class="btn btn-outline-none">%s</li>' . "\n", get_previous_posts_link("Prev") );

    /** Link to first page, plus ellipses if necessary */

    if ( ! in_array( 1, $links ) ) {

        $class = 1 == $paged ? ' class="btn btn-outline-none active"' : ' class="btn btn-outline-none"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )

            echo '<li class="btn btn-outline-none disabled">…</li>';

    }

    /** Link to current page, plus 2 pages in either direction if necessary */

    sort( $links );

    foreach ( (array) $links as $link ) {

        $class = $paged == $link ? ' class="btn btn-outline-none active"' : ' class="btn btn-outline-none"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );

    }

    /** Link to last page, plus ellipses if necessary */

    if ( ! in_array( $max, $links ) ) {

        if ( ! in_array( $max - 1, $links ) )

            echo '<li class="btn btn-outline-none disabled">…</li>' . "\n";

        $class = $paged == $max ? ' class="btn btn-outline-none active"' : ' class="btn btn-outline-none"';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );

    }

    /** Next Post Link */

    if ( get_next_posts_link() )

        printf( '<li class="btn btn-outline-none">%s</li>' . "\n", get_next_posts_link("Next", $max) ); //Added $max page variable

    echo '</ul>' . "\n";

}
//SHOW CATEGORIES
add_action('show_categories', 'list_categories');
function list_categories(){
        echo '<div class="list-category">';
                wp_list_categories(array('orderby' => 'name',
                        'order' => 'ASC',
                        'echo' => true,
                        'exclude_tree' => array(440, 441, 403, 410, 464, 477),
                        'hide_title_if_empty' => true,
                        'title_li' => ''));
        echo '</div>';
}
//SHOW POSTS UNDER EACH CATEGORIES
add_action('show_cat_post', 'list_cat_post');
function list_cat_post(){
//for each category, show all posts
global $post;
$cat_args=array(
  'orderby' => 'name',
  'order' => 'ASC',
  'exclude_tree' => array(440, 441, 403, 410, 464, 477)
   );
$categories=get_categories($cat_args);
  echo "<div class='list-category-title'>";
  foreach($categories as $category) {
        echo '<li class="categories-title"><a href="' . get_category_link( $category->term_id ) . '">' . $category->name.'</a></li>';
  }
  echo "</div>";
  echo "<div class='list-category' style='position:absolute;background-color:#fff;max-height:300px;overflow-y:scroll;'>";
  foreach($categories as $category) {
    $args=array(
      'showposts' => -1,
      'category__in' => array($category->term_id),
      'caller_get_posts'=>1
    );
    $posts=get_posts($args);
      if ($posts) {
        foreach($posts as $post) {
          setup_postdata($post); ?>
          <span class="categories-posts catpost-<?php echo $category->name ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></span>
          <?php
        } // foreach($posts
      } // if ($posts
    } // foreach($categories
   echo "</div>";
}
//Privacy Policy Footer
add_action('wp_ajax_nopriv_footer_agreement_and_policy','footer_agreement_and_policy');
add_action('wp_ajax_footer_agreement_and_policy', 'footer_agreement_and_policy');
function footer_agreement_and_policy(){
        if(empty($_COOKIE['_ilc_accept_policy_']) OR $_COOKIE['_ilc_accept_policy_'] === null OR
                $_COOKIE['_ilc_accept_policy_'] != 'accepted' OR !isset($_POST['accept'])){
                $privacy = 0;
        }
        if($_COOKIE['_ilc_accept_policy_'] === 'accepted'){
                $privacy = 1;
        }
        if(!empty($_POST['accept']) AND $_POST['accept'] == 'accepted'){
                $domain = COOKIE_DOMAIN ? COOKIE_DOMAIN : $_SERVER['HTTP_HOST'];
                $now = new \DateTime('now');
                $month = $now->format('m');
                $year = $now->format('Y');
                $cookie_name = "_ilc_accept_policy_";
                if($month >= "01" && $month < "07") {
                        $duration = strtotime("01-07-" . $year);
                }
                if($month >= "07" && $month > "01") {
                        $year = date('Y', '+' . strtotime("1 year") . ' years');
                        $duration = strtotime("01-01-" . $year);
                }
                setcookie($cookie_name,'accepted',$duration,'/',$domain); // set cookie
                $privacy = 1;
        }
        echo json_encode(array('privacy' => $privacy)); die();
}
?>
