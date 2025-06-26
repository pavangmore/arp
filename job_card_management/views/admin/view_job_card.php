<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php init_head(); ?>
<style>
  @media print {
    .no-print { display: none; }
  }
</style>
<div id="wrapper">
  <div class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-heading">
            <h4>Job Card View: <?= $job_card['job_card_number']; ?></h4>
            <div class="pull-right no-print">
              <a href="#" onclick="window.print(); return false;" class="btn btn-default">Print</a>
              <a href="<?= admin_url('job_card_management/export_pdf/' . $job_card['id']); ?>" class="btn btn-info">Download PDF</a>
            </div>
          </div>
          <div class="panel-body">
            <h4>Customer: <?= get_company_name($job_card['customer_name']); ?></h4>
            <p>Date: <?= _d($job_card['date_jobcard']); ?></p>
            <p>Job Name: <?= $job_card['job_name']; ?> | Qty: <?= $job_card['job_qty']; ?> | Size: <?= $job_card['job_cut_size']; ?></p>
            <hr>
            <h4>Machine, Paper & Printing Info</h4>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Form Name</th><th>Machine</th><th>Plate</th><th>Set Qty</th><th>Used Plate</th>
                  <th>Paper</th><th>Paper Buy</th><th>Used Qty</th><th>Cut Size</th><th>Print Qty</th><th>Gripper</th><th>Color</th>
                </tr>
              </thead>
              <tbody>
                <?php $details = json_decode($job_card['form_details'], true); foreach ($details['machine_print_rows'] as $row) { ?>
                <tr>
                  <td><?= $row['form_name']; ?></td>
                  <td><?= $row['printing_machine']; ?></td>
                  <td><?= $row['plate_size']; ?></td>
                  <td><?= $row['set_qty']; ?></td>
                  <td><?= $row['used_plate_qty']; ?></td>
                  <td><?= $row['paper_master']; ?></td>
                  <td><?= implode(', ', $row['paper_buy']); ?></td>
                  <td><?= $row['used_paper_qty']; ?></td>
                  <td><?= $row['cut_size']; ?></td>
                  <td><?= $row['print_qty']; ?></td>
                  <td><?= $row['gripper']; ?></td>
                  <td><?= $row['color']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

            <h4>Postpress Information</h4>
            <table class="table table-bordered">
              <thead>
                <tr><th>Process</th><th>Type</th><th>Size</th></tr>
              </thead>
              <tbody>
                <?php foreach ($details['postpress_rows'] as $row) { ?>
                <tr>
                  <td><?= $row['postpress_process']; ?></td>
                  <td><?= $row['process_type']; ?></td>
                  <td><?= $row['size']; ?></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>

            <h4>Status: <?= $job_card['job_status']; ?></h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php init_tail(); ?>
