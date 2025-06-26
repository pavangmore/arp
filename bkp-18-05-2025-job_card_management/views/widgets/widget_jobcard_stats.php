<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="panel_s">
  <div class="panel-body dashboard-widget">
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
