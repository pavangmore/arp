<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_card_model extends App_Model {
    protected $table; // Declare table property

    public function __construct() {
        parent::__construct();
        $this->table = db_prefix() . 'jobcard'; // Set table name
    }

    // public function get_all() {
    //     return $this->db->get($this->table)->result_array();
    // }

    public function get($id) {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array(); // Return single row
    }
    
    
    public function get_max_id()
    {
    $this->db->select_max('id');
    $result = $this->db->get($this->table)->row();
    return $result->id ?? 0;
    }


    // public function add($data) {
    //     $this->db->insert($this->table, $data);
    //     return $this->db->insert_id();
    // }
    
    
public function add($data) {
    $valid_columns = $this->db->list_fields($this->table);

    $filtered = array_filter($data, function ($key) use ($valid_columns) {
        return in_array($key, $valid_columns);
    }, ARRAY_FILTER_USE_KEY);

    if ($this->db->insert($this->table, $filtered)) {
        return $this->db->insert_id();
    }

    log_message('error', 'Insert Error: ' . print_r($this->db->error(), true));
    return false;
}
 ////


    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id) {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }
    public function count_all()
    {
    return $this->db->count_all_results($this->table);
    }

    public function count_by_status($status)
    {
    return $this->db->where('job_status', $status)->count_all_results($this->table);
    }
    
       public function get_postpress_types()
    {
        $this->db->distinct();
        $this->db->select('process_type');
        return $this->db->get('tbl_postpress_master')->result_array();
    }



    public function get_all($filters = [])
    {
        if (!empty($filters['customer'])) {
            $this->db->where('customer_name', $filters['customer']);
        }
        if (!empty($filters['status'])) {
            $this->db->where('job_status', $filters['status']);
        }
        if (!empty($filters['from'])) {
            $this->db->where('date_jobcard >=', $filters['from']);
        }
        if (!empty($filters['to'])) {
            $this->db->where('date_jobcard <=', $filters['to']);
        }
    
        return $this->db->get($this->table)->result_array();
    }



}
