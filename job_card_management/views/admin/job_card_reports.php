<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
  <div class="content">



    <hr class="my-4">

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
    
        <div class="row">
      <div class="col-md-3">
        <h5 class="text-center">Job Cards by Status (Bar)</h5>
        <canvas id="jobStatusBarChart"></canvas>
      </div>
      <div class="col-md-2">
        <h5 class="text-center">Status Distribution (Pie)</h5>
        <canvas id="jobStatusPieChart"></canvas>
      </div>
    </div>

  </div>
</div>
<?php init_tail(); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const barCtx = document.getElementById('jobStatusBarChart').getContext('2d');
  const pieCtx = document.getElementById('jobStatusPieChart').getContext('2d');

  const data = {
    labels: ['Pending', 'In Progress', 'Completed'],
    datasets: [{
      label: 'Job Cards',
      data: [<?= $pending ?>, <?= $inprogress ?>, <?= $completed ?>],
      backgroundColor: ['#f6c23e', '#36b9cc', '#1cc88a']
    }]
  };

  new Chart(barCtx, {
    type: 'bar',
    data: data,
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          precision: 0
        }
      }
    }
  });

  new Chart(pieCtx, {
    type: 'pie',
    data: data,
    options: {
      responsive: true
    }
  });
</script>
