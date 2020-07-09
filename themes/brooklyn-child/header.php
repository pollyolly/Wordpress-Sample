<?php

/*
 * The header for our theme
 * by www.unitedthemes.com
 */ 

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<!--
##########################################################################################

BROOKLYN THEME BY UNITED THEMES 
WWW.UNITEDTHEMES.COM

BROOKLYN THEME DESIGNED BY MARCEL MOERKENS
BROOKLYN THEME DEVELOPED BY MARCEL MOERKENS & MATTHIAS NETTEKOVEN 

POWERED BY UNITED THEMES - WEB DEVELOPMENT FORGE EST.2011

COPYRIGHT 2011 - 2015 ALL RIGHTS RESERVED BY UNITED THEMES

##########################################################################################
-->
<head>
    <meta name="google-site-verification" content="8cRfY1hvXb9MJEaXmO8SaOuk5Cb_ZIqI67N2Ge9tl1g" />
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <link rel="manifest" href="<?php echo get_stylesheet_directory_uri() .'/manifest.json'?>">
  <!-- FB Meta tags -->
  <!-- Add to home screen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#fff">
    <meta name="apple-mobile-web-app-title" content="ILC Diliman">
    <meta name="msvalidate.01" content="9AFF49D3CD18A57630BF6AF50A415FA4" />
    <link rel="apple-touch-icon" href="https://ilc.upd.edu.ph/wp-content/uploads/2018/01/ilc-small-icon.png">
    <!-- Add to Windows Desktop -->
    <meta name="msapplication-TileImage" content="https://ilc.upd.edu.ph/wp-content/uploads/2018/01/ilc-small-icon.png">
    <meta name="msapplication-TileColor" content="#7b1113">
    <!-- Prefetch DNS -->
    <link rel='dns-prefetch' href='//www.google-analytics.com' />
    <link rel='dns-prefetch' href='//ajax.googleapis.com' />
    <link rel='dns-prefetch' href='//apis.google.com' />
    <link rel='dns-prefetch' href='//platform.twitter.com' />
    <link rel='dns-prefetch' href='//wp2e.org' />
    <link rel='dns-prefetch' href='//connect.facebook.net' />

    <!-- Add to Home Screen Pop Up -->
    <?php do_action('ogmeta_tags'); ?>
    <?php ut_meta_hook(); //action hook, see inc/ut-theme-hooks.php ?>
    
        
    <?php if ( defined('WPSEO_VERSION') ) : ?>
		
        <!-- Title -->
        <title><?php wp_title(); ?></title>

	<?php else : ?>
    	
   		<?php ut_meta_theme_hook(); ?>
    
    <?php endif; ?>
    
    <!-- RSS & Pingbacks -->
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11">
    
    <!-- Favicon -->
	<?php if( ot_get_option( 'ut_favicon' ) ) : ?>
        
        <?php 
        
        /* get icon info */
        $favicon = ot_get_option( 'ut_favicon' );
        $favicon_info = pathinfo( $favicon ); 
        $type = NULL;
        
        if( isset($favicon_info['extension']) && $favicon_info['extension'] == 'png' ) {
            $type = 'type="image/png"';
        }
        
         if( isset($favicon_info['extension']) && $favicon_info['extension'] == 'ico' ) {
            $type = 'type="image/x-icon"';
        }
        
         if( isset($favicon_info['extension']) && $favicon_info['extension'] == 'gif' ) {
            $type = 'type="image/gif"';
        }
        
        ?>
                
        <link rel="shortcut&#x20;icon" href="<?php echo $favicon; ?>" <?php echo $type; ?> />
        <link rel="icon" href="<?php echo $favicon; ?>" <?php echo $type; ?> />
        
    <?php endif; ?>
    
    <!-- Apple Touch Icons -->    
    <?php if( ot_get_option( 'ut_apple_touch_icon_iphone' ) ) :?>
    <link rel="apple-touch-icon" href="<?php echo ot_get_option( 'ut_apple_touch_icon_iphone' ); ?>">
    <?php endif; ?>
    
    <?php if( ot_get_option( 'ut_apple_touch_icon_ipad' ) ) : ?>
    <link rel="apple-touch-icon" sizes="72x72" href="<?php echo ot_get_option( 'ut_apple_touch_icon_ipad' ); ?>" />
    <?php endif; ?>
    
    <?php if( ot_get_option( 'ut_apple_touch_icon_iphone_retina' ) ) : ?>
    <link rel="apple-touch-icon" sizes="114x114" href="<?php echo ot_get_option( 'ut_apple_touch_icon_iphone_retina' ); ?>" />
    <?php endif; ?>
    
    <?php if( ot_get_option( 'ut_apple_touch_icon_ipad_retina' ) ) :?>
    <link rel="apple-touch-icon" sizes="144x144" href="<?php echo ot_get_option( 'ut_apple_touch_icon_ipad_retina' ); ?>" />
    <?php endif; ?>
        
    <!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]--> 
