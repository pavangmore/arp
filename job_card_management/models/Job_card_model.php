<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Job_cards_model extends App_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get($id)
    {
        $this->db->select(db_prefix().'job_cards.*,'.db_prefix().'clients.company as client_name');
        $this->db->join(db_prefix().'clients', db_prefix().'clients.userid='.db_prefix().'job_cards.client_id');
        return $this->db->where(db_prefix().'job_cards.id', $id)->get(db_prefix().'job_cards')->row();
    }

    public function get_all()
    {
        $this->db->select(db_prefix().'job_cards.*,'.db_prefix().'clients.company as client_name');
        $this->db->join(db_prefix().'clients', db_prefix().'clients.userid='.db_prefix().'job_cards.client_id');
        return $this->db->order_by(db_prefix().'job_cards.date_in', 'DESC')->get(db_prefix().'job_cards')->result_array();
    }

    public function get_client_cards($client_id)
    {
        return $this->db->where('client_id', $client_id)
                       ->order_by('date_in', 'DESC')
                       ->get(db_prefix().'job_cards')
                       ->result_array();
    }

    public function add($data)
    {
        $data['date_in'] = date('Y-m-d H:i:s');
        $data['created_by'] = get_staff_user_id();
        $this->db->insert(db_prefix().'job_cards', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update(db_prefix().'job_cards', $data);
        return $this->db->affected_rows() > 0;
    }

    public function delete($id)
    {
        $this->db->where('id', $id);
        $this->db->delete(db_prefix().'job_cards');
        return $this->db->affected_rows() > 0;
    }
}
