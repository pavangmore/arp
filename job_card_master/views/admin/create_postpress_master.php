<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id='wrapper'>
    <div class='content'>
        <div class='row'>
            <div class='col-md-6'>
                <div class='panel_s'>
                    <div class='panel-heading'>
                        <h4><?= _l('Add ' . ucwords(str_replace('_', ' ', 'postpress')) . ' Master Entry'); ?></h4>
                    </div>
                    <div class='panel-body'>
                       <?= form_open(admin_url('job_card_master/add/postpress')); ?>
    
    <!--<div class='form-group'>-->
    <!--    <label>Lamination</label>-->
    <!--    <select name='lamination' class='form-control' required>-->
    <!--        <option value=''>Select Lamination Type</option>-->
    <!--        <option value='Glossy'>Glossy</option>-->
    <!--        <option value='Matte'>Matte</option>-->
    <!--        <option value='Soft Touch'>Soft Touch</option>-->
    <!--        <option value='Textured'>Textured</option>-->
    <!--        <option value='Thermal'>Thermal</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    <!--<div class='form-group'>-->
    <!--    <label>Binding</label>-->
    <!--    <select name='binding' class='form-control' required>-->
    <!--        <option value=''>Select Binding Type</option>-->
    <!--        <option value='Saddle Stitch'>Saddle Stitch</option>-->
    <!--        <option value='Perfect Binding'>Perfect Binding</option>-->
    <!--        <option value='Spiral'>Spiral</option>-->
    <!--        <option value='Wire-O'>Wire-O</option>-->
    <!--        <option value='Case Binding'>Case Binding</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    <!--<div class='form-group'>-->
    <!--    <label>Coating</label>-->
    <!--    <select name='coating' class='form-control' required>-->
    <!--        <option value=''>Select Coating Type</option>-->
    <!--        <option value='UV Coating'>UV Coating</option>-->
    <!--        <option value='Aqueous Coating'>Aqueous Coating</option>-->
    <!--        <option value='Spot UV'>Spot UV</option>-->
    <!--        <option value='Gloss Coating'>Gloss Coating</option>-->
    <!--        <option value='Matte Coating'>Matte Coating</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    <div class='form-group'>
        <label>Process</label>
        <input type='text' name='process_name' class='form-control' required>
    </div>
    
    <div class='form-group'>
        <label>Type</label>
        <input type='text' name='process_type' class='form-control' required>
    </div>
    
    <!--<div class='form-group'>-->
    <!--    <label>Size</label>-->
    <!--    <input type='text' name='size' class='form-control' required>-->
    <!--</div>-->
    
    <!--<div class='form-group'>-->
    <!--    <label>Assign Machine</label>-->
    <!--    <input type='text' name='assign_machine' class='form-control' required>-->
    <!--</div>-->
    
   
       <div class='form-group'>
                            <label>Assign Name</label>
                            <select name='machine_name_master' class='form-control' required>
                                <option value=''>Select Machine</option>
                                <?php foreach ($machine_name_master as $machine_name_master) { ?>
                                    <option value='<?= $machine_name_master['machine_name_master']; ?>'><?= $machine_name_master['machine_name_master']; ?></option>
                                <?php } ?>
                            </select>
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
