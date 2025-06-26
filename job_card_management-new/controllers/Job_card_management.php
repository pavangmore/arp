<?php
// File: controllers/Job_card_management.php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_card_management extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('job_card_model');
        $this->load->model('job_card_master/job_card_master_model');
        $this->load->model('clients_model');
        $this->load->helper('pdf');
    }

    public function index()
    {
        if (!has_permission('job_card_management', '', 'view')) {
            access_denied('job_card_management');
        }

        $filters = [
            'customer' => $this->input->get('customer'),
            'status'   => $this->input->get('status'),
            'from'     => $this->input->get('from'),
            'to'       => $this->input->get('to'),
        ];

        $data['job_cards'] = $this->job_card_model->get_all($filters);
        $data['customers'] = $this->clients_model->get();
        $data['title']     = _l('Job Card Management');

        $this->load->view('admin/job_card_list', $data);
    }

    public function create()
    {
        if (!has_permission('job_card_management', '', 'create')) {
            access_denied('job_card_management');
        }

        if ($this->input->post()) {
            $post = $this->input->post();
            $post['job_card_number'] = $post['job_card_number'] ?? $this->generate_job_card_number();
            $post['date_jobcard'] = $post['date_jobcard'] ?? date('Y-m-d');
            $post['form_details'] = $this->input->post('form_details');

            $insert_id = $this->job_card_model->add($post);

            if ($insert_id) {
                set_alert('success', 'Job Card Created Successfully');
                redirect(admin_url('job_card_management'));
            } else {
                set_alert('danger', 'Insert Failed. Check logs.');
            }
        }

        $data['job_card_number'] = $this->generate_job_card_number();
        $data['date_jobcard'] = date('Y-m-d');
        $this->load_master_data($data);
        $this->load->view('admin/create_job_card', $data);
    }

    private function generate_job_card_number()
    {
        $prefix = 'JC-';
        $latest_id = $this->job_card_model->get_max_id();
        $next_id = $latest_id + 1;
        return $prefix . str_pad($next_id, 4, '0', STR_PAD_LEFT);
    }

    private function load_master_data(&$data)
    {
        $data['customers'] = $this->clients_model->get();
        $data['paper_sizes'] = $this->job_card_master_model->get_all('tbl_paper_size_master');
        $data['paper_gsm'] = $this->job_card_master_model->get_all('tbl_paper_gsm_master');
        $data['paper_type'] = $this->job_card_master_model->get_all('tbl_paper_type_master');
        $data['printing_machines'] = $this->job_card_master_model->get_all('tbl_printing_machine_master');
        $data['plate_sizes'] = $this->job_card_master_model->get_all('tbl_plate_master');
        $data['gripper'] = $this->job_card_master_model->get_all('tbl_gripper_master');
        $data['paper_master'] = $this->job_card_master_model->get_all('tbl_paper_master');
        $data['postpress_master'] = $this->job_card_master_model->get_all('tbl_postpress_master');
        $data['postpress_type'] = $this->job_card_model->get_postpress_types();
    }
    
    
    public function get_contact_by_customer($userid)
    {
    $this->db->where('userid', $userid);
    $this->db->where('is_primary', 1);
    $contact = $this->db->get(db_prefix() . 'contacts')->row();

    if ($contact) {
        echo json_encode([
            'email' => $contact->email,
            'phonenumber' => $contact->phonenumber
        ]);
    } else {
        echo json_encode([
            'email' => '',
            'phonenumber' => ''
        ]);
    }
}

    // public function get_contact_by_customer($userid)
    // {
    // $this->db->where('userid', $userid);
    // $this->db->where('is_primary', 1);
    // $contact = $this->db->get(db_prefix() . 'contacts')->row();

    // echo json_encode([
    //     'email' => $contact ? $contact->email : '',
    //     'phonenumber' => $contact ? $contact->phonenumber : ''
    // ]);
    // }


}
