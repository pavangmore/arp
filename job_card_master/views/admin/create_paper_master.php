<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id='wrapper'>
    <div class='content'>
        <div class='row'>
            <div class='col-md-6'>
                <div class='panel_s'>
                    <div class='panel-heading'>
                        <h4><?= _l('Add ' . ucwords(str_replace('_', ' ', 'paper')) . ' Master Entry'); ?></h4>
                    </div>
                    <div class='panel-body'>
                       <?= form_open(admin_url('job_card_master/add/paper')); ?>
                        
                        <div class='form-group'>
                            <label>Size</label>
                            <select name='size' class='form-control' required>
                                <option value=''>Select Paper Size</option>
                                <?php foreach ($paper_sizes as $size) { ?>
                                    <option value='<?= $size['paper_size']; ?>'><?= $size['paper_size']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                     
                             <div class='form-group'>
                            <label>Paper Type</label>
                            <select name='paper_type' class='form-control' required>
                                <option value=''>Select Type</option>
                                <?php foreach ($paper_type as $paper_type) { ?>
                                    <option value='<?= $paper_type['paper_type']; ?>'><?= $paper_type['paper_type']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        
                        <div class='form-group'>
                            <label>GSM</label>
                            <select name='gsm' class='form-control' required>
                                <option value=''>Select GSM</option>
                                <?php foreach ($paper_gsm as $gsm) { ?>
                                    <option value='<?= $gsm['gsm']; ?>'><?= $gsm['gsm']; ?></option>
                                <?php } ?>
                            </select>
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
