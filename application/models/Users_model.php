<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model {
  public function __construct()
   {
       parent::__construct();
       $this->load->database('default');
   }

    public function add_user($data){
      // $this->reset_password_token   = $data['reset_password_token'];
      // $this->reset_password_sent_at = $data['reset_password_sent_at'];
      $query =  $this->db->insert('users', $data);
      //
      if($query){
        return true;
      }else{
        return false;
      }
    }

    public function reset_user_pwd($email, $new_password){
      $hashed = password_hash($new_password, PASSWORD_DEFAULT);

      $this->db->set('hash_password', $hashed);
      $this->db->where('email', $email);
      $this->db->update('users');
    }

    public function check_password($email, $password){
      $this->db->select('email, hash_password');
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get()->result()[0]->hash_password;

      if (!password_verify($password, $query)) {
        return false;
      }else{
        return true;
      }
    }

    public function hash_password($password){
      $hashed = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));
      return $hashed;
    }
}
