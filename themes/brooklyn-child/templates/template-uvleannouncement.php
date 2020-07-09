<?php
/**

 * Template Name: Static Uvle Announcement

 * by ilc.upd.edu.ph

 */
 ?>
<style>
h2 ,a ,p{font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;}
h2{font-weight:500;margin-top:20px;margin-bottom:10px;font-size:24px;color:#566473;}
a{text-decoration:none;}
p{color: #566473;font-size: 14px;}
h2 a{font-size: 18px;color: #566473;}
</style>
	<div id="content">
	<h2>Announcement</h2>
		<div class="uvle-announcement">
			<?php query_posts('category_name=uvle&post_type=post&post_status=publish&posts_per_page=3&paged='. get_query_var('paged')); ?>
			<?php if( have_posts() ): ?>
			<?php while( have_posts() ): the_post(); ?>
			<div id="post-<?php get_the_ID(); ?>" <?php post_class(); ?>>
				<h2><a href="<?php the_permalink(); ?>" target="_blank"><?php the_title(); ?></a></h2>
				<?php the_excerpt(__('Continue reading »','example')); ?>
			</div><!-- /#post-<?php get_the_ID(); ?> -->
			<?php endwhile; ?>
			<?php else: ?>
				<div id="post-404" class="noposts">
				<p><?php _e('None found.','example'); ?></p>
			</div><!-- /#post-404 -->
			<?php endif; wp_reset_query(); ?>
		</div>
	</div><!-- /#content -->
