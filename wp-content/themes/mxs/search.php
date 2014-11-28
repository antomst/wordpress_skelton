<?php get_header(); ?>
	<div id="main">
	<div class="section entry">
	<h1 class="entry-title"><?php printf( __( ' Search Results %s', 'mxs' ), '<span>'.the_search_query().'</span>' ); ?></h1>
		<?php if(have_posts()) : ?>
		<?php while(have_posts()) : the_post(); ?>
		<div class="post">
			<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2>
			<div class="entry">
					<?php the_excerpt(); ?>
			</div>
				<?php wp_link_pages(); ?>
		</div>
			<?php endwhile; ?>
	<?php else : ?>
		<h3><?php _e('No posts found. Try a different search?', 'mxs'); ?></h3>
		<?php get_search_form(); ?>
		<?php endif; ?>
	</div><!-- section entry -->
	<?php if (  $wp_query->max_num_pages > 1 ) : ?>
			<div class="page_navi">
			<?php if(function_exists('mxs_pagenavi')) {  mxs_pagenavi(5); } else{ ?>
				<?php next_posts_link(); ?>
				<?php previous_posts_link(); }?>
			</div>
	<?php endif;  ?><!-- page navi -->
	</div><!-- main -->
	<?php	get_sidebar(); ?>
	<?php	get_footer(); ?>