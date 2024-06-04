<?php
function infologin(){
    $ci = get_instance();
    if($ci->session->userdata('username')) {
        return $ci->db->get_where('tb_user', ['username' => $ci->session->userdata('username')])->row_array();
    } else {
        return NULL; // or return an empty array
    }
}

function cek_login(){
    $ci = get_instance();
    if(!$ci->session->userdata('username') && current_url() != site_url('login')) {
        redirect('login'); // Redirect to login page if not logged in
    }
}

function cek_user(){
    $ci = get_instance();
    $user = infologin(); // Reuse the infologin() function
    if($user && $user['role'] != 'admin') {
        redirect('login/block'); // Redirect to blocked page if user is not an admin
    }
}