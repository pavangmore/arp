<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-heading">
            <h4><?= _l('Create Job Card'); ?></h4>
          </div>
          <div class="panel-body">
            <?= form_open(admin_url('job_card_management/create'), ['id' => 'jobCardForm']); ?>
            <input type="hidden" name="form_details" id="form_details" />
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="customer_name">Customer Name or Mobile (mandatory)</label>
                  <select name="customer_name" id="customer_name" class="form-control select2" required>
                    <option value="">Search and Select Customer</option>
                    <?php foreach ($customers as $customer): ?>
                      <option value="<?= $customer['userid']; ?>" data-phone="<?= $customer['phonenumber']; ?>">
                        <?= $customer['company']; ?> (<?= $customer['phonenumber']; ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>
            
            
            //cusomer trials
            
     <div class="row">
  <div class="col-md-4">
    <div class="form-group select-placeholder">
      <label for="customer_name" class="control-label">
        <?= _l('customer'); ?> <span class="text-danger">*</span>
      </label>
      <select id="customer_name"
              name="customer_name"
              class="form-control select_ajax_search"
              data-width="100%"
              data-none-selected-text="<?= _l('dropdown_non_selected_tex'); ?>"
              data-live-search="true"
              data-subtext="true"
              data-url="<?= admin_url('clients/ajax_search'); ?>"
              required>
      </select>
    </div>
  </div>

  <div class="col-md-4">
    <div class="form-group">
      <label for="customer_phone">Phone</label>
      <input type="text" readonly class="form-control" id="customer_phone">
    </div>
  </div>
</div>

            
            
            

             <hr>
            <h4>Job Information</h4>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="job_card_number">Job Card Number (Auto)</label>
                  <input type="text" name="job_card_number" class="form-control" value="<?= htmlspecialchars($job_card_number); ?>" readonly>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="date_jobcard">Date of Jobcard (Auto)</label>
                  <input type="date" name="date_jobcard" class="form-control" value="<?= htmlspecialchars($date_jobcard); ?>" readonly>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label for="job_name">Job Name</label>
                  <input type="text" name="job_name" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="job_cut_size">Job Cut Size</label>
                  <input type="text" name="job_cut_size" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="job_qty">Job Qty</label>
                  <input type="text" name="job_qty" class="form-control">
                </div>
              </div>
            </div>

                    <hr>
<h4>Machine, Paper & Printing Information
  <button type="button" class="btn btn-sm btn-success" onclick="addMachineRow()">
    <i class="fa fa-plus"></i> Add
  </button>
</h4>
<div class="table-responsive">
  <table class="table table-bordered" id="machinePrintTable">
    <thead>
      <tr>
        <th>Form Name</th>
        <th style="min-width: 180px;">Printing Machine</th>
        <th style="min-width: 160px;">Plate Size</th>
        <th>Set Qty</th>
        <th>Used Plate Qty</th>
        <th style="min-width: 200px;">Paper Master</th>
        <th>Paper Buy</th>
        <th>Used Paper Qty</th>
        <th>Cut Size</th>
        <th>Print Qty</th>
        <th style="min-width: 160px;">Gripper</th>
        <th>Color</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id="machineRows">
      <tr>
        <td><input type="text" class="form-control form_name" /></td>
        <td>
          <select class="form-control printing_machine select2">
            <?php foreach ($printing_machines as $m): ?>
              <option value="<?= $m['machine_name']; ?>"><?= $m['machine_name']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <select class="form-control plate_size select2">
            <?php foreach ($plate_sizes as $p): ?>
              <option value="<?= $p['plate_size']; ?>"><?= $p['plate_size']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td><input type="text" class="form-control set_qty" /></td>
        <td><input type="text" class="form-control used_plate_qty" /></td>
        <td>
          <select class="form-control paper_master select2">
            <?php foreach ($paper_master as $p): ?>
              <option value="<?= $p['id']; ?>">
                <?= $p['size']; ?> - <?= $p['paper_type']; ?> - <?= $p['gsm']; ?> GSM
              </option>
            <?php endforeach; ?>
          </select>
        </td>
        <td>
          <label><input type="checkbox" class="paper_buy" value="Party"> Party</label><br>
          <label><input type="checkbox" class="paper_buy" value="AR"> A.R.</label>
        </td>
        <td><input type="text" class="form-control master_paper_qty" /></td>
        <td><input type="text" class="form-control paper_cut_size" /></td>
        <td><input type="text" class="form-control printing_qty" /></td>
        <td>
          <select class="form-control gripper select2">
            <?php foreach ($gripper as $g): ?>
              <option value="<?= $g['gripper']; ?>"><?= $g['gripper']; ?></option>
            <?php endforeach; ?>
          </select>
        </td>
        <td><input type="text" class="form-control color" /></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)"><i class="fa fa-trash"></i></button></td>
      </tr>
    </tbody>
  </table>
