<?php

if (!is_admin()) {

}

if (function_exists('register_nav_menus')) {
    register_nav_menus(
            array(
                'main_nav' => 'Main Navigation Menu'
            )
    );
}

function add_nav_class($output) {
    $output = preg_replace('/<a/', '<a class="scroll"', $output, -1);
    return $output;
}

add_filter('wp_nav_menu', 'add_nav_class');
?>