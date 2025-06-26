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

            <!-- CSRF token -->
            <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" 
                   value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="row">
              <!-- Customer Info -->
              <div class="col-md-6">
                <div class="form-group">
                  <label for="customer_name">Customer</label>
                  <select id="customer_name" name="customer_name" class="form-control select2" required>
                    <option value="">Select Customer</option>
                    <?php foreach ($customers as $customer): ?>
                      <option value="<?= $customer['userid']; ?>">
                        <?= $customer['company'] . ' (' . $customer['phonenumber'] . ')'; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>

              <!-- Job Details -->
              <div class="col-md-3">
                <div class="form-group">
                  <label>Job Card Number</label>
                  <input type="text" name="job_card_number" class="form-control" value="<?= set_value('job_card_number', $job_card_number); ?>" readonly>
                </div>
              </div>

              <div class="col-md-3">
                <div class="form-group">
                  <label>Date</label>
                  <input type="date" name="date_jobcard" class="form-control" value="<?= set_value('date_jobcard', $date_jobcard); ?>">
                </div>
              </div>
            </div>

            <hr>

            <!-- Machine Info Section -->
            <h5>Machine Print Information</h5>
            <div id="machineInfoSection">
              <table class="table table-bordered" id="machineInfoTable">
                <thead>
                  <tr>
                    <th>Form Name</th>
                    <th>Printing Machine</th>
                    <th>Plate Size</th>
                    <th>Set Qty</th>
                    <th>Used Plate Qty</th>
                    <th>Paper Master</th>
                    <th>Used Paper Qty</th>
                    <th>Cut Size</th>
                    <th>Printing Qty</th>
                    <th>Gripper</th>
                    <th>Color</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <button type="button" class="btn btn-primary" id="addMachineRow">Add Machine Info</button>
            </div>

            <hr>

            <!-- Postpress Info Section -->
            <h5>Postpress Information</h5>
            <div id="postpressSection">
              <table class="table table-bordered" id="postpressTable">
                <thead>
                  <tr>
                    <th>Postpress Process</th>
                    <th>Process Type</th>
                    <th>Size</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody></tbody>
              </table>
              <button type="button" class="btn btn-primary" id="addPostpressRow">Add Postpress Info</button>
            </div>

            <hr>

            <!-- Delivery Info -->
            <h5>Delivery Information</h5>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Delivery Address</label>
                  <textarea name="delivery_address" class="form-control" rows="3"></textarea>
                </div>
              </div>

              <div class="col-md-6">
                <div class="form-group">
                  <label>Delivery Channel</label>
                  <input type="text" name="delivery_channel" class="form-control">
                </div>
              </div>
            </div>

            <!-- Hidden form_details field -->
            <input type="hidden" name="form_details" id="form_details">

            <div class="text-center">
              <button type="submit" class="btn btn-success mt-4">Save Job Card</button>
            </div>

            <?= form_close(); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php init_tail(); ?>

<script>
$(function() {
  // Initialize select2
  $('.select2').select2();

  // Machine Info - Add Row
  $('#addMachineRow').on('click', function() {
    var row = `
      <tr>
        <td><input type="text" name="form_name[]" class="form-control"></td>
        <td><input type="text" name="printing_machine[]" class="form-control"></td>
        <td><input type="text" name="plate_size[]" class="form-control"></td>
        <td><input type="number" name="set_qty[]" class="form-control"></td>
        <td><input type="number" name="used_plate_qty[]" class="form-control"></td>
        <td><input type="text" name="paper_master[]" class="form-control"></td>
        <td><input type="number" name="master_paper_qty[]" class="form-control"></td>
        <td><input type="text" name="paper_cut_size[]" class="form-control"></td>
        <td><input type="number" name="printing_qty[]" class="form-control"></td>
        <td><input type="text" name="gripper[]" class="form-control"></td>
        <td><input type="text" name="color[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
      </tr>
    `;
    $('#machineInfoTable tbody').append(row);
  });

  // Postpress Info - Add Row
  $('#addPostpressRow').on('click', function() {
    var row = `
      <tr>
        <td><input type="text" name="postpress_process[]" class="form-control"></td>
        <td><input type="text" name="process_type[]" class="form-control"></td>
        <td><input type="text" name="paper_size[]" class="form-control"></td>
        <td><button type="button" class="btn btn-danger btn-sm removeRow">X</button></td>
      </tr>
    `;
    $('#postpressTable tbody').append(row);
  });

  // Remove Row
  $(document).on('click', '.removeRow', function() {
    $(this).closest('tr').remove();
  });

  // Serialize form before submit
  $('#jobCardForm').submit(function(e) {
    var formData = {
      machine_print_rows: [],
      postpress_rows: []
    };

    $('#machineInfoTable tbody tr').each(function() {
      formData.machine_print_rows.push({
        form_name: $(this).find('[name="form_name[]"]').val(),
        printing_machine: $(this).find('[name="printing_machine[]"]').val(),
        plate_size: $(this).find('[name="plate_size[]"]').val(),
        set_qty: $(this).find('[name="set_qty[]"]').val(),
        used_plate_qty: $(this).find('[name="used_plate_qty[]"]').val(),
        paper_master: $(this).find('[name="paper_master[]"]').val(),
        master_paper_qty: $(this).find('[name="master_paper_qty[]"]').val(),
        paper_cut_size: $(this).find('[name="paper_cut_size[]"]').val(),
        printing_qty: $(this).find('[name="printing_qty[]"]').val(),
        gripper: $(this).find('[name="gripper[]"]').val(),
        color: $(this).find('[name="color[]"]').val()
      });
    });

    $('#postpressTable tbody tr').each(function() {
      formData.postpress_rows.push({
        postpress_process: $(this).find('[name="postpress_process[]"]').val(),
        process_type: $(this).find('[name="process_type[]"]').val(),
        size: $(this).find('[name="paper_size[]"]').val()
      });
    });

    $('#form_details').val(JSON.stringify(formData));
    return true; // Submit form normally
  });
});
</script>
