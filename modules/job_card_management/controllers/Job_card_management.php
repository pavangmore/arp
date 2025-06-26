<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


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


        //dashboard
         
    $this->load->model('job_card_model');

    $data['title']      = 'Job Card Reports';
    $data['total']      = $this->job_card_model->count_all();
    $data['pending']    = $this->job_card_model->count_by_status('Pending');
    $data['inprogress'] = $this->job_card_model->count_by_status('In Progress');
    $data['completed']  = $this->job_card_model->count_by_status('Completed');

    // $this->load->view('admin/job_card_reports', $data);
        
        //



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
            $data = $this->input->post();

            $data['job_card_number'] = $data['job_card_number'] ?? $this->generate_job_card_number();
            $data['date_jobcard'] = $data['date_jobcard'] ?? date('Y-m-d');

            // Convert form details to JSON
            $form_details = [
                'machine_print_rows' => [],
                'postpress_rows' => []
            ];

            foreach ($data['form_name'] as $i => $val) {
                $form_details['machine_print_rows'][] = [
                    'form_name' => $data['form_name'][$i],
                    'printing_machine' => $data['printing_machine'][$i],
                    'plate_size' => $data['plate_size'][$i],
                    'set_qty' => $data['set_qty'][$i],
                    'used_plate_qty' => $data['used_plate_qty'][$i],
                    'paper_master' => $data['paper_master'][$i],
                    'paper_buy' => $data['paper_buy'][$i] ?? [],
                    'used_paper_qty' => $data['master_paper_qty'][$i],
                    'cut_size' => $data['paper_cut_size'][$i],
                    'print_qty' => $data['printing_qty'][$i],
                    'gripper' => $data['gripper'][$i],
                    'color' => $data['color'][$i]
                ];
            }

            foreach ($data['postpress_process'] as $i => $val) {
                $form_details['postpress_rows'][] = [
                    'postpress_process' => $data['postpress_process'][$i],
                    'process_type' => $data['process_type'][$i],
                    'size' => $data['paper_size'][$i]
                ];
            }

            $data['form_details'] = json_encode($form_details);

            unset(
                $data['form_name'], $data['printing_machine'], $data['plate_size'], $data['set_qty'],
                $data['used_plate_qty'], $data['paper_master'], $data['paper_buy'], $data['master_paper_qty'],
                $data['paper_cut_size'], $data['printing_qty'], $data['gripper'], $data['color'],
                $data['postpress_process'], $data['process_type'], $data['paper_size']
            );

            $insert_id = $this->job_card_model->add($data);

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
        
        
        $data['customers'] = $this->clients_model->get(); // or similar

        $data['printing_machines'] = $this->job_card_master_model->get_all('tbl_printing_machine_master');
        $data['plate_sizes'] = $this->job_card_master_model->get_all('tbl_plate_master');
        $data['paper_master'] = $this->job_card_master_model->get_all('tbl_paper_master');
        $data['gripper'] = $this->job_card_master_model->get_all('tbl_gripper_master');
        $data['postpress_machines'] = $this->job_card_master_model->get_all('tbl_postpress_master');
        $data['postpress_type'] = $this->job_card_model->get_postpress_types();

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
            $update_data = $this->input->post();

            $form_details = [
                'machine_print_rows' => [],
                'postpress_rows' => []
            ];

            foreach ($update_data['form_name'] as $i => $val) {
                $form_details['machine_print_rows'][] = [
                    'form_name' => $update_data['form_name'][$i],
                    'printing_machine' => $update_data['printing_machine'][$i],
                    'plate_size' => $update_data['plate_size'][$i],
                    'set_qty' => $update_data['set_qty'][$i],
                    'used_plate_qty' => $update_data['used_plate_qty'][$i],
                    'paper_master' => $update_data['paper_master'][$i],
                    'paper_buy' => $update_data['paper_buy'][$i] ?? [],
                    'used_paper_qty' => $update_data['master_paper_qty'][$i],
                    'cut_size' => $update_data['paper_cut_size'][$i],
                    'print_qty' => $update_data['printing_qty'][$i],
                    'gripper' => $update_data['gripper'][$i],
                    'color' => $update_data['color'][$i]
                ];
            }

            foreach ($update_data['postpress_process'] as $i => $val) {
                $form_details['postpress_rows'][] = [
                    'postpress_process' => $update_data['postpress_process'][$i],
                    'process_type' => $update_data['process_type'][$i],
                    'size' => $update_data['paper_size'][$i]
                ];
            }

            $update_data['form_details'] = json_encode($form_details);

            unset(
                $update_data['form_name'], $update_data['printing_machine'], $update_data['plate_size'],
                $update_data['set_qty'], $update_data['used_plate_qty'], $update_data['paper_master'],
                $update_data['paper_buy'], $update_data['master_paper_qty'], $update_data['paper_cut_size'],
                $update_data['printing_qty'], $update_data['gripper'], $update_data['color'],
                $update_data['postpress_process'], $update_data['process_type'], $update_data['paper_size']
            );

            $this->job_card_model->update($id, $update_data);
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
        $data['paper_sizes'] = $this->job_card_master_model->get_all("tbl_paper_size_master");
        $data['paper_gsm'] = $this->job_card_master_model->get_all("tbl_paper_gsm_master");
        $data['paper_type'] = $this->job_card_master_model->get_all("tbl_paper_type_master");
        $data['printing_machines'] = $this->job_card_master_model->get_all("tbl_printing_machine_master");
        $data['plate_sizes'] = $this->job_card_master_model->get_all("tbl_plate_master");
        $data['gripper'] = $this->job_card_master_model->get_all("tbl_gripper_master");
        $data['postpress_machines'] = $this->job_card_master_model->get_all("tbl_postpress_machine_master");
        $data['paper_master'] = $this->job_card_master_model->get_all("tbl_paper_master");
        $data['postpress_machines'] = $this->job_card_master_model->get_all("tbl_postpress_master");
        $data['postpress_master'] = $this->job_card_master_model->get_all("tbl_postpress_master");
        $data['postpress_type'] = $this->job_card_model->get_postpress_types();
    }
    
    
