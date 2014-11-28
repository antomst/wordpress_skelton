<?php

// Do not delete these lines
	if ( post_password_required() ) { ?>
		<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments.', 'mxs') ?></p>
	<?php
		return;
	}
	$oddcomment = 'alt';
	/* to split comment and pings */
	$trackpingCount = 0;
	$commentCount = 0;	
	if ($comments) :
		foreach ($comments as $comment) {
			$type = get_comment_type();
			switch( $type ) {
				case 'trackback' :
				case 'pingback' :
					$trackpingArray[$trackpingCount++] = $comment;
					break;
				default :
					$commentArray[$commentCount++] = $comment;
			}
		}
	endif;
?>

<!-- You can start editing here. -->

<?php if ( have_comments() ) : ?>
	<div id="comments">
				<h2 id="commentsx"><?php if ('open' == $post->comment_status) : _e('Comments', 'mxs'); else : _e('Comments (Close)','mxs'); endif; ?>:<?php echo $commentCount; ?></h2>
	</div>
	
	<div class="page_navi">
		<?php paginate_comments_links(); ?> 
	</div>
	
	<ol class="commentlist">
	<?php wp_list_comments('type=comment&callback=mxs_custom_comments'); ?>
	</ol>

 <?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
		<!-- If comments are open, but there are no comments. -->

	 <?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"><?php echo __('Comments are closed .', 'mxs'); ?></p>

	<?php endif; ?>
<?php endif; ?>

<?php comment_form(); ?>

<div class="clear"></div>
<?php if ($trackpingCount > 0 ) : //display trackback?>
			<div class="section" id="trackback">
				<?php wp_list_comments( array('type' => 'pings') ) ?>
			</div>
<?php endif; // end of trackback ?>
