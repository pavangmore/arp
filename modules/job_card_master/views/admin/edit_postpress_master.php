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
        <label>Process</label>
        <input type='text' name='process_name' class='form-control' value="<?= $entry['process_name']; ?>" required>
    </div>
    
    <div class='form-group'>
        <label>Type</label>
        <input type='text' name='punching' class='form-control' value="<?= $entry['process_type']; ?>" required>
    </div>

       <div class='form-group'>
                            <label>Assign Name</label>
                            <select name='machine_name' class='form-control' required>
                                <option value=''>Select Machine</option>
                                <?php foreach ($machine_name_master as $machine_name_master) { ?>
                                    <option value='<?= $machine_name_master['machine_name_master']; ?>'><?= $machine_name_master['machine_name_master']; ?></option>
                                <?php } ?>
                            </select>
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
