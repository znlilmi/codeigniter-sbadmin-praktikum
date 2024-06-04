<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_Model');
        $this->load->library('form_validation'); // Load the form validation library here
    }

    public function index()
    {
        $data = array(
            'title' => 'View Data User',
            'user' => $this->User_Model->getAll(),
            'content' => 'user/index'
        );
        $this->load->view('template/main', $data);
    }

    public function add()
    {
        $data = array(
            'title' => 'Tambah Data User',
            'content' => 'user/add_form'
        );
        $this->load->view('template/main', $data);
    }

    public function save()
    {
        $this->form_validation->set_rules('nik', 'NIK', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('role', 'Role', 'required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['title'] = 'Tambah Data User';
            $data['content'] = 'user/add_form'; // Pass the 'content' key for your template
            $this->load->view('template/main', $data);
        } else {
            // Proses data form yang valid
            // Anda dapat menambahkan logika untuk menyimpan data ke database di sini
            $userData = array(
                'nik' => $this->input->post('nik'),
                'username' => $this->input->post('username'),
                'full_name' => $this->input->post('full_name'),
                'phone' => $this->input->post('phone'),
                'email' => $this->input->post('email'),
                'alamat' => $this->input->post('alamat'),
                'password' => password_hash($this->input->post('password'), PASSWORD_BCRYPT), // Encrypt the password
                'role' => $this->input->post('role')
            );

            $this->User_Model->insert($userData); // Pastikan Anda memiliki metode 'insert' di model Anda

            // Redirect ke halaman user index atau menampilkan pesan sukses
            redirect(base_url('user'));
        }
    }

    public function edit($id)
    {
        $data = array(
            'title' => 'Update Data User',
            'user' => $this->User_Model->getById($id),
            'content' => 'user/edit_form'
        );
        $this->load->view('template/main', $data);
    }

    public function update()
    {
        $this->editData();
        if ($this->db->affected_rows() > 0) {
            $this->session->set_flashdata("Success", "Data User Berhasil Diupdate");
        }
        redirect('user');
    }

    public function editData()
    {
        $id = $this->input->post('id');
        $data = array(
            'username' => htmlspecialchars($this->input->post('username'), true),
            'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
            'email' => htmlspecialchars($this->input->post('email'), true),
            'full_name' => htmlspecialchars($this->input->post('full_name'), true),
            'phone' => htmlspecialchars($this->input->post('phone'), true),
            'role' => htmlspecialchars($this->input->post('role'), true),
            'is_active' => 1,
        );
        return $this->db->set($data)->where('id', $id)->update('user');
    }

    public function delete($id)
    {
        $this->User_Model->delete($id);
        redirect('user');
    }

    public function getedit($id)
    {
        $data = array(
            'title' => 'Update Data User',
            'user' => $this->User_Model->getById($id),
            'content' => 'user/edit_form'
        );
        $this->load->view('template/main', $data);
    }
}
