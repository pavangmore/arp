<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>

<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-heading">
            <h4><?= _l('Edit Job Card'); ?></h4>
          </div>
          <div class="panel-body">
            <?= form_open(admin_url('job_card_management/edit/' . $job_card['id']), ['id' => 'jobCardForm']); ?>
            <input type="hidden" name="form_details" id="form_details" />
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="customer_name">Customer Name or Mobile (mandatory)</label>
                  <select name="customer_name" id="customer_name" class="form-control select2" required>
                    <option value="">Search and Select Customer</option>
                    <?php foreach ($customers as $customer) { ?>
                    <option value="<?= $customer['userid']; ?>" data-phone="<?= $customer['phonenumber']; ?>" <?= ($customer['userid'] == $job_card['customer_name']) ? 'selected' : '' ?>>
                      <?= $customer['company']; ?> (<?= $customer['phonenumber']; ?>)
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <hr>

            <div class="row">
              <div class="col-md-6">
                <h4>Job Information</h4>
                <div class="form-group">
                  <label for="job_card_number">Job Card Number</label>
                  <input type="text" name="job_card_number" class="form-control" value="<?= $job_card['job_card_number']; ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="date_jobcard">Date of Jobcard</label>
                  <input type="date" name="date_jobcard" class="form-control" value="<?= $job_card['date_jobcard'] ?>" readonly>
                </div>
                <div class="form-group">
                  <label for="job_name">Job Name</label>
                  <input type="text" name="job_name" class="form-control" value="<?= $job_card['job_name']; ?>">
                </div>
                <div class="form-group">
                  <label for="job_cut_size">Job Cut Size</label>
                  <input type="text" name="job_cut_size" class="form-control" value="<?= $job_card['job_cut_size']; ?>">
                </div>
                <div class="form-group">
                  <label for="job_qty">Job Qty</label>
                  <input type="text" name="job_qty" class="form-control" value="<?= $job_card['job_qty']; ?>">
                </div>
              </div>
            </div>

            <hr>

            <h4>Machine, Paper & Printing Information
              <button type="button" class="btn btn-sm btn-success" onclick="addMachineRow()"><i class="fa fa-plus"></i> Add</button>
            </h4>
            <table class="table table-bordered" id="machinePrintTable">
              <thead>
                <tr>
                  <th>Form Name</th>
                  <th>Printing Machine</th>
                  <th>Plate Size</th>
                  <th>Set Qty</th>
                  <th>Used Plate Qty</th>
                  <th>Paper Master</th>
                  <th>Paper Buy</th>
                  <th>Used Paper Qty</th>
                  <th>Cut Size</th>
                  <th>Print Qty</th>
                  <th>Gripper</th>
                  <th>Color</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="machineRows">
              </tbody>
            </table>

            <hr>

            <h4>Postpress Information
              <button type="button" class="btn btn-sm btn-success" onclick="addPostpressRow()"><i class="fa fa-plus"></i> Add</button>
            </h4>
            <table class="table table-bordered" id="postpressTable">
              <thead>
                <tr>
                  <th>Postpress Process</th>
                  <th>Process Type</th>
                  <th>Size</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody id="postpressRows">
              </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Update Job Card</button>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function addMachineRow(data = {}) {
  let row = `<tr>
    <td><input type="text" class="form-control form_name" value="${data.form_name || ''}"/></td>
    <td><select class="form-control printing_machine select2"><?php foreach ($printing_machines as $m) echo "<option value='{$m['machine_name']}'> {$m['machine_name']}</option>"; ?></select></td>
    <td><select class="form-control plate_size select2"><?php foreach ($plate_sizes as $p) echo "<option value='{$p['plate_size']}'>{$p['plate_size']}</option>"; ?></select></td>
    <td><input type="text" class="form-control set_qty" value="${data.set_qty || ''}"/></td>
    <td><input type="text" class="form-control used_plate_qty" value="${data.used_plate_qty || ''}"/></td>
    <td><select class="form-control paper_master select2"><?php foreach ($paper_master as $p) echo "<option value='{$p['id']}'>{$p['size']} - {$p['paper_type']} - {$p['gsm']} GSM</option>"; ?></select></td>
    <td><label><input type="checkbox" class="paper_buy" value="Party" ${data.paper_buy?.includes('Party') ? 'checked' : ''}> Party</label><br><label><input type="checkbox" class="paper_buy" value="AR" ${data.paper_buy?.includes('AR') ? 'checked' : ''}> A.R.</label></td>
    <td><input type="text" class="form-control master_paper_qty" value="${data.used_paper_qty || ''}"/></td>
    <td><input type="text" class="form-control paper_cut_size" value="${data.cut_size || ''}"/></td>
    <td><input type="text" class="form-control printing_qty" value="${data.print_qty || ''}"/></td>
    <td><select class="form-control gripper select2"><?php foreach ($gripper as $g) echo "<option value='{$g['gripper']}'>{$g['gripper']}</option>"; ?></select></td>
    <td><input type="text" class="form-control color" value="${data.color || ''}"/></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
  </tr>`;
  $('#machineRows').append(row);
}
function removeRow(btn) {
  if ($('#machineRows tr').length > 1) $(btn).closest('tr').remove();
}
function addPostpressRow(data = {}) {
  let row = `<tr>
    <td><select class="form-control postpress_process select2"><?php foreach ($postpress_machines as $pm) echo "<option value='{$pm['id']}'>{$pm['process_name']}</option>"; ?></select></td>
    <td><select class="form-control process_type select2"><?php foreach ($postpress_type as $pt) echo "<option value='{$pt['process_type']}'>{$pt['process_type']}</option>"; ?></select></td>
    <td><input type="text" class="form-control paper_size" value="${data.size || ''}"/></td>
    <td><button type="button" class="btn btn-danger btn-sm" onclick="removePostpressRow(this)"><i class="fa fa-trash"></i></button></td>
  </tr>`;
  $('#postpressRows').append(row);
}
function removePostpressRow(btn) {
  if ($('#postpressRows tr').length > 1) $(btn).closest('tr').remove();
}
$(document).ready(function() {
  let formDetails = <?= $job_card['form_details'] ? $job_card['form_details'] : 'null' ?>;
  if (formDetails?.machine_print_rows) {
    formDetails.machine_print_rows.forEach(row => addMachineRow(row));
  } else {
    addMachineRow();
  }
  if (formDetails?.postpress_rows) {
    formDetails.postpress_rows.forEach(row => addPostpressRow(row));
  } else {
    addPostpressRow();
  }
});
$('#jobCardForm').on('submit', function() {
  let formDetails = { machine_print_rows: [], postpress_rows: [] };
  $('#machineRows tr').each(function() {
    formDetails.machine_print_rows.push({
      form_name: $(this).find('.form_name').val(),
      printing_machine: $(this).find('.printing_machine').val(),
      plate_size: $(this).find('.plate_size').val(),
      set_qty: $(this).find('.set_qty').val(),
      used_plate_qty: $(this).find('.used_plate_qty').val(),
      paper_master: $(this).find('.paper_master').val(),
      paper_buy: $(this).find('input.paper_buy:checked').map(function(){ return this.value }).get(),
      used_paper_qty: $(this).find('.master_paper_qty').val(),
      cut_size: $(this).find('.paper_cut_size').val(),
      print_qty: $(this).find('.printing_qty').val(),
      gripper: $(this).find('.gripper').val(),
      color: $(this).find('.color').val()
    });
  });
  $('#postpressRows tr').each(function() {
    formDetails.postpress_rows.push({
      postpress_process: $(this).find('.postpress_process').val(),
      process_type: $(this).find('.process_type').val(),
      size: $(this).find('.paper_size').val()
    });
  });
  $('#form_details').val(JSON.stringify(formDetails));
});
</script>

<?php init_tail(); ?>
