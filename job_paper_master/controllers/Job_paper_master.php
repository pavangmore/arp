<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_paper_master extends AdminController {
    public function __construct() {
        parent::__construct();
                $this->load->library('session'); // Manually load session

        $this->load->model('Job_paper_master_model');
    }

    public function index() {
        redirect(admin_url('job_paper_master/manage/plate'));
    }

    public function manage($type) {
        if (!in_array($type, [ 'paper', 'paper_gsm', 'paper_size', 'paper_type'])) {
            show_404();
        }

        $data['title'] = _l(ucwords(str_replace('_', ' ', $type)) . ' Master');
        $data['entries'] = $this->Job_paper_master_model->get_all("tbl_{$type}_master");
        $data['type'] = $type;
        $data['plate_type'] = $plate_type;
        $data['plate_size'] = $plate_size;


        $this->load->view("admin/{$type}_master_list", $data);
    }

    public function add($type) {
        if (!in_array($type, ['paper', 'paper_gsm', 'paper_size','paper_type'])) {
            show_404();
        }

        if ($this->input->post()) {
            $data = $this->input->post();
            log_message('error', 'Form Data Received: ' . json_encode($data)); // Debugging

$table = "tbl_{$type}_master";

// Prevent duplicate Size+Type+GSM combination in paper master
if ($type === 'paper') {
    $this->db->where([
        'size' => $data['size'],
        'paper_type' => $data['paper_type'],
        'gsm' => $data['gsm']
    ]);
    $exists = $this->db->get($table)->row();
    if ($exists) {
        set_alert('danger', 'Error: A Paper Master with the same Size, Type, and GSM already exists.');
        redirect(admin_url("job_paper_master/manage/{$type}"));
        return;
    }
}

$inserted = $this->Job_paper_master_model->insert($table, $data);

            if ($inserted) {
                set_alert('success', ucfirst($type) . ' Master Entry Added Successfully');
            } else {
                set_alert('danger', 'Error: Failed to Insert ' . ucfirst($type) . ' Entry');
            }
            redirect(admin_url("job_paper_master/manage/{$type}"));
        }

        $data['title'] = _l('Add ' . ucfirst($type) . ' Master Entry');
        $data['type'] = $type;
        $data['plate_type'] = $plate_type;
        $data['plate_size'] = $plate_size;


        
        // Fetch paper sizes and GSM values if adding a paper master entry
        if ($type === 'paper') {
            $data['paper_sizes'] = $this->Job_paper_master_model->get_all("tbl_paper_size_master");
            $data['paper_gsm'] = $this->Job_paper_master_model->get_all("tbl_paper_gsm_master");
            $data['paper_type'] = $this->Job_paper_master_model->get_all("tbl_paper_type_master");
            $data['plate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");


        }
               // Fetch plate sizes and GSM values if adding a paper master entry
        if ($type === 'plate') {
            $data['plate_size'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_paper_master_model->get_all("tbl_plate_master");


        }
        if ($type === 'printing_machine') {
            $data['plate_size'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

        }
        if ($type === 'postpress') {
            $data['process_name'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['process_type'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['process_size'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['machine_name'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");

        }
        
        $this->load->view("admin/create_{$type}_master", $data);
    }

    public function edit($type, $id) {
        if (!in_array($type, ['paper', 'paper_gsm', 'paper_size','paper_type'])) {
            show_404();
        }

        $data['entry'] = $this->Job_paper_master_model->get_by_id("tbl_{$type}_master", $id);
        if (!$data['entry']) {
            show_404();
        }

        if ($this->input->post()) {
            $postData = $this->input->post();
            log_message('error', 'Edit Form Data Received: ' . json_encode($postData)); // Debugging

          $table = "tbl_{$type}_master";

// Prevent duplicate on update
if ($type === 'paper') {
    $this->db->where([
        'size' => $postData['size'],
        'paper_type' => $postData['paper_type'],
        'gsm' => $postData['gsm'],
    ]);
    $this->db->where('id !=', $id); // Exclude current row
    $exists = $this->db->get($table)->row();
    if ($exists) {
        set_alert('danger', 'Error: A Paper Master with the same Size, Type, and GSM already exists.');
        redirect(admin_url("job_paper_master/manage/{$type}"));
        return;
    }
}

$updated = $this->Job_paper_master_model->update($table, $id, $postData);

            if ($updated) {
                set_alert('success', ucfirst($type) . ' Master Entry Updated Successfully');
            } else {
                set_alert('danger', 'Error: Failed to Update ' . ucfirst($type) . ' Entry');
            }
            redirect(admin_url("job_paper_master/manage/{$type}"));
        }

        $data['title'] = _l('Edit ' . ucfirst($type) . ' Master Entry');
        $data['type'] = $type;
        $data['plate_type'] = $plate_type;
        $data['plate_size'] = $plate_size;


        
        // Fetch paper sizes and GSM values if editing a paper master entry
        if ($type === 'paper') {
            $data['paper_size'] = $this->Job_paper_master_model->get_all("tbl_paper_size_master");
            $data['paper_gsm'] = $this->Job_paper_master_model->get_all("tbl_paper_gsm_master");
            $data['paper_type'] = $this->Job_paper_master_model->get_all("tbl_paper_type_master");
            $data['plate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");


        }
           if ($type === 'plate') {
            $data['plate_size'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

        }
              if ($type === 'printing_machine') {
            $data['plate_size'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['plate_type'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");
            $data['sales_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['purchase_rate'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

            $data['gsm'] = $this->Job_paper_master_model->get_all("tbl_plate_master");

        }
             if ($type === 'postpress') {
            $data['machine_name'] = $this->Job_paper_master_model->get_all("tbl_postpress_machine_master");
            $data['process_type'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['process_size'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['machine'] = $this->Job_paper_master_model->get_all("tbl_postpress_machine_master");

        }
              if ($type === 'postpress_master') {
            $data['machine_name'] = $this->Job_paper_master_model->get_all("tbl_postpress_machine_master");
            $data['process_type'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['process_size'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");
            $data['machine_name'] = $this->Job_paper_master_model->get_all("tbl_postpress_master");

        }
        
        $this->load->view("admin/edit_{$type}_master", $data);
    }

    public function delete($type, $id) {
        if (!in_array($type, ['paper', 'paper_gsm', 'paper_size','paper_type'])) {
            show_404();
        }

        $deleted = $this->Job_paper_master_model->delete("tbl_{$type}_master", $id);
        if ($deleted) {
            set_alert('success', ucfirst($type) . ' Master Entry Deleted Successfully');
        } else {
            set_alert('danger', 'Error: Failed to Delete ' . ucfirst($type) . ' Entry');
        }

        redirect(admin_url("job_paper_master/manage/{$type}"));
    }
}
