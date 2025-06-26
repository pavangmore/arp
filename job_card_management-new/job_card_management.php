<?php

// Enable error reporting (TEMPORARILY for debug)
error_reporting(E_ALL);
ini_set('display_errors', 1);



defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Job Card Management
Description: Manage job cards for a printing press with customer integration.
Version: 1.0.0
Requires at least: 2.3.*
*/

define('JOB_CARD_MODULE_NAME', 'job_card_management');

hooks()->add_action('admin_init', 'job_card_module_init_menu_items');
hooks()->add_action('admin_init', 'job_card_permissions');
hooks()->add_action('after_cron_run', 'job_card_cron_notifications');





/**
 * Register language files
 */
//register_language_files(JOB_CARD_MODULE_NAME, [JOB_CARD_MODULE_NAME]);

/**
 * Initialize job card module menu items
 */
function job_card_module_init_menu_items() {
    $CI = &get_instance();

    if (staff_can('view', 'job_card_management')) {
        $CI->app_menu->add_sidebar_menu_item('job_card_management', [
            'name'     => _l('Job Cards'),
            'href'     => admin_url('job_card_management'),
            'icon'     => 'fa fa-print',
            'position' => 5,
        ]);

        $CI->app_menu->add_sidebar_children_item('job_card_management', [
            'slug'     => 'create-job-card',
            'name'     => _l('Create Job Card'),
            'href'     => admin_url('job_card_management/create'),
            'position' => 1,
        ]);

      $CI->app_menu->add_sidebar_children_item('job_card_management', [
            'slug'     => 'list-job-cards',
            'name'     => _l('List Job Cards'),
            'href'     => admin_url('job_card_management'), // Points to index() method
            'position' => 2,
        ]);


    }
}

/**
 * Register job card permissions
 */
function job_card_permissions() {
    $capabilities = [
        'capabilities' => [
            'view'   => _l('permission_view'),
            'create' => _l('permission_create'),
            'edit'   => _l('permission_edit'),
            'delete' => _l('permission_delete'),
        ],
    ];
    register_staff_capabilities('job_card_management', $capabilities, _l('job_card_management'));
}

/**
 * Job card notification logic
 */
function job_card_cron_notifications() {
    // Add notification logic here if needed
}
