<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        // set rule
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');
        
        if( $this->form_validation->run() == FALSE )
        {
            $data['title'] = 'Login';
            
            $this->load->view('templates/header',$data);
            $this->load->view('auth/login',$data);
            $this->load->view('templates/footer',$data);

        } else {
            $this->_login();
        }
        
    }
    
    private function _login()
    {
        // inputan user
        $email = $this->input->post('email',true);
        $password =$this->input->post('password',true);
    
        $user = $this->db->get_where('user',['email'=>$email])->row_array();
        
        //usernya ad
        if($user){
            if($user['is_active'] == 1){
                if(password_verify($password,$user['password'])){
                    $data = [
                        'email' => $user['email'],
                        'id_role' => $user['id_role'] 
                    ];
                    // jika login berhasil
                    $this->session->set_userdata($data);
                    redirect('user');
                } else {
                    $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
                    Wrong Password !
                    </div>');
                    redirect('auth'); 
                }
            } else {
                $this->session->set_flashdata('notif','<div class="alert alert-warning" role="alert">
                Email not active !
                </div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
            Email not registered !
            </div>');
            redirect('auth');
        }
        
    }    

    public function registration()
    {

        // set rule
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|is_unique[user.email]',
            ['is_unique'=>'This email has been registered']
        );
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[4]|matches[password2]',
            ['min_length'=>'Password too short']
        );
        $this->form_validation->set_rules('password2', 'Confirmation password', 'required|trim|matches[password1]');

        if( $this->form_validation->run() == false ) {
            
            $data['title'] = 'Registration';
            $this->load->view('templates/header',$data);
            $this->load->view('auth/registration',$data);
            $this->load->view('templates/footer',$data);

        } else {
            $data = [
                'name'         => $this->input->post('name',true),
                'email'        => $this->input->post('email',true),
                'image'        => 'default.jpg',
                'password'     => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
                'id_role'      => 2,
                'is_active'    => 1,
                'date_created' => time()
            ];
            
            $this->db->insert('user',$data);
            $this->session->set_flashdata('notif','<div class="alert alert-primary" role="alert">
            Succes, your account has been registered!
            </div>');
            redirect('auth');
        }            
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('id_role');

        $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
        Succes, your account has been logout!
        </div>');
        redirect('auth');
    }

}

/* End of file Controllername.php */
