<?php
/*
  Plugin Name: Economics
  Description: Economics of Eating
  Version: 1.0
  Author: Jolly
  Author URI: http://www.jolly.com
 */

global $wpdb;
define("PLUGIN_PATH", ABSPATH . 'wp-content/plugins/economics/');
define("PLUGIN_URL", get_option('siteurl') . '/wp-content/plugins/economics/');
define("UPLOAD_PATH", ABSPATH . 'wp-content/plugins/economics/uploads/');
define("UPLOAD_URL", get_option('siteurl') . '/wp-content/plugins/economics/uploads/');

$wpdb->show_errors();

//menu items
add_action('admin_menu', 'economics_menu');

function economics_menu() {

    add_menu_page('Economics', 'Economics', 'manage_options', 'site_menu', 'site_menu');
// 
    include('db.php');

    if (file_exists(PLUGIN_PATH . 'ingredients_categories/menu_option.php')) {
        add_submenu_page('site_menu', 'Ingredients Categories', 'Ingredients Categories', 'manage_options', 'ingredients_categories', 'ingredients_categories');
        include(PLUGIN_PATH . 'ingredients_categories/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'ingredients/menu_option.php')) {
        add_submenu_page('site_menu', 'Ingredients', 'Ingredients', 'manage_options', 'ingredients', 'ingredients');
        include(PLUGIN_PATH . 'ingredients/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'recipes_types/menu_option.php')) {
        add_submenu_page('site_menu', 'Recipes Types', 'Recipes Types', 'manage_options', 'recipes_types', 'recipes_types');
        include(PLUGIN_PATH . 'recipes_types/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'recipes_categories/menu_option.php')) {
        add_submenu_page('site_menu', 'Recipes Categories', 'Recipes Categories', 'manage_options', 'recipes_categories', 'recipes_categories');
        include(PLUGIN_PATH . 'recipes_categories/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'recipes/menu_option.php')) {
        add_submenu_page('site_menu', 'Recipes', 'Recipes', 'manage_options', 'recipes', 'recipes');
        include(PLUGIN_PATH . 'recipes/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'recipes_comments/menu_option.php')) {
        add_submenu_page('site_menu', 'Recipes Comments', 'Recipes Comments', 'manage_options', 'recipes_comments', 'recipes_comments');
        include(PLUGIN_PATH . 'recipes_comments/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'recipes_day/menu_option.php')) {
        add_submenu_page('site_menu', 'Recipe Of The Day', 'Recipe of the Day', 'manage_options', 'recipes_day', 'recipes_day');
        include(PLUGIN_PATH . 'recipes_day/menu_option.php');
    }
    if (file_exists(PLUGIN_PATH . 'testimonials/menu_option.php')) {
        add_submenu_page('site_menu', 'Testimonials', 'Testimonials', 'manage_options', 'testimonials', 'testimonials');
        include(PLUGIN_PATH . 'testimonials/menu_option.php');
    }
}

function site_menu() {
    //wp_redirect("admin.php?page=category");
    
    echo "<br /><center><b></b></center>";
    $ic = 'ingredients_categories';
    $i = 'ingredients';
    $rt = 'recipes_types';
    $rc = 'recipes_categories';
    $recipes = 'recipes';
    $recipescomments = 'recipes_comments';
    $rod = 'recipes_day';
    $testimonials = 'testimonials'
    ?>
    <html>
        <body>
            <style type="text/css">

                td {
                    margin: 5px;
                    padding: 10px;
                    border: 0px solid #808080;
                    text-align: left;

                }
                .heading{

                    font-size: 24px;
                }

                .button_example{
                    width:220px;
                    border:1px solid #b7b7b7; -webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:20px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #FFFFFF;
                    background-color: #d3d3d3; background-image: -webkit-gradient(linear, left top, left bottom, from(#d3d3d3), to(#707070));
                    background-image: -webkit-linear-gradient(top, #d3d3d3, #707070);
                    background-image: -moz-linear-gradient(top, #d3d3d3, #707070);
                    background-image: -ms-linear-gradient(top, #d3d3d3, #707070);
                    background-image: -o-linear-gradient(top, #d3d3d3, #707070);
                    background-image: linear-gradient(to bottom, #d3d3d3, #707070);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#d3d3d3, endColorstr=#707070);
                }

                .button_example:hover{
                    border:1px solid #a0a0a0;webkit-border-radius: 3px; -moz-border-radius: 3px;border-radius: 3px;font-size:20px;font-family:arial, helvetica, sans-serif; padding: 10px 10px 10px 10px; text-decoration:none; display:inline-block;text-shadow: -1px -1px 0 rgba(0,0,0,0.3);font-weight:bold; color: #cdcdcd;
                    background-color: #bababa; background-image: -webkit-gradient(linear, left top, left bottom, from(#bababa), to(#575757));
                    background-image: -webkit-linear-gradient(top, #bababa, #575757);
                    background-image: -moz-linear-gradient(top, #bababa, #575757);
                    background-image: -ms-linear-gradient(top, #bababa, #575757);
                    background-image: -o-linear-gradient(top, #bababa, #575757);
                    background-image: linear-gradient(to bottom, #bababa, #575757);filter:progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr=#bababa, endColorstr=#575757);
                }


            </style>
            <br/>
            <br/>
            <br/>
            <div class="heading">
                <b><center>
                        <h>   Welcome to the Economics of Eating Managing Section</h></center>
                </b>
            </div>
            <br/>
            <br/>
            <table align="center" cellspacing='6' cellpadding="8" >

                <tr><td><a class="button_example" href="admin.php?page=<?php echo $ic ?>">Ingredients Categories</a></td>
                    <td><a class="button_example" href="admin.php?page=<?php echo $i ?>">Ingredients</a></td></tr>
                <tr><td><a class="button_example" href="admin.php?page=<?php echo $rt ?>">Recipes Types</a></td>
                    <td><a class="button_example" href="admin.php?page=<?php echo $rc ?>">Recipes Categories</a></td></tr>
                <tr><td><a class="button_example" href="admin.php?page=<?php echo $recipes ?>">Recipes</butto</a>
                    <td><a class="button_example" href="admin.php?page=<?php echo $recipescomments ?>">Recipes Comments</a></td></tr>
                <tr><td><a class="button_example" href="admin.php?page=<?php echo $rod ?>">Recipe of The Day</a></td>
                    <td><a class="button_example" href="admin.php?page=<?php echo $testimonials ?>">Testimonials</a> </td></tr>
            </table>
        </body>
    </html>
    <?php
}

include('functions.php');
register_activation_hook(__FILE__, 'my_plugin_install');
register_deactivation_hook(__FILE__, 'my_plugin_remove');
