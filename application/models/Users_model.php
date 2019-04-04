<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model {
  public function __construct(){
       parent::__construct();
       $this->load->database('default');
   }

    public function add_user($data){
      $query =  $this->db->insert('users', $data);
      if($query) { return true; } else { return false; }
    }

    public function update_password($email, $new_password){
      $hashed = password_hash($new_password, PASSWORD_DEFAULT, array('cost' => 10));
      $this->db->set('hash_password', $hashed);
      $this->db->set('reset');
      $this->db->where('email', $email);
      $sucess = $this->db->update('users');

      if ($sucess) { return true; } else { return false; }
    }

    public function check_password($email, $password){
      $this->db->select('email, hash_password');
      $this->db->from('users');
      $this->db->where('email', $email);

      $query = $this->db->get()->result()[0]->hash_password;
      if(!password_verify($password, $query)) { return false; } else { return true; }
    }

    public function hash_password($password){
      $hashed = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));
      return $hashed;
    }

    public function get_token($email){
      $this->db->select('confirmation_token');
      $this->db->from('users');
      $this->db->where('email', $email);
      $res = $this->db->get()->result()[0]->confirmation_token;
      return $res;
    }

    public function check_email($email){
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get();
      if ($query->num_rows() >= 1){ return true; } else { return false; }
    }
}