<style>
/*http://ilc.upd.edu.ph/wp-content/plugins/post-grid/assets/global/css/style.layout.css*/
/*Skins css*/
/*################### flat ########################*/
.layer-content .flat {overflow: hidden;}
/*################### flat ########################*/
.layer-content .flat-center {overflow: hidden;}
/*################### flat-right ########################*/
.layer-content .flat-right {overflow: hidden;}
/*################### flat-left ########################*/
.layer-content .flat-left {overflow: hidden;}
/*################### wc-center-price ########################*/
.layer-content .wc-center-price {overflow: hidden;text-align: center;}
.layer-content .wc-center-price .wc_sale_price {}
/*################### wc-center-cart ########################*/
.layer-content .wc-center-cart {overflow: hidden;text-align: center;}
.layer-content .wc-center-cart .wc_sale_price  {}
/* http://ilc.upd.edu.ph/wp-content/plugins/siteorigin-panels/css/front.css */
.panel-grid {zoom: 1;}
.panel-grid:before {content: '';display: block;}
.panel-grid:after {content: '';display: table;clear: both;}
.panel-grid-cell {-ms-box-sizing: border-box;-moz-box-sizing: border-box;-webkit-box-sizing: border-box;box-sizing: border-box;min-height: 1em;}
.panel-grid-cell .so-panel {zoom: 1;}
.panel-grid-cell .so-panel:before {content: '';display: block;}
.panel-grid-cell .so-panel:after {content: '';display: table;clear: both;}
.panel-grid-cell .panel-last-child {margin-bottom: 0;}
.panel-grid-cell .widget-title {margin-top: 0;}
.panel-row-style {zoom: 1;}
.panel-row-style:before {content: '';display: block;}
.panel-row-style:after {content: '';display: table;clear: both;}
/* http://ilc.upd.edu.ph/wp-content/plugins/so-widgets-bundle/widgets/button/css/style.css */
.ow-button-base {zoom: 1;/* All the special styles */}
.ow-button-base:before { content: '';display: block;}
.ow-button-base:after {content: '';display: table;clear: both;}
.ow-button-base a {text-align: center;display: inline-block;cursor: pointer;text-decoration: none;line-height: 1em;}
.ow-button-base a .sow-icon-image,
.ow-button-base a [class^="sow-icon-"] {font-size: 1.3em;height: 1em;width: auto; margin: -0.1em 0.75em -0.2em -0.75em;display: block;float: left;}
.ow-button-base a .sow-icon-image {width: 1em;background-size: cover;}
.ow-button-base.ow-button-align-left {text-align: left;}
.ow-button-base.ow-button-align-right {text-align: right;}
.ow-button-base.ow-button-align-center {text-align: center;}
.ow-button-base.ow-button-align-justify a {display: block;}
</style>
    <?php wp_head(); ?>
<script>
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-7493571-2']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

   jQuery(document).ready(function(){
	jQuery.ajax({
		type: "POST",
		url: ajaxUrl.ajax_url,
		data: {
			action: "setWebsiteCookies"
		},
		success: function(data){
			console.log(data);
		},
		error: function(data){
			console.log(data);
		}
	});
   });
