<?php
defined('BASEPATH') or exit('No direct script access allowed');

$CI = &get_instance();
$CI->load->model('job_card_model');

$total = $CI->job_card_model->count_all();
$pending = $CI->job_card_model->count_by_status('Pending');
$in_progress = $CI->job_card_model->count_by_status('In Progress');
$completed = $CI->job_card_model->count_by_status('Completed');
?>

<div class="widget-panel widget-style-2">
    <div class="text-center">
        <h4 class="mb-0"><?= _l('Total Job Cards'); ?>: <?= $total; ?></h4>
        <hr>
        <p>Pending: <?= $pending; ?> | In Progress: <?= $in_progress; ?> | Completed: <?= $completed; ?></p>
    </div>
</div>
