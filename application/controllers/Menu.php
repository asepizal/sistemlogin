<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        urlaccess();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Menu Management';
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu','Menu', 'trim|required');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header2',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('menu/menu_management',$data);
            $this->load->view('templates/footer2');
        } else {
            $this->db->insert('user_menu',['menu' => $this->input->post('menu')]);

            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
            new menu added
            </div>');
            redirect('menu'); 
        }

        
    }

    public function subMenu()
    {
        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model');
        $data['menu'] = $this->db->get('user_menu')->result_array();
        $data['submenu'] = $this->Menu_model->getSubmenu();

        $this->form_validation->set_rules('submenu','Submenu', 'trim|required');
        $this->form_validation->set_rules('menu','Menu', 'trim|required');
        $this->form_validation->set_rules('url','URL', 'trim|required');
        $this->form_validation->set_rules('icon','Icon', 'trim|required');
        $this->form_validation->set_rules('menu','Menu', 'trim|required');
        
        if($this->form_validation->run() == false){
            $this->load->view('templates/header2',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('menu/submenu',$data);
            $this->load->view('templates/footer2');
        } else {
            $data = [
                'id_menu' => $this->input->post('menu'),
                'title' => $this->input->post('submenu'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu',$data);
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
            new sub menu added
            </div>');
            redirect('menu/subMenu');
        }
    }

    public function deleteMenu($id)
    {
        $this->db->delete('user_menu',['id'=>$id]);
        $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
        menu has been deleted
        </div>');
        redirect('menu'); 
    }

}

/* End of file Menu.php */
  