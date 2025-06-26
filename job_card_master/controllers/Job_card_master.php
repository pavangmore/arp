<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_card_master extends AdminController {
    public function __construct() {
        parent::__construct();
                $this->load->library('session'); // Manually load session

        $this->load->model('Job_card_master_model');
    }

    public function index() {
        redirect(admin_url('job_card_master/manage/plate'));
    }

    public function manage($type) {
        if (!in_array($type, [ 'plate','gripper', 'printing_machine', 'postpress_machine', 'postpress'])) {
            show_404();
        }

        $data['title'] = _l(ucwords(str_replace('_', ' ', $type)) . ' Master');
        $data['entries'] = $this->Job_card_master_model->get_all("tbl_{$type}_master");
        $data['type'] = $type;
        $data['plate_type'] = $plate_type;
        $data['plate_size'] = $plate_size;


        $this->load->view("admin/{$type}_master_list", $data);
    }

    public function add($type) {
        if (!in_array($type, ['plate', 'gripper', 'printing_machine', 'postpress_machine', 'postpress'])) {
            show_404();
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            log_message('error', 'Form Data Received: ' . json_encode($data)); // Debugging

            $inserted = $this->Job_card_master_model->insert("tbl_{$type}_master", $data);
            if ($inserted) {
                set_alert('success', ucfirst($type) . ' Master Entry Added Successfully');
            } else {
                set_alert('danger', 'Error: Failed to Insert ' . ucfirst($type) . ' Entry');
            }
            redirect(admin_url("job_card_master/manage/{$type}"));
        }

        $data['title'] = _l('Add ' . ucfirst($type) . ' Master Entry');
        $data['type'] = $type;
        $data['plate_type'] = $plate_type;
        $data['plate_size'] = $plate_size;
        $data['machine_name_master'] = $machine_name_master;
        $data['machine_namer'] = $machine_name;


        


        
        // Fetch paper sizes and GSM values if adding a paper master entry
        if ($type === 'paper') {
            $data['paper_sizes'] = $this->Job_card_master_model->get_all("tbl_paper_size_master");
            $data['paper_gsm'] = $this->Job_card_master_model->get_all("tbl_paper_gsm_master");
            $data['paper_type'] = $this->Job_card_master_model->get_all("tbl_paper_type_master");
            $data['plate'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");



        }
               // Fetch plate sizes and GSM values if adding a paper master entry
        if ($type === 'plate') {
            $data['plate_size'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_card_master_model->get_all("tbl_plate_master");
                        $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");



        }
        if ($type === 'printing_machine') {
            $data['plate_size'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_card_master_model->get_all("tbl_plate_master");
                        $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");


        }
        // if ($type === 'postpres_machine') {
        //     $data['process_name'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
        //     $data['process_type'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
        //     $data['process_size'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
        //     $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");


        // }
         if ($type === 'postpress') {
            $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");
            $data['process_type'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
            $data['process_size'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
            $data['machine_name'] = $this->Job_card_master_model->get_all("tbl_postpress_master");

        }
        $this->load->view("admin/create_{$type}_master", $data);
    }

    public function edit($type, $id) {
        if (!in_array($type, ['plate', 'gripper', 'printing_machine', 'postpress_machine', 'postpress'])) {
            show_404();
        }

        $data['entry'] = $this->Job_card_master_model->get_by_id("tbl_{$type}_master", $id);
        if (!$data['entry']) {
            show_404();
        }

        if ($this->input->post()) {
            $postData = $this->input->post();
            log_message('error', 'Edit Form Data Received: ' . json_encode($postData)); // Debugging

            $updated = $this->Job_card_master_model->update("tbl_{$type}_master", $id, $postData);
            if ($updated) {
                set_alert('success', ucfirst($type) . ' Master Entry Updated Successfully');
            } else {
                set_alert('danger', 'Error: Failed to Update ' . ucfirst($type) . ' Entry');
            }
            redirect(admin_url("job_card_master/manage/{$type}"));
        }

        $data['title'] = _l('Edit ' . ucfirst($type) . ' Master Entry');
        $data['type'] = $type;
        $data['plate_type'] = $plate_type;
        $data['plate_size'] = $plate_size;


        
        // Fetch paper sizes and GSM values if editing a paper master entry
        if ($type === 'paper') {
            $data['paper_size'] = $this->Job_card_master_model->get_all("tbl_paper_size_master");
            $data['paper_gsm'] = $this->Job_card_master_model->get_all("tbl_paper_gsm_master");
            $data['paper_type'] = $this->Job_card_master_model->get_all("tbl_paper_type_master");
            $data['plate'] = $this->Job_card_master_model->get_all("tbl_plate_master");


        }
           if ($type === 'plate') {
            $data['plate_size'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_card_master_model->get_all("tbl_plate_master");

        }
              if ($type === 'printing_machine') {
            $data['plate_size'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_card_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_card_master_model->get_all("tbl_plate_master");

        }
             if ($type === 'postpress') {
            $data['machine_name'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
            $data['process_type'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
            $data['process_size'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
            $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");

        }
        //       if ($type === 'postpress_master') {
        //     $data['machine_name_master'] = $this->Job_card_master_model->get_all("tbl_postpress_machine_master");
        //     $data['process_type'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
        //     $data['process_size'] = $this->Job_card_master_model->get_all("tbl_postpress_master");
        //     $data['machine_name'] = $this->Job_card_master_model->get_all("tbl_postpress_master");

        // }
        
        $this->load->view("admin/edit_{$type}_master", $data);
    }

    public function delete($type, $id) {
        if (!in_array($type, ['paper', 'paper_gsm', 'paper_size','paper_type', 'gripper','plate', 'printing_machine', 'postpress_machine', 'postpress'])) {
            show_404();
        }

        $deleted = $this->Job_card_master_model->delete("tbl_{$type}_master", $id);
        if ($deleted) {
            set_alert('success', ucfirst($type) . ' Master Entry Deleted Successfully');
        } else {
            set_alert('danger', 'Error: Failed to Delete ' . ucfirst($type) . ' Entry');
        }

        redirect(admin_url("job_card_master/manage/{$type}"));
    }
}
