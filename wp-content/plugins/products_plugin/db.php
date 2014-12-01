<?php

global $wpdb;

$table_name1 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_ingredient_categories'", ''));
if ($table_name1 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_ingredient_categories` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `category` varchar(20) NOT NULL,
				  PRIMARY KEY (`id`)
				) 
			";
    $wpdb->query($sql);
}

$table_name = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_ingredients'", ''));
if ($table_name == '') {

    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_ingredients` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `ingredient_type` int(11) NOT NULL,
				  `ingredient` varchar(50) NOT NULL,
				  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
				  PRIMARY KEY (`id`),
                                  FOREIGN KEY (`ingredient_type`) REFERENCES  tbl_ingredient_categories(`id`)
                                 ON UPDATE RESTRICT ON DELETE RESTRICT
				) 
			";
    $wpdb->query($sql);
}

$table_name4 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_recipe_types'", ''));
if ($table_name4 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_recipe_types` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `category_type` varchar(20) NOT NULL,
				  PRIMARY KEY (`id`)
				) 
			";
    $wpdb->query($sql);
}
$table_name3 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_recipe_categories'", ''));
if ($table_name3 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_recipe_categories` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `category_type` int(11),
				  `category` varchar(20) NOT NULL,
                                  `category_image` varchar(255),
                                  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
				  PRIMARY KEY (`id`),
                                  FOREIGN KEY (`category_type`) REFERENCES  tbl_recipe_types(`id`)
                                 ON UPDATE RESTRICT ON DELETE RESTRICT
				
				) 
			";
    $wpdb->query($sql);
}

$table_name2 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_recipes'", ''));
if ($table_name2 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_recipes` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `title` varchar(100) NOT NULL,
                                  `recipe_category` varchar(100) NOT NULL,
                                  `recipe_image` varchar(255) NOT NULL,
                                  `thumb_image` varchar(255) NOT NULL,
                                  `ingredients` varchar(100) NOT NULL,
                                  `quantity` varchar(200) NOT NULL,
                                  `other_recipes` varchar(100) NOT NULL,
                                  `related_recipes` varchar(100) NOT NULL,
				  `directions` text NOT NULL,
				  `status` enum('Y','N') NOT NULL DEFAULT 'Y',
                                  `created_on` timestamp ,
                                  `updated_on` timestamp ,
				  PRIMARY KEY (`id`)
                                  ON UPDATE RESTRICT ON DELETE RESTRICT
				) 
			";
    $wpdb->query($sql);
}





$table_name5 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_recipe_day'", ''));
if ($table_name5 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_recipe_day` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `recipe_id` int(11) NOT NULL,
                                  `display_date` date ,
				  PRIMARY KEY (`id`),
                                  FOREIGN KEY (`recipe_id`) REFERENCES  tbl_recipes(`id`)
                                 ON UPDATE RESTRICT ON DELETE RESTRICT
				) 
			";
    $wpdb->query($sql);
}

$table_name6 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_recipe_comments'", ''));
if ($table_name6 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_recipe_comments` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
				  `recipe_id` int(11) NOT NULL,
                                  `comment` text NOT NULL,
                                  `user_identification` varchar(150) NOT NULL,
                                  `username` varchar(150) NOT NULL,
                                  `create_on` timestamp ,
				  `status` enum('Y','N','P') NOT NULL DEFAULT 'P',
                                    PRIMARY KEY (`id`),
                                    FOREIGN KEY (`recipe_id`) REFERENCES  tbl_recipes(`id`)
                                 ON UPDATE RESTRICT ON DELETE RESTRICT
				
				) 
			";
    $wpdb->query($sql);
}

$table_name7 = $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE 'tbl_testimonials'", ''));
if ($table_name7 == '') {
    $sql = "
				CREATE TABLE IF NOT EXISTS `tbl_testimonials` (
				  `id` int(11) NOT NULL AUTO_INCREMENT,
                                  `contact_name` varchar(50) NOT NULL,
                                  `contact_email` varchar(250) NOT NULL,
				  `contact_mobile` varchar(20) NOT NULL,
                                  `website` varchar(100) NOT NULL,
                                  `testimony` text NOT NULL,
                                  `status` enum('Y','N','P') NOT NULL DEFAULT 'P',
                                  `created_on` timestamp ,
				  PRIMARY KEY (`id`)
				) 
			";
    $wpdb->query($sql);
}
?>
