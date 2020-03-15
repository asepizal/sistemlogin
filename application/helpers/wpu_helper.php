<?php

function urlaccess(){
    
    $ci =& get_instance();
    
    if(!$ci->session->userdata('email')){
        redirect('auth');
    }else{
        $id_role = $ci->session->userdata('id_role');
        $uri = $ci->uri->segment(1);
        $queryMenu = $ci->db->get_where('user_menu',['menu'=>$uri])->row_array();
       
        $id_menu = $queryMenu['id'];
        $result = $ci->db->get_where('user_access_menu',[
            'id_role' => $id_role,
            'id_menu' => $id_menu
        ]);

        if($result->num_rows() < 1){
            redirect('auth/blocked');
        }

    }
}



function check_access($id_role,$id_menu){

$ci =& get_instance();

$result = $ci->db->get_where('user_access_menu',[
    'id_role' => $id_role,
    'id_menu' => $id_menu
]);

if($result->num_rows() > 0){
    return "checked='checked'";
}

}