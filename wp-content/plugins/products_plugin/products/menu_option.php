<?php

function recipes() {
    global $curr_page, $hidAction, $option, $wpdb;

    define('TBL', 'tbl_recipes');
    $entity = 'Recipes';
    $page_name = 'recipes';
    $folder_name = 'recipe';
    $primary_key = 'id';

    if (!is_dir(UPLOAD_PATH . $folder_name)) {
        @mkdir(UPLOAD_PATH . $folder_name, 0777);
        @mkdir(UPLOAD_PATH . $folder_name . '/thumb', 0777);
    }

    $_POST = stripslashes_deep($_POST);
    $_GET = stripslashes_deep($_GET);
    $_REQUEST = stripslashes_deep($_REQUEST);
    include(PLUGIN_PATH . 'recipes/manage_' . $page_name . '.php');
}

add_action('admin_print_scripts', 'recipes_call_scripts');
add_action('admin_print_styles', 'recipes_call_css');

function recipes_call_scripts() {
    wp_enqueue_script('custom_js', PLUGIN_URL . 'inc/js/custom.js');
    wp_enqueue_script('jquery_ui', PLUGIN_URL . 'inc/js/DataTables-1.9.4/media/js/jquery-ui-1.9.2.custom/js/jquery-ui-1.9.2.custom.js');
    wp_enqueue_script('jquery_datatables', PLUGIN_URL . 'inc/js/DataTables-1.9.4/media/js/jquery.dataTables.js');
    wp_enqueue_script('multiselect_js', PLUGIN_URL . 'inc/js/multiselect/jquery.multiselect.js');
    wp_enqueue_script('multiselect_filter_js', PLUGIN_URL . 'inc/js/multiselect/jquery.multiselect.filter.js');
    //wp_enqueue_script('tinymce_js', PLUGIN_URL . 'inc/js/tinymce.min.js');
}

function recipes_call_css() {
    wp_enqueue_style('css_datatables', PLUGIN_URL . 'inc/js/DataTables-1.9.4/media/js/jquery-ui-1.9.2.custom/css/smoothness/jquery-ui-1.9.2.custom.css');
    wp_enqueue_style('css_custom_datatables', PLUGIN_URL . 'inc/css/datatables_custom.css');
    wp_enqueue_style('css_multiselect', PLUGIN_URL . 'inc/css/multiselect/jquery.multiselect.css');
    wp_enqueue_style('css_multiselect_filter', PLUGIN_URL . 'inc/css/multiselect/jquery.multiselect.filter.css');
}

?>
