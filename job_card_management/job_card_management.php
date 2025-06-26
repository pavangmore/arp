<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
Module Name: Job Card
Description: new caed
Version: 1.2.0
Requires at least: 2.3.*
*/



class Job_card_management extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('job_cards_model');
    }

    public function manage()
    {
        if (!has_permission('job_cards', '', 'view')) {
            access_denied('job_cards');
        }

        $data['title'] = _l('job_cards');
        $data['job_cards'] = $this->job_cards_model->get_all();
        $this->load->admin_view('admin/manage', $data);
    }

    public function save($id = '')
    {
        if ($this->input->post()) {
            $data = $this->input->post();
            
            if ($id == '') {
                if (!has_permission('job_cards', '', 'create')) {
                    access_denied('job_cards');
                }
                $id = $this->job_cards_model->add($data);
                set_alert('success', _l('added_successfully', _l('job_card')));
            } else {
                if (!has_permission('job_cards', '', 'edit')) {
                    access_denied('job_cards');
                }
                $this->job_cards_model->update($id, $data);
                set_alert('success', _l('updated_successfully', _l('job_card')));
            }
            
            redirect(admin_url('job_card_management/manage'));
        }

        if ($id != '') {
            $data['job_card'] = $this->job_cards_model->get($id);
        }
        
        $data['title'] = $id ? _l('edit_job_card') : _l('new_job_card');
        $data['clients'] = $this->clients_model->get();
        $this->load->admin_view('admin/modal', $data);
    }

    public function client_view($client_id)
    {
        if (!has_customer_permission('job_cards')) {
            access_denied();
        }
        $data['cards'] = $this->job_cards_model->get_client_cards($client_id);
        $this->load->view('clients/client_view', $data);
    }
}
