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
                            <label>Paper Type</label>
                            <input type='text' name='paper_type' class='form-control' value="<?= $entry['paper_type']; ?>" step='0.01' required>
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
