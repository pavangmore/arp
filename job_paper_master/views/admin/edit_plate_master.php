<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id='wrapper'>
    <div class='content'>
        <div class='row'>
            <div class='col-md-6'>
                <div class='panel_s'>
                    <div class='panel-heading'>
                        <h4><?= _l('Edit ' . ucfirst($type) . ' Master Entry'); ?></h4>
                    </div>
                    <div class='panel-body'>
                        <?= form_open(admin_url("job_card_master/edit/{$type}/{$entry['id']}")); ?>
                        <div class='form-group'>
                            <label>Plate Size</label>
                            <input type='text' name='plate_size' class='form-control' value="<?= $entry['plate_size']; ?>" required>
                        </div>
                        <div class='form-group'>
                            <label>Plate Type</label>
                            <input type='text' name='plate_type' class='form-control' value="<?= $entry['plate_type']; ?>" required>
                        </div>
                         <div class='form-group'>
                            <label>GSM</label>
                            <input type='text' name='gsm' class='form-control' value="<?= $entry['gsm']; ?>" required>
                        </div>
                        <div class='form-group'>
                            <label>Purchase Rate</label>
                            <input type='number' name='purchase_rate' class='form-control' value="<?= $entry['purchase_rate']; ?>" step='0.01' required>
                        </div>
                          <div class='form-group'>
                            <label>Sales Rate</label>
                            <input type='number' name='sales_rate' class='form-control' value="<?= $entry['sales_rate']; ?>" step='0.01' required>
                        </div>
                        <button type='submit' class='btn btn-primary'>Update</button>
                        <?= form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
