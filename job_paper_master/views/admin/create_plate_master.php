<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id='wrapper'>
    <div class='content'>
        <div class='row'>
            <div class='col-md-6'>
                <div class='panel_s'>
                    <div class='panel-heading'>
                        <h4><?= _l('Add ' . ucwords(str_replace('_', ' ', 'plate')) . ' Master Entry'); ?></h4>
                    </div>
                    <div class='panel-body'>
                       <?= form_open(admin_url('job_card_master/add/plate')); ?>
    <div class='form-group'>
        <label>Plate Size</label>
        <input type='text' name='plate_size' class='form-control' required>
    </div>
    <div class='form-group'>
        <label>Plate type</label>
        <input type='text' name='type' class='form-control' required>
    </div>
      <div class='form-group'>
        <label>Gsm</label>
        <input type='text' name='gsm' class='form-control' required>
    </div>
    <div class='form-group'>
        <label>Purchase Rate</label>
        <input type='number' name='purchase_rate' class='form-control' step='0.01' required>
    </div>
      <div class='form-group'>
        <label>Sales Rate</label>
        <input type='number' name='sales_rate' class='form-control' step='0.01' required>
    </div>
    <button type='submit' class='btn btn-primary'>Save</button>
<?= form_close(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>