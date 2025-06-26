<?php

defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Paper Master
Description: Manage job card master entries dynamically for Plates, Paper, Printing Machine, Postpress Machine, and Postpress.
Version: 1.2.0
Requires at least: 2.3.*
*/

define('JOB_PAPER_MASTER_MODULE_NAME', 'job_paper_master');

hooks()->add_action('admin_init', 'job_paper_master_init_menu_items');

function job_paper_master_init_menu_items() {
    $CI = &get_instance();
    
    $CI->app_menu->add_sidebar_menu_item('job_paper_master', [
        'name'     => _l('Paper Master'),
        'href'     => admin_url('job_paper_master'),
        'icon'     => 'fa fa-database',
        'position' => 6,
    ]);
    
    $master_entries = ['paper', 'paper_gsm','paper_size','paper_type'];
    foreach ($master_entries as $entry) {
        $CI->app_menu->add_sidebar_children_item('job_paper_master', [
            'slug'     => "job_paper_master_{$entry}",
            'name'     => _l(ucwords(str_replace('_', ' ', $entry)) . ' Master'),
            'href'     => admin_url("job_paper_master/manage/{$entry}"),
            'position' => 6,
        ]);
    }
}



