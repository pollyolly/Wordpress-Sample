<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package unitedthemes
 */

get_header(); 

$header_style = ot_get_option('ut_global_headline_style'); ?>
    <div class="grid-container">
        <div id="primary" class="grid-parent grid-100 tablet-grid-100 mobile-grid-100">
        	<div class="grid-70 prefix-15 mobile-grid-100 tablet-grid-100">
			<h2 style="font-weight: 700; font-size: 40px;">Oops! That page can&rsquo;t be found.</h2>
			<p>It looks like nothing was found at this location. Maybe search the page using "Google Custom Search" below.</p>
            <?php get_search_form(); ?>
            </div><!-- .page-header -->
		</div><!-- .grid-100 mobile-grid-100 tablet-grid-100 -->
	</div><!-- .grid-container -->
<?php get_footer(); ?>