</script>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "Organization",
  "url": "https://ilc.upd.edu.ph",
  "logo": "https://ilc.upd.edu.ph/wp-content/uploads/2016/07/cropped-01-ILC-icon-A-edited-e1469493710565.png",
  "contactPoint": [{
    "@type": "ContactPoint",
    "telephone": "+63 2 920-9556",
    "contactType": "customer service"
  }],
  "sameAs": [
     "https://facebook.com/ilcdiliman",
     "https://twitter.com/updilc"
  ],
  "potentialAction": {
    "@type": "SearchAction",
    "target": "https://ilc.upd.edu.ph/search?q={search_term_string}",
    "query-input": "required name=search_term_string"
  }
}
</script>
</head>

<?php 

/*
|--------------------------------------------------------------------------
| Scroll Effect and Speed
|--------------------------------------------------------------------------
*/

$scrollto 		= ot_get_option('ut_scrollto_effect');
$scrollto 		= !empty( $scrollto['easing'] ) ? $scrollto['easing'] : 'easeInOutExpo' ;
$scrollspeed 	= ot_get_option('ut_scrollto_speed'  , '650'); 

?>

<body id="ut-sitebody" <?php body_class(); ?> data-scrolleffect="<?php echo $scrollto; ?>" data-scrollspeed="<?php echo $scrollspeed; ?>">

<a class="ut-offset-anchor" id="top" style="top:0px !important;"></a>

<?php 

/*
|--------------------------------------------------------------------------
| Pre Loader Overlay
|--------------------------------------------------------------------------
*/

if( ot_get_option('ut_use_image_loader') == 'on' ) : 
	
	if( ut_dynamic_conditional('ut_use_image_loader_on') ) : ?>
	
	<div class="ut-loader-overlay"></div>

	<?php endif; ?>

<?php endif; ?>


<?php ut_before_header_hook(); // action hook, see inc/ut-theme-hooks.php ?> 


<?php

/*
|--------------------------------------------------------------------------
| Navigation Setting
|--------------------------------------------------------------------------
*/

/* skin */
$ut_navigation_skin = ot_get_option('ut_navigation_skin' , 'ut-header-light');

/* visibility */
$headerstate = NULL;

if( is_home() || is_front_page() || is_singular('portfolio') || get_post_meta( get_the_ID() , 'ut_activate_page_hero' , true ) == 'on' ) {
	
	if( ot_get_option('ut_navigation_state' , 'off') == 'off' ) {
		$headerstate = 'ha-header-hide';
	}

}

/* width */
$navigation_width = ot_get_option('ut_navigation_width' , 'centered');
$logo_push = ( $navigation_width == 'fullwidth' ) ? 'push-5' : '';
$navigation_pull = ( $navigation_width == 'fullwidth' ) ? 'pull-5' : '';
			
/* main navigation settings*/
$mainmenu = array('echo'             => false,
                  'container'        => 'nav',
                  'container_id'     => 'navigation',
                  'fallback_cb' 	 => 'ut_default_menu',
                  'container_class'  => 'grid-80 hide-on-tablet hide-on-mobile ' . $navigation_pull ,
                  'items_wrap'       => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                  'theme_location'   => 'primary', 
                  'walker'           => new ut_menu_walker()
);

/* mobile navigation settings */						 
$mobilemenu = array('echo'              => false,
                    'container'        	=> 'nav',
                    'container_id'    	=> 'ut-mobile-nav',
                    'menu_id'		   	=> 'ut-mobile-menu',
                    'menu_class'	   	=> 'ut-mobile-menu',
                    'fallback_cb' 	   	=> 'ut_default_menu',
                    'container_class'  	=> 'ut-mobile-menu mobile-grid-100 tablet-grid-100 hide-on-desktop',
                    'items_wrap'       	=> '<div class="ut-scroll-pane"><ul id="%1$s" class="%2$s">%3$s</ul></div>',
                    'theme_location'   	=> 'primary', 
                    'walker'           	=> new ut_menu_walker()
);

/* check if current page has an option tp show a hero */
$ut_activate_page_hero = get_post_meta( get_the_ID() , 'ut_activate_page_hero' , true );                    				

?>

