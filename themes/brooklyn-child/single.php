<?php
/**
 * The Template for displaying all single posts.
 *
 * @package unitedthemes
 */

get_header(); ?>

		<div class="grid-container">		
        	
            <?php $grid = is_active_sidebar('blog-widget-area') ? 'grid-75 tablet-grid-75 mobile-grid-100' : 'grid-100 tablet-grid-100 mobile-grid-100'; ?>
            
            <div id="primary" class="grid-parent <?php echo $grid; ?>">

       <div class="dropdown-wrapper mobile-grid-100">
        <select name="archive-dropdown" onchange="document.location.href=this.options[this.selectedIndex].value;">
            <option value=""><?php echo esc_attr( __( 'Select Month' ) ); ?></option> 
            <?php wp_get_archives( array( 'type' => 'monthly', 'format' => 'option', 'show_post_count' => 1 ) ); ?>
        </select>
	<?php do_action('show_cat_post'); ?>	
        </div>
    
            <?php while ( have_posts() ) : the_post(); ?>
                
                <?php get_template_part( 'partials/content', get_post_format() ); ?>
    
                <?php
                    // If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                        comments_template();
                ?>
    
            <?php endwhile; // end of the loop. ?>
            
            </div>
        
        	<?php get_sidebar(); ?>
            
		</div>
		
        <div class="ut-scroll-up-waypoint" data-section="section-<?php echo ut_clean_section_id($post->post_name); ?>"></div>
        
<?php get_footer(); ?>
