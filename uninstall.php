<?php

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

delete_option('ssg_title');
delete_option('ssg_width');
delete_option('ssg_height');
delete_option('ssg_pause');
delete_option('ssg_fadeduration');
delete_option('ssg_descreveal');
delete_option('ssg_cycles');
delete_option('ssg_random');
delete_option('ssg_type');
delete_option('ssg_descreveal1');
 
// for site options in Multisite
delete_site_option('ssg_title');
delete_site_option('ssg_width');
delete_site_option('ssg_height');
delete_site_option('ssg_pause');
delete_site_option('ssg_fadeduration');
delete_site_option('ssg_descreveal');
delete_site_option('ssg_cycles');
delete_site_option('ssg_random');
delete_site_option('ssg_type');
delete_site_option('ssg_descreveal1');

global $wpdb;
$wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}ssg_superb_gallery");