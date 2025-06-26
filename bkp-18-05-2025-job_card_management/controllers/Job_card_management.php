<?php
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

            $post['form_details'] = $this->prepare_form_details($post);

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

    public function edit($id)
    {
        if (!has_permission('job_card_management', '', 'edit')) {
            access_denied('job_card_management');
        }

        $data['job_card'] = $this->job_card_model->get($id);
        if (!$data['job_card']) {
            show_404();
        }

        if ($this->input->post()) {
            $post = $this->input->post();
            $post['form_details'] = $this->prepare_form_details($post);

            $this->job_card_model->update($id, $post);
            set_alert('success', 'Job Card Updated Successfully');
            redirect(admin_url('job_card_management'));
        }

        $this->load_master_data($data);
        $this->load->view('admin/edit_job_card', $data);
    }

    public function delete($id)
    {
        if (!has_permission('job_card_management', '', 'delete')) {
            access_denied('job_card_management');
        }

        $this->job_card_model->delete($id);
        set_alert('success', 'Job Card Deleted Successfully');
        redirect(admin_url('job_card_management'));
    }

    public function bulk_action()
    {
        if (!has_permission('job_card_management', '', 'edit')) {
            access_denied('job_card_management');
        }

        $action = $this->input->post('bulk_action');
        $ids = $this->input->post('selected_ids');

        if (!$ids || !$action) {
            set_alert('warning', 'No records selected or action specified.');
            redirect(admin_url('job_card_management'));
        }

        foreach ($ids as $id) {
            if ($action == 'delete') {
                $this->job_card_model->delete($id);
            } else {
                $this->job_card_model->update($id, ['job_status' => $action]);
            }
        }

        set_alert('success', 'Bulk action applied successfully.');
        redirect(admin_url('job_card_management'));
    }

    public function export_csv()
    {
        if (!has_permission('job_card_management', '', 'view')) {
            access_denied('job_card_management');
        }

        $this->load->dbutil();
        $this->load->helper('download');

        $query = $this->db->get($this->job_card_model->table);
        $csv = $this->dbutil->csv_from_result($query);

        force_download('job_cards_' . date('Ymd_His') . '.csv', $csv);
    }

    public function export_pdf($id)
    {
        if (!has_permission('job_card_management', '', 'view')) {
            access_denied('job_card_management');
        }

        $job_card = $this->job_card_model->get($id);
        if (!$job_card) {
            show_404();
        }

        $form_details = json_decode($job_card['form_details'], true);

        $pdf = new TCPDF();
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Perfex CRM');
        $pdf->SetTitle('Job Card PDF');
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();

        $html = $this->load->view('admin/view_job_card_pdf', [
            'job_card' => $job_card,
            'form_details' => $form_details
        ], true);

        $pdf->writeHTML($html);
        ob_end_clean(); // Clean previous output if any

        $pdf->Output('Job_Card_' . $job_card['job_card_number'] . '.pdf', 'I');
    }

    public function reports()
    {
        if (!has_permission('job_card_management', '', 'view')) {
            access_denied('job_card_management');
        }

        $data['title']      = 'Job Card Reports';
        $data['total']      = $this->job_card_model->count_all();
        $data['pending']    = $this->job_card_model->count_by_status('Pending');
        $data['inprogress'] = $this->job_card_model->count_by_status('In Progress');
        $data['completed']  = $this->job_card_model->count_by_status('Completed');

        $this->load->view('admin/job_card_reports', $data);
    }

    // Private helpers

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

    private function prepare_form_details($post)
    {
        $details = ['machine_print_rows' => [], 'postpress_rows' => []];

        if (!empty($post['form_name'])) {
            foreach ($post['form_name'] as $i => $val) {
                $details['machine_print_rows'][] = [
                    'form_name' => $val,
                    'printing_machine' => $post['printing_machine'][$i] ?? '',
                    'plate_size' => $post['plate_size'][$i] ?? '',
                    'set_qty' => $post['set_qty'][$i] ?? '',
                    'used_plate_qty' => $post['used_plate_qty'][$i] ?? '',
                    'paper_master' => $post['paper_master'][$i] ?? '',
                    'paper_buy' => $post['paper_buy'][$i] ?? [],
                    'used_paper_qty' => $post['master_paper_qty'][$i] ?? '',
                    'cut_size' => $post['paper_cut_size'][$i] ?? '',
                    'print_qty' => $post['printing_qty'][$i] ?? '',
                    'gripper' => $post['gripper'][$i] ?? '',
                    'color' => $post['color'][$i] ?? ''
                ];
            }
        }

        if (!empty($post['postpress_process'])) {
            foreach ($post['postpress_process'] as $i => $val) {
                $details['postpress_rows'][] = [
                    'postpress_process' => $val,
                    'process_type' => $post['process_type'][$i] ?? '',
                    'size' => $post['paper_size'][$i] ?? ''
                ];
            }
        }

        return json_encode($details);
    }
}
?>
