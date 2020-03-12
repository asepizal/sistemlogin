<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function index()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();

        $data['title'] = 'Dashboard';

        $this->load->view('templates/header2',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('dashboard/user',$data);
        $this->load->view('templates/footer2');
    }

}

/* End of file Controllername.php */
