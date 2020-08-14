<?php
class LoginModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function login($NICK, $PASS)
    {
        $this->db->select('*');
        $this->db->from('Usuario');
        $this->db->where('USUARIO', $NICK);
        $this->db->where('CONTRASENIA', md5($PASS));
        $this->db->limit(1);

        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result(); 
        } else {
            return false; 
        }
    }
}
