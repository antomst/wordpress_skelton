<?php get_header(); ?>
	<div id="main">
		<p class="topicPath">
			<a href="<?php echo home_url(); ?>"><?php __( 'Home', 'mxs' ); ?></a>&gt; <?php echo 'Tags'; ?> &gt; <span class="current"><?php single_tag_title(); ?></span>
		</p>
		<h1 class="entry-title">Post about "<?php single_cat_title(); ?>"</h1>
		<div class="section entry" id="entry<?php the_ID(); ?>">
			<?php if(have_posts()) : ?><?php while(have_posts()) : the_post(); ?>
			<div class="post">	
				<h2 class="entry-title"><a href="<?php the_permalink() ?>"><?php the_title_attribute(); ?></a></h2>
				<p class="info">
					<span class="dateinfo"><a href="<?php the_permalink() ?>"><?php the_time( get_option( 'date_format' )); ?></a></span>
					<span class="catinfo"><?php echo __('Category :', 'MxS'); the_category('| ') ?><?php edit_post_link(__(' Edit', 'mxs'), ' &#124; ', ''); ?></span>
					<span class="cmtinfo"><?php comments_popup_link('0', '1', '%','',__('Off', 'mxs')); ?></span>
				</p>
				<div class="entry">
					<?php $mxs_options = get_option('mxs_theme_options'); ?>
					<?php if ( $mxs_options['arch_excerpt_check']== 1 ) { the_excerpt(); } else {the_content(__('&raquo; Continue Reading','mxs'));} ?>
				</div>
					<div class="clear"></div>
				<p class="infobottom">
					<span class="count"><?php if(function_exists('the_views')) { the_views(); } ?></span>
					<span class="tags"><?php if (has_tag()) :  the_tags(' '); endif; ?></span>
				</p>
			</div>
			<?php endwhile; ?><?php else : ?>
			<div id="main">
				<h2><?php _e('Not Found', 'mxs'); ?></h2>
			</div>
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