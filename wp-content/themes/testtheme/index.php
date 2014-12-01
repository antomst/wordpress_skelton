<?php
get_header();
?>

<div class="content">


    <h1>
        CONTENT
    </h1>
    <?php
    wp_reset_query();
    query_posts('page_id=5');
    the_post();
    ?>   
    <section id="<?php the_title(); ?>">
        <h1><?php the_title(); ?></h1>
        <p ><?php
            the_content();
            ?></p> 
    </section>

    <?php
    wp_reset_query();
    query_posts('page_id=7');
    the_post();
    ?>   
    <section id="<?php the_title(); ?>">
        <h1><?php the_title(); ?></h1>
        <p ><?php
            the_content();
            ?></p> 
    </section>

    <section id="blog">

        <h2>BLOG</h2>

        <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum, elit eget tincidunt condimentum, eros ipsum rutrum orci, sagittis tempus lacus enim ac dui. Donec non enim in turpis pulvinar facilisis. Ut felis. Praesent dapibus, neque id cursus faucibus, tortor neque egestas augue, eu vulputate magna eros eu erat. Aliquam erat volutpat. Nam dui mi, tincidunt quis, accumsan porttitor, facilisis luctus, metus</p>

    </section>

    <?php
    wp_reset_query();
    query_posts('page_id=11');
    the_post();
    ?> 
    <section id="contact_us">

        <h1><?php the_title(); ?></h1>
        <?php
        the_content();

        ?>
    </section>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
