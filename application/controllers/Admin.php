<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    
    public function __construct()
    {
        parent::__construct();
        urlaccess();
    }
    
    public function index()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Dashboard';

        $this->load->view('templates/header2',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('admin/dashboard',$data);
        $this->load->view('templates/footer2');
    }

    public function role()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role';
        $data['role'] = $this->db->get('user_role')->result_array();

        $this->load->view('templates/header2',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('admin/role',$data);
        $this->load->view('templates/footer2');
    }

    public function roleAccess($id_role)
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Role';
        $data['role'] = $this->db->get_where('user_role',['id'=>$id_role])->row_array();
        // $this->db->where()
        $data['menu'] = $this->db->get_where('user_menu',['id !=' => 1])->result_array();

        $this->load->view('templates/header2',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('admin/role_access',$data);
        $this->load->view('templates/footer2');
    }  
    
    public function changeaccess()
    {
        $id_role = $this->input->post('id_role');
        $id_menu = $this->input->post('id_menu');

        $data = [
            'id_role' => $id_role,
            'id_menu' => $id_menu
        ];

        $result = $this->db->get_where('user_access_menu',$data);

        if($result->num_rows() < 1){
            $this->db->insert('user_access_menu',$data);
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
            access changed !
            </div>');
        } else {
            $this->db->delete('user_access_menu',$data);
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
            access changed !
            </div>');
        }
    }
}

/* End of file Controllername.php */