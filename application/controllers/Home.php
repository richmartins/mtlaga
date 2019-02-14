<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
        $this->load->database();
        $query = $this->db->query("SELECT * FROM users;");
        
        $user_1 = [];
        $user_2 = [];
        
        $row_1 = $query->row();
        $row_2 = $query->row(1);
        
        if (isset($row_1)){
          $user_1['id_user'] = $row_1->id_user;
          $user_1['email'] = $row_1->email;
          $user_1['salt_password'] =$row_1->salt_password;
          $user_1['admin'] = $row_1->admin;
          $user_1['confirmed'] = $row_1->confirmed;
        }

        if (isset($row_2)){
          $user_2['id_user'] = $row_2->id_user;
          $user_2['email'] = $row_2->email;
          $user_2['salt_password'] = $row_2->salt_password;
          $user_2['admin'] = $row_2->admin;
          $user_2['confirmed'] = $row_2->confirmed;
        }

        $data = array(
          'title' => 'Home | MTLAGA',
          'content' => $user_2
        );

        $this->load->helper('url');
        $this->load->view('templates/view_template', $data);
    }
}
