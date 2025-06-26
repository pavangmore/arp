<?php

defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();
hooks()->add_action('admin_init', 'job_card_permissions');
hooks()->add_action('admin_init', 'job_card_menu');

function job_card_permissions() {
    $capabilities = [
        'capabilities' => [
            'view' => 'View Job Cards',
            'edit' => 'Edit Job Cards',
            'delete' => 'Delete Job Cards',
            'export' => 'Export Job Cards',
        ],
    ];
    register_staff_capabilities('job_card_management', $capabilities, _l('Job Card Management'));
}

function job_card_menu() {
    $CI = &get_instance();
    if (has_permission('job_card_management', '', 'view')) {
        $CI->app_menu->add_sidebar_menu_item('job_card_management', [
            'name'     => 'Job Card Management',
            'href'     => admin_url('job_card_management'),
            'icon'     => 'fa fa-print',
            'position' => 6,
        ]);
    }
}
