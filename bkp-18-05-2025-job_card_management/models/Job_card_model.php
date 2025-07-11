<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_card_model extends App_Model
{
    protected $table;

    public function __construct()
    {
        parent::__construct();
        $this->table = db_prefix() . 'jobcard';
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

    public function get($id)
    {
        $this->db->where('id', $id);
        return $this->db->get($this->table)->row_array();
    }

    public function add($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete($this->table);
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function count_by_status($status)
    {
        $this->db->where('job_status', $status);
        return $this->db->count_all_results($this->table);
    }

    public function get_max_id()
    {
        $this->db->select_max('id');
        $result = $this->db->get($this->table)->row();
        return $result ? $result->id : 0;
    }

    public function get_postpress_types()
    {
        return $this->db->get(db_prefix() . 'postpress_type_master')->result_array();
    }
}
