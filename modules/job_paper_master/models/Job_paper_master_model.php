<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Job_paper_master_model extends App_Model {
    public function __construct() {
        parent::__construct();
    }

    public function get_all($table) {
        return $this->db->get($table)->result_array();
    }

   public function insert($table, $data) {
    $columns = $this->db->list_fields($table); // Get valid columns
    $filtered_data = array_intersect_key($data, array_flip($columns)); // Filter only valid fields

    if (!empty($filtered_data)) {
        $this->db->set($filtered_data); // Ensure set() is used
        if ($this->db->insert($table)) {
            log_message('error', 'Inserted Successfully: ' . json_encode($filtered_data));
            return true;
        } else {
            log_message('error', 'Insert Failed: ' . $this->db->error()['message']);
        }
    }
    return false;
}

public function update($table, $id, $data) {
    $columns = $this->db->list_fields($table); // Get valid columns
    $filtered_data = array_intersect_key($data, array_flip($columns)); // Filter valid fields

    if (!empty($filtered_data)) {
        $this->db->where('id', $id);
        if ($this->db->update($table, $filtered_data)) {
            log_message('error', 'Updated Successfully: ' . json_encode($filtered_data));
            return true;
        } else {
            log_message('error', 'Update Failed: ' . $this->db->error()['message']);
        }
    }
    return false;
}

public function delete($table, $id) {
    if ($this->db->where('id', $id)->delete($table)) {
        log_message('error', 'Deleted Successfully: ID ' . $id);
        return true;
    } else {
        log_message('error', 'Delete Failed: ' . $this->db->error()['message']);
        return false;
    }
}




    public function get_by_id($table, $id) {
        return $this->db->where('id', $id)->get($table)->row_array();
    }






    
}
