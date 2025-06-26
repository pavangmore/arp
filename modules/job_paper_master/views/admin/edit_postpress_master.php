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
    
    <!--<div class='form-group'>-->
    <!--    <label>Lamination</label>-->
    <!--    <select name='lamination' class='form-control' required>-->
    <!--        <option value='Glossy' <?= ($entry['lamination'] == 'Glossy') ? 'selected' : ''; ?>>Glossy</option>-->
    <!--        <option value='Matte' <?= ($entry['lamination'] == 'Matte') ? 'selected' : ''; ?>>Matte</option>-->
    <!--        <option value='Soft Touch' <?= ($entry['lamination'] == 'Soft Touch') ? 'selected' : ''; ?>>Soft Touch</option>-->
    <!--        <option value='Textured' <?= ($entry['lamination'] == 'Textured') ? 'selected' : ''; ?>>Textured</option>-->
    <!--        <option value='Thermal' <?= ($entry['lamination'] == 'Thermal') ? 'selected' : ''; ?>>Thermal</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    <!--<div class='form-group'>-->
    <!--    <label>Binding</label>-->
    <!--    <select name='binding' class='form-control' required>-->
    <!--        <option value='Saddle Stitch' <?= ($entry['binding'] == 'Saddle Stitch') ? 'selected' : ''; ?>>Saddle Stitch</option>-->
    <!--        <option value='Perfect Binding' <?= ($entry['binding'] == 'Perfect Binding') ? 'selected' : ''; ?>>Perfect Binding</option>-->
    <!--        <option value='Spiral' <?= ($entry['binding'] == 'Spiral') ? 'selected' : ''; ?>>Spiral</option>-->
    <!--        <option value='Wire-O' <?= ($entry['binding'] == 'Wire-O') ? 'selected' : ''; ?>>Wire-O</option>-->
    <!--        <option value='Case Binding' <?= ($entry['binding'] == 'Case Binding') ? 'selected' : ''; ?>>Case Binding</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    <!--<div class='form-group'>-->
    <!--    <label>Coating</label>-->
    <!--    <select name='coating' class='form-control' required>-->
    <!--        <option value='UV Coating' <?= ($entry['coating'] == 'UV Coating') ? 'selected' : ''; ?>>UV Coating</option>-->
    <!--        <option value='Aqueous Coating' <?= ($entry['coating'] == 'Aqueous Coating') ? 'selected' : ''; ?>>Aqueous Coating</option>-->
    <!--        <option value='Spot UV' <?= ($entry['coating'] == 'Spot UV') ? 'selected' : ''; ?>>Spot UV</option>-->
    <!--        <option value='Gloss Coating' <?= ($entry['coating'] == 'Gloss Coating') ? 'selected' : ''; ?>>Gloss Coating</option>-->
    <!--        <option value='Matte Coating' <?= ($entry['coating'] == 'Matte Coating') ? 'selected' : ''; ?>>Matte Coating</option>-->
    <!--    </select>-->
    <!--</div>-->
    
    <div class='form-group'>
        <label>Process</label>
        <input type='text' name='folding' class='form-control' value="<?= $entry['process']; ?>" required>
    </div>
    
    <div class='form-group'>
        <label>Type</label>
        <input type='text' name='punching' class='form-control' value="<?= $entry['type']; ?>" required>
    </div>
    
    <!--<div class='form-group'>-->
    <!--    <label>Size</label>-->
    <!--    <input type='text' name='box_pasting' class='form-control' value="<?= $entry['size']; ?>" required>-->
    <!--</div>-->
    
    <!--<div class='form-group'>-->
    <!--    <label>Assign Machine</label>-->
    <!--    <input type='text' name='packing' class='form-control' value="<?= $entry['assign_machine']; ?>" required>-->
    <!--</div>-->
    
       <div class='form-group'>
                            <label>Assign Name</label>
                            <select name='machine_name' class='form-control' required>
                                <option value=''>Select Machine</option>
                                <?php foreach ($machine_name as $machine_name) { ?>
                                    <option value='<?= $machine_name['machine_name']; ?>'><?= $machine_name['machine_name']; ?></option>
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
