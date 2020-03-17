<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        urlaccess();
    }

    public function index()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'My Profile';

        $this->load->view('templates/header2',$data);
        $this->load->view('templates/sidebar',$data);
        $this->load->view('templates/topbar',$data);
        $this->load->view('user/profile',$data);
        $this->load->view('templates/footer2');
    }

    public function edit()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Edit Profile';

        $this->form_validation->set_rules('name', 'Full name', 'trim|required');
        
        if($this->form_validation->run() == false){
            $this->load->view('templates/header2',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('user/edit',$data);
            $this->load->view('templates/footer2');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // cek jikaada gambar yg diupload
            $upload_image = $_FILES['image'];

            if($upload_image){
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload',$config);

                if($this->upload->do_upload('image')){
                    $old_image = $data['user']['image'];

                    if($old_image != 'default.jpg'){
                        unlink(FCPATH . 'assets/img/profile/'. $old_image );
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image',$new_image);
                } else {
                    echo $this->upload->display_errors();
                }

            }
            
            $this->db->set('name',$name);
            $this->db->where('email',$email);
            $this->db->update('user');

            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
            Profile updated !
            </div>');
            redirect('user');

        }

    }

    public function changePassword()
    {
        $data['user'] = $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Change Password';

        $this->form_validation->set_rules('currentPassword','Current Password','trim|required');
        $this->form_validation->set_rules('newPassword','New Password','trim|required|min_length[3]');
        $this->form_validation->set_rules('confPassword','Confirmation Password','trim|required|matches[newPassword]');

        if($this->form_validation->run() == false){
            $this->load->view('templates/header2',$data);
            $this->load->view('templates/sidebar',$data);
            $this->load->view('templates/topbar',$data);
            $this->load->view('user/changePassword',$data);
            $this->load->view('templates/footer2');
        } else {
            $current_password = $this->input->post('currentPassword');
            $new_password = $this->input->post('newPassword');
            if(!password_verify($current_password,$data['user']['password'])){
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
                Wrong Current Password !
                </div>');
                redirect('user/changePassword');
            } else{
                if($current_password == $new_password){
                    $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
                    Password is the same old password , please change
                    </div>');
                    redirect('user/changePassword');
                } else{
                    $password_hash = password_hash($new_password,PASSWORD_DEFAULT);

                    $this->db->set('password',$password_hash);
                    $this->db->where('email',$this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('notif','<div class="alert alert-succes" role="alert">
                    Password changed!
                    </div>');
                    redirect('user/changePassword');
                }
            }
        }
    }



}

/* End of file Controllername.php */
