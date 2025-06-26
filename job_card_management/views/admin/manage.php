<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div class="content-wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="panel_s">
                    <div class="panel-body">
                        <h4 class="no-margin"><?= _l('job_cards'); ?>
                            <?php if (has_permission('job_cards', '', 'create')): ?>
                            <a href="<?= admin_url('job_card_management/save'); ?>" class="btn btn-primary pull-right">
                                <?= _l('new_job_card'); ?>
                            </a>
                            <?php endif; ?>
                        </h4>
                        <hr class="hr-panel-heading">
                        
                        <?php if (count($job_cards) > 0): ?>
                        <div class="table-responsive">
                            <table class="table dt-table">
                                <thead>
                                    <tr>
                                        <th><?= _l('id'); ?></th>
                                        <th><?= _l('client'); ?></th>
                                        <th><?= _l('vehicle_number'); ?></th>
                                        <th><?= _l('date_in'); ?></th>
                                        <th><?= _l('status'); ?></th>
                                        <th><?= _l('actions'); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($job_cards as $card): ?>
                                    <tr>
                                        <td><?= $card['id']; ?></td>
                                        <td><?= $card['client_name']; ?></td>
                                        <td><?= $card['vehicle_number']; ?></td>
                                        <td><?= _dt($card['date_in']); ?></td>
                                        <td><span class="label label-<?= $card['status'] == 'completed' ? 'success' : ($card['status'] == 'in_progress' ? 'info' : 'warning') ?>">
                                            <?= _l($card['status']); ?>
                                        </span></td>
                                        <td>
                                            <?php if (has_permission('job_cards', '', 'edit')): ?>
                                            <a href="<?= admin_url('job_card_management/save/'.$card['id']); ?>" class="btn btn-default btn-icon">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php else: ?>
                        <p class="no-margin"><?= _l('no_job_cards_found'); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php init_tail(); ?>
