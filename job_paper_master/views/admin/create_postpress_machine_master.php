
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id='wrapper'>
    <div class='content'>
        <div class='row'>
            <div class='col-md-6'>
                <div class='panel_s'>
                    <div class='panel-heading'>
                        <h4><?= _l('Add ' . ucwords(str_replace('_', ' ', 'postpress_machine')) . ' Master Entry'); ?></h4>
                    </div>
                    <div class='panel-body'>
                       <?= form_open(admin_url('job_card_master/add/postpress_machine')); ?>
 
    <div class='form-group'>
        <label>Machine Name</label>
        <input type='text' name='machine_name' class='form-control' required>
    </div> 
    
       <div class='form-group'>
                            <label>Machine Name</label>
                            <select name='machine_name' class='form-control' required>
                                <option value=''>Select Machine</option>
                                <?php foreach ($machine_name as $machine_name) { ?>
                                    <option value='<?= $machine_name['machine_name']; ?>'><?= $machine_name['machine_name']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
    
    
      <div class='form-group'>
        <label>Process</label>
        <input type='text' name='process' class='form-control' step='0.01' required>
    </div>
    <!--<div class='form-group'>-->
    <!--    <label>Type</label>-->
    <!--    <input type='text' name='type' class='form-control' required>-->
    <!--</div>-->
  
       <div class='form-group'>
        <label>Size</label>
        <input type='number' name='size' class='form-control' required>
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