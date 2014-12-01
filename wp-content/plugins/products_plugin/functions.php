<?php

//This is a general ajax page of wordpress
if (isset($_REQUEST['page'])) {
    switch ($_REQUEST['page']) {
        case 'ingredients':
            include(PLUGIN_PATH . 'ingredients/ajax_ingredients.php');
            break;
        case 'ingredients_categories':
            include(PLUGIN_PATH . 'ingredients_categories/ajax_ingredients_categories.php');
            break;
        case 'recipes':
            include(PLUGIN_PATH . 'recipes/ajax_recipes.php');
            break;
        case 'recipes_types':
            include(PLUGIN_PATH . 'recipes_types/ajax_recipes_types.php');
            break;
        case 'recipes_categories':
            include(PLUGIN_PATH . 'recipes_categories/ajax_recipes_categories.php');
            break;
        case 'recipes_comments':
            include(PLUGIN_PATH . 'recipes_comments/ajax_recipes_comments.php');
            break;
        case 'testimonials':
            include(PLUGIN_PATH . 'testimonials/ajax_testimonials.php');
            break;
        case 'recipes_day':
            include(PLUGIN_PATH . 'recipes_day/ajax_recipes_day.php');
            break;
    }
}

function fn_ajax_shortcodes() {//for displaying in the frontend
    global $wpdb;
    //$query = $wpdb->prepare("SELECT * FROM `tbl_testimonials` ORDER BY id desc LIMIT 5");
    $query = "SELECT * FROM `tbl_testimonials` ORDER BY created_on desc ";
    //$query = $wpdb->prepare( "SELECT * FROM `tbl_testimonials` WHERE id = %d ORDER BY id desc LIMIT 5", $id );
    $result = $wpdb->get_results($query);
    $faqstring = "";
    $si = 1;
    while (isset($result[$si - 1])) {
        $row = $result[$si - 1];
        $id = $row->id;
        $name = $row->contact_name;
        $website = $row->website;
        $testimony = $row->testimony;

        if (!empty($website)) {
            $faqstring .= "<div style=cursor:pointer;height:40px;width:700px;>" . "<b><h4>" . $name . "</h4></b>" . "</div>
			<div style='margin-left:25px;'" . $si . "'><b>Testimony:&nbsp;</b>" . nl2br($testimony) . '<br>' .
                    "<b>Website:&nbsp;</b>" . $website . "</div>";
            $si++;
        } else {
            $faqstring .= "<div style=cursor:pointer;height:40px;width:700px;>" . "<b><h4>" . $name . "</h4></b>" . "</div>
			<div style='margin-left:25px;'" . $si . "'><b>Testimony:&nbsp;</b>" . nl2br($testimony) . "</div>";
            $si++;
        }
    }

    return $faqstring;
}

add_shortcode('TESTIMONIALS', 'fn_ajax_shortcodes');


function my_plugin_install() {

    global $wpdb;

    $the_page_title = 'Testimonials';
    $the_page_name = 'Testimonials';

    // the menu entry...
    delete_option("my_plugin_page_title");
    add_option("my_plugin_page_title", $the_page_title, '', 'yes');
    // the slug...
    delete_option("my_plugin_page_name");
    add_option("my_plugin_page_name", $the_page_name, '', 'yes');
    // the id...
    delete_option("my_plugin_page_id");
    add_option("my_plugin_page_id", '0', '', 'yes');

    $the_page = get_page_by_title( $the_page_title );

    if ( ! $the_page ) {

        // Create post object
        $_p = array();
        $_p['post_title'] = $the_page_title;
        $_p['post_content'] = "[TESTIMONIALS]";
        $_p['post_status'] = 'publish';
        $_p['post_type'] = 'page';
        $_p['comment_status'] = 'closed';
        $_p['ping_status'] = 'closed';
        $_p['post_category'] = array(1); // the default 'Uncategorised'

        $the_page_id = wp_insert_post( $_p );

    }
    else {
        // the plugin may have been previously active and the page may just be trashed...
        $the_page_id = $the_page->ID;

        $the_page->post_status = 'publish';
        $the_page_id = wp_update_post( $the_page );
    }

    delete_option( 'my_plugin_page_id' );
    add_option( 'my_plugin_page_id', $the_page_id );


}

function my_plugin_remove() {

    global $wpdb;

    $the_page_title = get_option( "my_plugin_page_title" );
    $the_page_name = get_option( "my_plugin_page_name" );

    //  the id of our page...
    $the_page_id = get_option( 'my_plugin_page_id' );
    if( $the_page_id ) {

        wp_delete_post( $the_page_id ); // this will trash, not delete

    }

    delete_option("my_plugin_page_title");
    delete_option("my_plugin_page_name");
    delete_option("my_plugin_page_id");

    //$table = $wpdb->prefix."tbl_testimonials";
    //$table ="tbl_recipes";
    //$wpdb->query("DROP TABLE IF EXISTS $table");
   
    
	/*DROP TABLE IF EXISTS tbl_ingredient_categories;
	DROP TABLE IF EXISTS tbl_ingredients;
	DROP TABLE IF EXISTS tbl_recipe_types;
	DROP TABLE IF EXISTS tbl_recipe_categories;
	DROP TABLE IF EXISTS tbl_recipes;
	DROP TABLE IF EXISTS tbl_recipe_day;
	DROP TABLE IF EXISTS tbl_recipe_comments;
	DROP TABLE IF EXISTS tbl_testimonials;*/
}



