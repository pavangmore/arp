<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">
      
      
    <div class="row">
        <div class="panel_s">
            <div class="panel-body">
                 <div class="row">
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-center">
            <h4>Total</h4>
            <h3><?= isset($total) ? $total : 0; ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-warning text-center">
            <h4>Pending</h4>
            <h3><?= isset($pending) ? $pending : 0; ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-info text-center">
            <h4>In Progress</h4>
            <h3><?= isset($inprogress) ? $inprogress : 0; ?></h3>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card">
          <div class="card-body text-success text-center">
            <h4>Completed</h4>
            <h3><?= isset($completed) ? $completed : 0; ?></h3>
          </div>
        </div>
      </div>
    </div>
            </div>
        </div>
      <div class="col-md-12">
        <div class="panel_s">
          <div class="panel-heading">
            <h4 class="pull-left">Job Card List</h4>
            <div class="pull-right">
              <a href="<?= admin_url('job_card_management/create'); ?>" class="btn btn-sm btn-success">Create New</a>
              <a href="<?= admin_url('job_card_management/reports'); ?>" class="btn btn-sm btn-info">Reports</a>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="panel-body">

            <?= form_open(admin_url('job_card_management/bulk_action')); ?>
            <div class="row mbot15">
              <div class="col-md-2">
                <select name="bulk_action" class="form-control" required>
                  <option value="">Bulk Actions</option>
                  <option value="Completed">Mark as Completed</option>
                  <option value="In Progress">Mark as In Progress</option>
                  <option value="Pending">Mark as Pending</option>
                  <option value="delete">Delete Selected</option>
                </select>
              </div>
              <div class="col-md-2">
                <button type="submit" class="btn btn-danger">Apply</button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                    <th><input type="checkbox" id="select_all"></th>
                    <th>#</th>
                    <th>Job Card No</th>
                    <th>Date</th>
                    <th>Customer</th>
                    <th>Job Name</th>
                    <th>Qty</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 1; foreach ($job_cards as $job): ?>
                    <tr>
                      <td><input type="checkbox" name="selected_ids[]" value="<?= $job['id']; ?>" class="bulk_checkbox"></td>
                      <td><?= $i++; ?></td>
                      <td><?= $job['job_card_number']; ?></td>
                      <td><?= _d($job['date_jobcard']); ?></td>
                      <td>
                        <?php
                          $cust = array_filter($customers, fn($c) => $c['userid'] == $job['customer_name']);
                          echo $cust ? reset($cust)['company'] : 'Unknown';
                        ?>
                      </td>
                      <td><?= $job['job_name']; ?></td>
                      <td><?= $job['job_qty']; ?></td>
                      <td>
                        <?php if ($job['job_status'] == 'Pending') echo '<span class="label label-warning">Pending</span>';
                              elseif ($job['job_status'] == 'Completed') echo '<span class="label label-success">Completed</span>';
                              else echo '<span class="label label-info">In Progress</span>'; ?>
                      </td>
                      <td class="text-center">
                        <a href="<?= admin_url('job_card_management/view/' . $job['id']); ?>" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                        <a href="<?= admin_url('job_card_management/edit/' . $job['id']); ?>" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i></a>
                        <a href="<?= admin_url('job_card_management/export_pdf/' . $job['id']); ?>" class="btn btn-sm btn-warning"><i class="fa-solid fa-file-pdf"></i></a>
                        <a href="<?= admin_url('job_card_management/delete/' . $job['id']); ?>" class="btn btn-sm btn-danger _delete"><i class="fa fa-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <?= form_close(); ?>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  $('#select_all').on('click', function() {
    $('.bulk_checkbox').prop('checked', this.checked);
  });
</script>
<?php init_tail(); ?>