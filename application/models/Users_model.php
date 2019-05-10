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

    public function get_user_id($email) {
      $this->db->select('id_user', 'email');
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get()->result();

      return $query[0]->id_user;
    }

    public function update_password($email, $new_password){
      $hashed = password_hash($new_password, PASSWORD_DEFAULT, array('cost' => 10));
      $this->db->set('hash_password', $hashed);
      $this->db->where('email', $email);
      $this->db->update('users');
      if ($this->db->affected_rows() > 0) { return true; } else { return false; }
    }

    public function check_password($email, $password){
      $error = 'L\'adresse mail ou le mot de passe saisi est incorrect';
      $this->db->select('email, hash_password');
      $this->db->from('users');
      $this->db->where('email', $email);

      $query = $this->db->get()->result()[0]->hash_password;
      if(!password_verify($password, $query)) { return $error; } else { return true; }
    }

    public function hash_password($password){
      $hashed = password_hash($password, PASSWORD_DEFAULT, array("cost" => 10));
      return $hashed;
    }

    public function get_token_reset($email){
      $token = bin2hex(random_bytes(20));
      $this->db->set('reset_password_token', $token);
      $this->db->where('email', $email);
      $this->db->update('users');
      if($this->db->affected_rows() > 0){
        $this->db->select('reset_password_token');
        $this->db->from('users');
        $this->db->where('email', $email);
        $res = $this->db->get()->result()[0]->reset_password_token;
        return $res;
      }
    }

    public function check_email($email){
      $error = 'L\'adresse mail ou le mot de passe saisi est incorect';
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get();
      if ($query->num_rows() >= 1){ return true; } else { return $error; }
    }

    public function exists_email($email){
      $error = 'Cette addresse existe déjà';
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get();
      if ($query->num_rows() >= 1){ return $error; } else { return true; }
    }

    public function check_token($token, $email){
      $this->db->select('reset_password_token', 'email');
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get();
      if ($query->num_rows() >= 1){ return true; } else { return false; }
    }

    public function check_token_confirm($token, $email){
      $check = array('email' => $email, 'confirmation_token' => $token);
      $this->db->select('confirmation_token', 'email');
      $this->db->from('users');
      $this->db->where($check);
      $query = $this->db->get();
      if ($query->num_rows() >= 1){ return true; } else { return false; }
    }

    public function confirmed($email){
      $this->db->set('confirmed', 1);
      $this->db->set('confirmed_at', date('Y-m-d'));
      $this->db->where('email', $email);
      $this->db->update('users');
      if($this->db->affected_rows() > 0){
        return true;
      } else {
        return false;
      }
    }

    public function confirmed_login($email){
      $info = 'Veuillez d\'abord confirmer votre adresse avant de vous connecter';
      $this->db->select('confirmed', 'email');
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get();
      if($query->result()[0]->confirmed == 1){
        return true;
      } else {
        return $info;
      }
    }

    public function get_confirm_token($email){
      $this->db->select('confirmation_token', 'email');
      $this->db->from('users');
      $this->db->where('email', $email);
      $query = $this->db->get()->result()[0]->confirmation_token;
      return $query;
    }

    public function match_password($pass_1, $pass_2){
      $error = 'Veuillez saisir deux fois le même mot de passe !';
      if($pass_1 === $pass_2){
        return true;
      } else {
        return $error;
      }
    }

    public function valid_email($email){
      $error = 'Veuillez saisir une adresse email correct';
      if(filter_var($email, FILTER_VALIDATE_EMAIL) && $email != ''){
        return true;
      } else {
        return $error;
      }
    }

    public function valid_password($password){
      $error = 'Votre mot de passe doit au moins contenir 8 caractères !';
      $ok_pass = "/^.{8}/";

      if(preg_match($ok_pass, $password)){
        return true;
      } else {
        return $error;
      }
    }
}
