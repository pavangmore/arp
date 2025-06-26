<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-heading">
                        <h4><?= _l($title); ?></h4>
                    </div>
                    <div class="panel-body">
                        <a href="<?= admin_url("job_paper_master/add/{$type}"); ?>" class="btn btn-primary mb-3">Add New</a>
                        <table class="table dt-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                 
                                    <th>GSM</th>
                                 

                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($entries)) { ?>
                                    <?php foreach ($entries as $entry) { ?>
                                        <tr>
                                            <td><?= $entry['id']; ?></td>
                                          
                                            <td><?= $entry['gsm']; ?></td>

                                            <td>
                                                <a href="<?= admin_url("job_paper_master/edit/{$type}/" . $entry['id']); ?>" class="btn btn-sm btn-warning">Edit</a>
                                                <a href="<?= admin_url("job_paper_master/delete/{$type}/" . $entry['id']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this entry?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } else { ?>
                                    <tr><td colspan="5" class="text-center">No entries found.</td></tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>