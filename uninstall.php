<?php
/**
 * Uninstall script for Under Construction plugin
 * 
 * This file is executed when the plugin is uninstalled via WordPress admin
 */

// If uninstall is not called from WordPress, exit
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Delete plugin options
delete_option('uc_enabled');
delete_option('uc_mode');
delete_option('uc_html_content');
delete_option('uc_page_id');