</div>

            <hr>
            <h4>Postpress Information
              <button type="button" class="btn btn-sm btn-success" onclick="addPostpressRow()">
                <i class="fa fa-plus"></i> Add
              </button>
            </h4>
            <table class="table table-bordered" id="postpressTable">
              <thead>
                <tr><th>Postpress Process</th><th>Process Type</th><th>Size</th><th>Action</th></tr>
              </thead>
              <tbody id="postpressRows">
                <tr>
                  <td>
                    <select class="form-control postpress_process select2">
                      <?php foreach ($postpress_machines as $pm): ?>
                        <option value="<?= $pm['id']; ?>"><?= $pm['process_name']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td>
                    <select class="form-control process_type select2">
                      <?php foreach ($postpress_type as $pt): ?>
                        <option value="<?= $pt['process_type']; ?>"><?= $pt['process_type']; ?></option>
                      <?php endforeach; ?>
                    </select>
                  </td>
                  <td><input type="text" class="form-control paper_size" /></td>
                  <td><button type="button" class="btn btn-danger btn-sm" onclick="removePostpressRow(this)"><i class="fa fa-trash"></i></button></td>
                </tr>
              </tbody>
            </table>
            
             <hr>
            <h4>Delivery Information</h4>
            <div class="row">
              <div class="col-md-3">
                <div class="form-group">
                  <label for="delivery_date">Delivery Date</label>
                  <input type="date" name="delivery_date" class="form-control">
                </div>
              </div>
              <div class="col-md-2">
                <div class="form-group">
                  <label for="delivery_urgent">Urgent?</label><br>
                  <input type="checkbox" name="delivery_urgent" value="1">
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label for="delivery_type">Delivery Type</label>
                  <input type="text" name="delivery_type" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="delivery_description">Delivery Description</label>
                  <textarea name="delivery_description" rows="1" class="form-control"></textarea>
                </div>
              </div>
            </div>
            
            
            <button type="submit" class="btn btn-primary">Save Job Card</button>
            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





<script>
  $(function() {
    // Attach search
    init_ajax_search('customer', '#customer_name', '', admin_url + 'clients/ajax_search');

    // Phone autofill logic
    $('#customer_name').on('change', function () {
      var customerID = $(this).val();
      if (!customerID) return;

      $.ajax({
        url: admin_url + 'clients/get_customer_info_ajax/' + customerID,
        dataType: 'json',
        success: function (res) {
          if (res.success && res.customer) {
            $('#customer_phone').val(res.customer.phonenumber);
          } else {
            $('#customer_phone').val('');
          }
        }
      });
    });
  });
</script>






<script>
function addMachineRow() {
  const row = $('#machineRows tr:first').clone();
  row.find('input, select').val('').trigger('change');
  $('#machineRows').append(row);
}
function removeRow(btn) {
  if ($('#machineRows tr').length > 1) $(btn).closest('tr').remove();
}
function addPostpressRow() {
  const row = $('#postpressRows tr:first').clone();
  row.find('input, select').val('').trigger('change');
  $('#postpressRows').append(row);
}
function removePostpressRow(btn) {
  if ($('#postpressRows tr').length > 1) $(btn).closest('tr').remove();
}
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
