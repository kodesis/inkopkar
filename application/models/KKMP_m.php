<?php defined('BASEPATH') or exit('No direct script access allowed');

class KKMP_m extends CI_Model
{
    public function get_kelurahan()
    {
        $this->db->select('*');
        $this->db->from('kelurahan');
        return $this->db->get()->result();
    }
}
