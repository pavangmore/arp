



<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id='wrapper'>
    <div class='content'>
        <div class='row'>
            <div class='col-md-6'>
                <div class='panel_s'>
                    <div class='panel-heading'>
                        <h4><?= _l('Add ' . ucwords(str_replace('_', ' ', 'printing_machine')) . ' Master Entry'); ?></h4>
                    </div>
                    <div class='panel-body'>
                       <?= form_open(admin_url('job_card_master/add/printing_machine')); ?>
    <div class='form-group'>
        <label>Machine Name</label>
        <input type='text' name='machine_name' class='form-control' required>
    </div>
    <div>
     <label>Plate Size</label>
                            <select name='plate_size' class='form-control' required>
                                <option value=''>Select Plate Size</option>
                                <?php foreach ($plate_size as $plate_size) { ?>
                                    <option value='<?= $plate_size['plate_size']; ?>'><?= $plate_size['plate_size']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
    <div class='form-group'>
        <label>Color</label>
        <input type='text' name='color' class='form-control' required>
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