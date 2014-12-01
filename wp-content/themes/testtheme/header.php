<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <meta name="viewport" content="width=device-width">
        <title><?php wp_title('|', true, 'right'); ?></title>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
        <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css"  />
        <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/bootstrap.min">
        <!--[if lt IE 9]>
        <script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
        <![endif]-->
        <?php wp_head(); ?>
      <script src = "<?php bloginfo('template_url'); ?>/js/move-top.js" ></script>
        <script src = "<?php bloginfo('template_url'); ?>/js/widgetcorp.js" ></script>
        
        <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    </head>
    <body >
        <header>
            <div id="navmenu">
                <nav >                   
                    <?php wp_nav_menu(array('menu' => 'Main Nav Menu')); ?>
                </nav>
            </div>
<?php
    wp_reset_query();
    query_posts('page_id=19');
    the_post();
            the_content();
            ?>

        </header>