public function export_pdf($id)
{
    if (!has_permission('job_card_management', '', 'view')) {
        access_denied('job_card_management');
    }
    

    $this->load->model('job_card_model');
    $this->load->helper('pdf');

    ob_start(); // ✅ Start output buffering

    $job_card = $this->job_card_model->get($id);
    if (!$job_card) {
        show_404();
    }

    $form_details = json_decode($job_card['form_details'], true);

    $data = [
        'job_card'     => $job_card,
        'form_details' => $form_details
    ];

    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Perfex CRM');
    $pdf->SetTitle('Job Card PDF');
    $pdf->SetMargins(10, 10, 10);
    $pdf->AddPage();

    $html = $this->load->view('admin/view_job_card_pdf', $data, true);
    $pdf->writeHTML($html);

    ob_end_clean(); // ✅ Clean any previous output
if (headers_sent($file, $line)) {
    echo "⚠ Output started at $file on line $line";
    exit;
}


    $pdf->Output('Job_Card_' . $job_card['job_card_number'] . '.pdf', 'I');
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
    
        $query = $this->db->get($this->job_card_model->table); // or use get_all()
        $csv = $this->dbutil->csv_from_result($query);
    
        force_download('job_cards_export_' . date('Ymd_His') . '.csv', $csv);
    }
    
    
    public function reports()
    {
        if (!has_permission('job_card_management', '', 'view')) {
            access_denied('job_card_management');
        }
    
        $this->load->model('job_card_model');
    
        $data['title']      = 'Job Card Reports';
        $data['total']      = $this->job_card_model->count_all();
        $data['pending']    = $this->job_card_model->count_by_status('Pending');
        $data['inprogress'] = $this->job_card_model->count_by_status('In Progress');
        $data['completed']  = $this->job_card_model->count_by_status('Completed');
    
        $this->load->view('admin/job_card_reports', $data);
    }








}
