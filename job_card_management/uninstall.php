<?php
defined('BASEPATH') or exit('No direct script access allowed');

register_uninstall_hook('job_card_management', function() {
    $CI = &get_instance();
    
    $CI->db->query("DROP TABLE IF EXISTS ".db_prefix()."job_cards");
    
    $CI->db->where('shortname', 'job_cards')
           ->delete(db_prefix().'permissions');
           
    $CI->db->where('shortname', 'view_job_cards')
           ->delete(db_prefix().'customer_permissions');
});


register_uninstall_hook('job_card_management', function() {
    $CI = &get_instance();
    $CI->app_menu->delete_sidebar_menu_item('job_card_management');
    $CI->app_menu->delete_setup_menu_item('job_card_settings');
});
