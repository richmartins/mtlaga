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

    public function add_user(){
      $this->email                  = $_POST['email'];
      $this->hash_password          = $_POST['$hash_password'];
      $this->$salt_password         = $_POST['$salt_password'];
      $this->admin                  = $_POST['admin'];
      $this->created_at             = time();
      $this->confirmed              = $_POST['confirmed'];
      $this->confirmed_at           = $_POST['confirmed_at'];
      $this->confirmend_token       = $_POST['confirmed_token'];
      $this->remember               = $_POST['remember'];
      $this->reset_password_token   = $_POST['reset_password_token'];
      $this->reset_password_sent_at = $_POST['reset_password_sent_at'];

      $this->db->insert('entries', $this);
    }

}
