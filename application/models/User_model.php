<?php

// application/models/User_Model.php
class User_Model extends CI_Model
{
    protected $_table = 'user';
    protected $primary = 'id';

    public function getAll()
    {
        return $this->db->where('is_active', 1)->get($this->_table)->result();
    }
    public function getById($id)
    {
        return $this->db->get_where($this->_table, ["id" => $id])->row();
    }
    public function delete($id)
    {
        $this->User_Model->delete($id);
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("Success", "Data User Berhasil Dihapus");
        }
        redirect('user');
    }
}
