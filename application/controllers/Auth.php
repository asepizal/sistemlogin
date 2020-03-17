<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    
    public function index()
    {
        if($this->session->userdata('email')){
            redirect('user');
        }
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
                    
                    if($this->session->userdata('id_role') == 1){
                        $this->session->set_userdata($data);
                        redirect('admin');
                    } else {
                        $this->session->set_userdata($data);
                        redirect('user');
                    }    
                        
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
        if($this->session->userdata('email')){
            redirect('user');
        }
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
            $email = $this->input->post('email',true);
            $data = [
                'name'         => $this->input->post('name',true),
                'email'        => $email,
                'image'        => 'default.jpg',
                'password'     => password_hash($this->input->post('password1'),PASSWORD_DEFAULT),
                'id_role'      => 2,
                'is_active'    => 0,
                'date_created' => time()
            ];

            // siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time() 
            ];

            $this->db->insert('user_token',$user_token);
            $this->db->insert('user',$data);

            $this->_sendEmail($token,'verify');

            $this->session->set_flashdata('notif','<div class="alert alert-primary" role="alert">
            Succes, your account has been registered!
            </div>');
            redirect('auth');
        }            
    }
    
    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'asepr2402@gmail.com',
            'smtp_pass' => 'asepizal24',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];
        $this->email->initialize($config);

        $this->load->library('email',$config);

        $this->email->from('asepr2402@gmail.com', 'Asep Rizal');
        $this->email->to($this->input->post('email'));
        if($type == 'verify'){
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="'.base_url().'auth/verify?email='. $this->input->post('email') .'&token='.urlencode($token).'">Activate</a> ');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="'.base_url().'auth/resetPassword?email='. $this->input->post('email') .'&token='.urlencode($token).'">Reset Your Password</a> ');
        }

        if($this->email->send()){
            return true;
        } else {
            echo $this->email->print_debugger();
        }
    }

    public function verify(){
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user',['email' => $email]);

        if($user){
            $user_token = $this->db->get_where('user_token', ['token',$token]);

            if($user_token){
                $this->db->set('is_active','1');
                $this->db->where('email',$email);
                $this->db->update('user');

                $this->db->delete('user_token',['email'=>$email]);

                $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
                Activation success ! please login
                </div>');
                redirect('auth'); 
            } else {
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
                Activation failed !(wrong token)
                </div>');
                redirect('auth'); 
            }
        } else {
            $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
            Activation failed !(wrong email)
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

    public function blocked(){
        echo "access forbidden";
    }

    public function forgotPassword(){
        
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        
        if ($this->form_validation->run() == false){
            $data['title'] = 'Forgot Password';
            
            $this->load->view('templates/header',$data);
            $this->load->view('auth/forgotPassword',$data);
            $this->load->view('templates/footer',$data); 
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user',['email' => $email,'is_active'=>1])->row_array();
            
            if($user){
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token',$user_token);
                $this->_sendEmail($token,'forgot');

                $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
                Please check your email to reset Password !
                </div>');
                redirect('auth/forgotPassword');

            } else {
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
                your email not registered/activated !  
                </div>');
                redirect('auth/forgotPassword');
            }

        }
        
    }

    public function resetPassword()
    {
        $token = $this->input->get('token');
        $email = $this->input->get('email');

        $user = $this->db->get_where('user',['email'=>$email])->row_array();

        if($user){
            $user_token = $this->db->get_where('user_token',['token'=>$token])->row_array();

            if($user_token){
                $this->session->set_userdata('reset_email',$email);
                $this->changePassword();
            }else{
                $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
                Reset Password Failes ! wrong token
                </div>');
                redirect('auth');
            }

        } else {
            $this->session->set_flashdata('notif','<div class="alert alert-danger" role="alert">
            Reset Password Failes ! wrong email
            </div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if(!$this->session->userdata('reset_email')){
            redirect('auth');
        }

        $this->form_validation->set_rules('newPassword', 'New Password', 'trim|required|matches[confPassword]');
        $this->form_validation->set_rules('confPassword', 'Confirmation Password', 'trim|required|matches[newPassword]');
        
        if($this->form_validation->run() == false){
            $data['title'] = 'Change Password';
            
            $this->load->view('templates/header',$data);
            $this->load->view('auth/changePassword',$data);
            $this->load->view('templates/footer',$data);
        } else {
            $newPassword = password_hash($this->input->post('newPassword'),PASSWORD_DEFAULT);

            $email=$this->session->userdata('reset_email');

            $this->db->set('password',$newPassword);
            $this->db->where('email',$email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('notif','<div class="alert alert-success" role="alert">
            Reset Password success !
            </div>');
            redirect('auth');
        }         
    }

}

/* End of file Controllername.php */
