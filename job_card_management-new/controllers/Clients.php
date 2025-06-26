public function get_contact_by_customer($userid)
{
    $this->db->where('userid', $userid);
    $this->db->where('is_primary', 1);
    $contact = $this->db->get(db_prefix() . 'contacts')->row();

    echo json_encode([
        'email' => $contact ? $contact->email : '',
        'phonenumber' => $contact ? $contact->phonenumber : ''
    ]);
}
