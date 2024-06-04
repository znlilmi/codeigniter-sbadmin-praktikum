<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function error404()
    {
        $this->load->view('login/error404');
    }

    public function add() {
        // Logic for adding a new user
        $this->load->view('admin/user/add');
    }

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->database(); // Pastikan library database dimuat
        $this->load->library('session'); // Pastikan library session dimuat
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            // Tampilkan formulir login lagi jika validasi gagal
            $this->load->view('login/index');
        } else {
            // Proses login jika validasi berhasil
            $this->dologin();
        }
    }

    public function dologin()
    {
        $user = $this->input->post('email');
        $pswd = $this->input->post('password');
        $user = $this->db->get_where('user', ['email' => $user])->row_array(); // cari user berdasarkan email
        if($user){ // jika user terdaftar
            if (password_verify($pswd, $user['password'])) { // periksa password-nya
                $data = [
                    'id' => $user['id'],
                    'email' => $user['email'],
                    'username' => $user['username'],
                    'role' => $user['role']
                ];  
                $userid = $user['id'];
                $this->session->set_userdata($data);
                $this->_updateLastLogin($userid);
                
                // Sesuaikan peran pengguna dan redirect
                switch ($user['role']) {
                    case 'PEMILIK':
                        redirect('menu');
                        break;
                    case 'ADMIN':
                        redirect('user');
                        break;
                    case 'KASIR':
                        redirect('kasir');
                        break;
                    default:
                        redirect('login');
                        break;
                }
            } else { // jika password salah
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <b>Error :</b> Password Salah. </div>');
                redirect('/');
            }
        } else { // jika user tidak terdaftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert"> <b>Error :</b> User Tidak Terdaftar. </div>');
            redirect('/');
        }

        if ($user['role'] == 'PEMILIK') {  // periksa role-nya
            $this->_updateLastLogin($userid);
            redirect('menu');
        } else if ($user['role'] == 'ADMIN') {
            $this->_updateLastLogin($userid);
            redirect('user');
        } else if ($user['role'] == 'KASIR') {
            $this->_updateLastLogin($userid);
            redirect('kasir');
        } else {
            redirect('login');
        }
    }
    public function logout()
    {
        // hancurkan semua sesi
        $this->session->sess_destroy();
        redirect(site_url('login'));
    }

    public function block()
    {
    $data = [
        'title' => 'Access Denied!',
        'message' => 'The page you are trying to access is not available.'
    ];
    $this->load->view('errors/html/error_404', $data);
    }



    private function _updateLastLogin($userid)
    {
        $this->db->set('last_login', 'NOW()', FALSE);
        $this->db->where('id', $userid);
        $this->db->update('user');
    }
}
?>
