<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Register widgets for the dashboard.
 */
hooks()->add_action('admin_init', 'job_card_register_widgets');

function job_card_register_widgets()
{
    add_dashboard_widget('widget_total_jobcards', 'Total Job Cards', 'widget_total_jobcards_output');
    add_dashboard_widget('widget_pending_jobcards', 'Pending Job Cards', 'widget_pending_jobcards_output');
    add_dashboard_widget('widget_progress_jobcards', 'Job Cards In Progress', 'widget_progress_jobcards_output');
    add_dashboard_widget('widget_completed_jobcards', 'Completed Job Cards', 'widget_completed_jobcards_output');
}

/**
 * Widget: Total Job Cards
 */
function widget_total_jobcards_output($widget_id)
{
    $CI =& get_instance();
    $CI->load->model('job_card_model');
    $total = $CI->job_card_model->count_all();
    echo '<div class="panel_s"><div class="panel-body text-center">';
    echo '<h3 class="bold">' . $total . '</h3>';
    echo '<span>Total Job Cards</span>';
    echo '</div></div>';
}

/**
 * Widget: Pending Job Cards
 */
function widget_pending_jobcards_output($widget_id)
{
    $CI =& get_instance();
    $CI->load->model('job_card_model');
    $pending = $CI->job_card_model->count_by_status('Pending');
    echo '<div class="panel_s"><div class="panel-body text-center">';
    echo '<h3 class="bold text-warning">' . $pending . '</h3>';
    echo '<span>Pending</span>';
    echo '</div></div>';
}

/**
 * Widget: In Progress Job Cards
 */
function widget_progress_jobcards_output($widget_id)
{
    $CI =& get_instance();
    $CI->load->model('job_card_model');
    $progress = $CI->job_card_model->count_by_status('In Progress');
    echo '<div class="panel_s"><div class="panel-body text-center">';
    echo '<h3 class="bold text-info">' . $progress . '</h3>';
    echo '<span>In Progress</span>';
    echo '</div></div>';
}

/**
 * Widget: Completed Job Cards
 */
function widget_completed_jobcards_output($widget_id)
{
    $CI =& get_instance();
    $CI->load->model('job_card_model');
    $complete = $CI->job_card_model->count_by_status('Completed');
    echo '<div class="panel_s"><div class="panel-body text-center">';
    echo '<h3 class="bold text-success">' . $complete . '</h3>';
    echo '<span>Completed</span>';
    echo '</div></div>';
}
