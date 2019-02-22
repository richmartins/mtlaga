<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Users_model extends CI_Model {

    public $email;
    public $hash_password;
    public $salt_password;
    public $admin;
    public $created_at;
    public $confirmed;
    public $confirmed_at;
    public $confirmed_token;
    public $remember;
    public $reset_password_token;
    public $reset_password_sent_at;


    public function add_user($data){
      $length = 78;

      $this->email                  = $data['email'];
      $this->hash_password          = $data['hash_password'];
      $this->$salt_password         = $data['salted_password'];
      $this->admin                  = $data['admin'];
      $this->created_at             = date('Y-m-d');
      $this->confirmed              = $data['confirmed'];
      $this->confirmed_at           = $data['confirmed_at'];
      $this->confirmend_token       = bin2hex(random_bytes($length));
      $this->remember               = $data['remember'];
      $this->reset_password_token   = $data['reset_password_token'];
      $this->reset_password_sent_at = $data['reset_password_sent_at'];


      $this->db->insert('users', $this);
    }

    public function reset_user_pwd($email, $new_password) {
      $hashed = password_hash($new_password, PASSWORD_DEFAULT);

      $this->db->set('hash_password', $hashed);
      $this->db->where('email', $email);
      $this->db->update("users");
    }

    public function check_password($email, $password) {
      $hashed = $this->db->get_where("users", array("email" => $email))->result()[0]->email;

      if (! password_verify($password, $hashed)) {
        throw new Exception("Wrong password");
      }
    }

    public function hash_password($password, $salt){
      $hashed = password_hash($password, PASSWORD_BCRYPT, array("cost" => 22);
      return $hashed;
    }
}
