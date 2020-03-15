<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_model extends CI_Model {

    public function getSubmenu()
    {
        $query = "SELECT `user_sub_menu`.*,`user_menu`.`menu`
                  FROM `user_sub_menu` JOIN `user_menu`
                  ON `user_sub_menu`.`id_menu` = `user_menu`.`id`  
                ";
        return $this->db->query($query)->result_array();     
    }

}

/* End of file Menu_model.php */