<!-- header section -->
<header id="header-section" class="ha-header <?php echo $navigation_width; ?> <?php echo ( ot_get_option('ut_navigation_state' , 'off') == 'on_transparent' && ( is_home() || is_front_page() || is_singular('portfolio') || ( is_page() && $ut_activate_page_hero == 'on' ) ) ) ? 'ha-transparent' : $ut_navigation_skin; ?> <?php echo $headerstate; ?>">
    
    <?php if( $navigation_width == 'centered' ) :?>
    
    <div class="grid-container">
    
	<?php endif; ?>	
        
        <div class="ha-header-perspective">
        	<div class="ha-header-front">
            	
                <div class="grid-20 tablet-grid-50 mobile-grid-50 <?php echo $logo_push; ?>">
                
					<?php if ( get_theme_mod( 'ut_site_logo' ) ) : ?>
                        
                        <?php 
                        
                        $sitelogo = ( ( ( is_page() && ( $ut_activate_page_hero == 'off' || empty($ut_activate_page_hero) ) ) || is_single() ) && !is_singular('portfolio') && !is_front_page() && get_theme_mod( 'ut_site_logo_alt' ) ) ? get_theme_mod( 'ut_site_logo_alt' ) : get_theme_mod( 'ut_site_logo' );
                        $alternate_logo = get_theme_mod( 'ut_site_logo_alt' ) ? get_theme_mod( 'ut_site_logo_alt' ) : get_theme_mod( 'ut_site_logo' ) ;?>
                        
                        <div class="site-logo">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><img data-altlogo="<?php echo $alternate_logo; ?>" src="<?php echo $sitelogo; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"></a>
                        </div>
                        
                    <?php else : ?>
                    
                    	<div class="site-logo">
                        	<h1 class="logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                        </div>
                        
                    <?php endif; ?>             	
                
                </div>    
                
                <?php
                
                /* main and mobile menu cache */
                if( ot_get_option('ut_use_cache' , 'off') == 'on' ) {
                    
                    $main_menu      = get_transient('ut_main_menu' . get_the_ID() );
                    $mobile_menu    = get_transient('ut_mobile_menu' . get_the_ID() );
                    $cacheTime      = ot_get_option('ut_cache_ltime' , '10');
                    
                    if ($main_menu === false) {
                        
                        $main_menu = wp_nav_menu( $mainmenu );                        
                        set_transient('ut_main_menu' . get_the_ID() , $main_menu, 60*$cacheTime);
                        
                    } 
                    
                    if ($mobile_menu === false) {
                        
                        $mobile_menu = wp_nav_menu( $mobilemenu );
                        set_transient('ut_mobile_menu' . get_the_ID() , $mobile_menu, 60*$cacheTime);
                        
                    } 
                                       
                    
                } else {
                    
                    $main_menu   = wp_nav_menu( $mainmenu );
                    $mobile_menu = wp_nav_menu( $mobilemenu );
                    
                } ?>                
                
                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                			<?php do_action('mobile_icon_google_search'); ?>
					<?php echo $main_menu; ?>
                    
                    <div class="ut-mm-trigger tablet-grid-50 mobile-grid-50 hide-on-desktop">
                    	<button class="ut-mm-button"></button>
                    </div>
                    
					<?php echo $mobile_menu; ?>
                                        
                <?php endif; ?>
                                                        
                </div>
            </div><!-- close .ha-header-perspective -->
    
	<?php if( $navigation_width == 'centered') :?>        
	
    </div> 
    
    <?php endif; ?>
    

</header><!-- close header -->

<?php do_action('header_google_search'); ?>

<div class="clear"></div>

<?php get_template_part( 'template-part', 'hero' ); ?>       

<?php ut_before_content_hook(); // action hook, see inc/ut-theme-hooks.php ?>

<div id="main-content" class="wrap ha-waypoint" data-animate-up="ha-header-hide" data-animate-down="ha-header-small">
	
    <a class="ut-offset-anchor" id="to-main-content"></a>
		
        <div class="main-content-background">
            <?php do_action('load_facebook'); ?>
            <?php do_action('my_latest_post'); ?>
            <?php do_action('pop_modal_surveyform'); ?>
            <?php do_action('pop_modal_helpdesk'); ?>
            <?php do_action('scroll_up_button'); ?>
	    <?php do_action('mobile_google_search'); ?>
	    <?php echo do_shortcode("[icb_shortcode]"); ?>
