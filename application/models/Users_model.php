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
      $this->db->select('email');
      $this->db->from('users');
      $this->db->where('email', $email);
      $res = $this->db->get()->result()[0]->email;
      if($res !== null) { return true; } else { return false; }
    }

    public function sendEmail_reset_pwd($to, $token){
      $from     = 'richard.tenorio@outlook.com';
      $subject  = 'Réinitialisation de votre mot de passe MTLAGA';
      $message  = '';
      $message .= "<h2>Vous recevez cette email suite à votre demande de réinitialisation de votre mot de passe</h2>"
               . "<p>Veuillez cliquer sur le lien suivant pour saisir un nouveau mot de passe :  <a href='".site_url()."/auth/reset_tok/?token=$token&email=$to' >nouveau mot de passe</a></p>"
               . "<p>Si ce n'ai pas vous qui avez souhaitez cette requête, veuillez ignoré cette e-mail.</p>"
               . "<p>Bien cordialement, votre équipe de mtlaga</p>"
               . "";
      $this->load->library('email');
      $this->email->from($from, 'MTLAGA');
      $this->email->to($to);
      $this->email->subject($subject);
      $this->email->message($message);
      if($this->email->send()) { return true; } else { return false; }
    }
}
