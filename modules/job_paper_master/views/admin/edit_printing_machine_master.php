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
                            <label>Machine Name</label>
                            <input type='text' name='size' class='form-control' value="<?= $entry['machine_name']; ?>" required>
                        </div>
                        <!--<div class='form-group'>-->
                        <!--    <label>Plate Size</label>-->
                        <!--    <input type='text' name='type' class='form-control' value="<?= $entry['plate_size']; ?>" required>-->
                        <!--</div>-->
                            <div class='form-group'>
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
                            <input type='text' name='color' class='form-control' value="<?= $entry['color']; ?>"  required>
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
