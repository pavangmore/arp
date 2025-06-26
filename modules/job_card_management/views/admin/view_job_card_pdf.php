
<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<html>
<head>
  <meta charset="utf-8">
  <title>Job Card PDF</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h2, h3 { margin: 0; padding: 0; }
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th, td { border: 1px solid #333; padding: 5px; text-align: left; }
    .section-title { margin-top: 20px; font-size: 14px; font-weight: bold; }
  </style>
</head>
<body>

<?php $details = isset($form_details) ? $form_details : ['machine_print_rows' => [], 'postpress_rows' => []]; ?>

<h2>Job Card: <?= $job_card['job_card_number']; ?></h2>
<p><strong>Date:</strong> <?= _d($job_card['date_jobcard']); ?></p>
<p><strong>Customer:</strong> <?= get_company_name($job_card['customer_name']); ?></p>
<p><strong>Job Name:</strong> <?= $job_card['job_name']; ?> | <strong>Qty:</strong> <?= $job_card['job_qty']; ?> | <strong>Size:</strong> <?= $job_card['job_cut_size']; ?></p>

<div class="section-title">Machine, Paper & Printing Info</div>
<table>
  <thead>
    <tr>
      <th>Form Name</th><th>Machine</th><th>Plate</th><th>Set Qty</th><th>Used Plate</th>
      <th>Paper</th><th>Paper Buy</th><th>Used Qty</th><th>Cut Size</th><th>Print Qty</th><th>Gripper</th><th>Color</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($details['machine_print_rows'])): foreach ($details['machine_print_rows'] as $row): ?>
    <tr>
      <td><?= $row['form_name']; ?></td>
      <td><?= $row['printing_machine']; ?></td>
      <td><?= $row['plate_size']; ?></td>
      <td><?= $row['set_qty']; ?></td>
      <td><?= $row['used_plate_qty']; ?></td>
      <td><?= $row['paper_master']; ?></td>
      <td><?= is_array($row['paper_buy']) ? implode(', ', $row['paper_buy']) : $row['paper_buy']; ?></td>
      <td><?= $row['used_paper_qty']; ?></td>
      <td><?= $row['cut_size']; ?></td>
      <td><?= $row['print_qty']; ?></td>
      <td><?= $row['gripper']; ?></td>
      <td><?= $row['color']; ?></td>
    </tr>
    <?php endforeach; endif; ?>
  </tbody>
</table>

<div class="section-title">Postpress Information</div>
<table>
  <thead>
    <tr><th>Process</th><th>Type</th><th>Size</th></tr>
  </thead>
  <tbody>
    <?php if (!empty($details['postpress_rows'])): foreach ($details['postpress_rows'] as $row): ?>
    <tr>
      <td><?= $row['postpress_process']; ?></td>
      <td><?= $row['process_type']; ?></td>
      <td><?= $row['size']; ?></td>
    </tr>
    <?php endforeach; endif; ?>
  </tbody>
</table>

<div class="section-title">Delivery & Status</div>
<p><strong>Delivery Date:</strong> <?= _d($job_card['delivery_date']); ?>  
   | <strong>Urgent:</strong> <?= $job_card['delivery_urgent'] ? 'Yes' : 'No'; ?>  
   | <strong>Type:</strong> <?= $job_card['delivery_type']; ?></p>
<p><strong>Description:</strong> <?= $job_card['delivery_description']; ?></p>
<p><strong>Status:</strong> <?= $job_card['job_status']; ?></p>

</body>
</html>
