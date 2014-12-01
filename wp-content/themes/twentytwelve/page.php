<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header();
?>

<div id="primary" class="site-content">
    <div id="content" role="main">

        <?php /* while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', 'page' ); ?>
          <?php comments_template( '', true ); ?>
          <?php endwhile; // end of the loop. */ ?>

        <?php
        wp_reset_query();
        query_posts('page_id=19');
        the_post();
        ?> 

        <section id="home">
            <?php get_template_part('content', 'page'); ?>
        </section>


        <?php
        wp_reset_query();
        query_posts('page_id=7');
        the_post();
        ?> 

        <section id="about">
            <?php get_template_part('content', 'page'); ?>
        </section>


        <?php
        wp_reset_query();
        query_posts('page_id=9');
        the_post();
        ?> 

        <section id="gallery">
            <?php get_template_part('content', 'page'); ?>
        </section>
        
                <?php
        wp_reset_query();
        query_posts('page_id=11');
        the_post();
        ?> 

        <section id="contact_us">
            <?php get_template_part('content', 'page'); ?>
        </section>

    </div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>