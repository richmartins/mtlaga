<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
  public function __construct(){
     parent::__construct();
      $ci = get_instance();
      $ci->load->library('email');
      $config['protocol']  = "smtp";
      $config['smtp_host'] = "mail.infomaniak.com";
      $config['smtp_port'] = "587";
      $config['smtp_user'] = "no-reply@mtlaga.ch";
      $config['smtp_pass'] = getenv('NO-REPLY_PWD');
      $config['charset']   = "utf-8";
      $config['mailtype']  = "html";
      $this->load->library('email');
      $this->email->initialize($config);
      $this->email->set_mailtype("html");

   }

   public function sendEmail_confirm($to, $token){
     $from     = 'no-reply@mtlaga.ch';
     $subject  = 'Confirmation de compte MTLAGA';
     $message  = '';
     $message .= "<h2>Vous recevez cette email suite à votre inscription chez <a href='https://mtlaga.ch'>MTLAGA</a></h2>"
              . "<p>Veuillez cliquer sur le lien suivant pour profiter de toutes les fonctionnalité de MTLAGA :  <a href='".site_url()."/auth/confirm/?token=$token&email=$to' >confirmation</a></p>"
              . "<p>Si ce n'ai pas vous qui avez souhaitez cette requête, veuillez ignoré cette e-mail.</p>"
              . "<p>Bien cordialement, votre équipe de mtlaga</p>"
              . "";
     $this->email->from($from, 'MTLAGA');
     $this->email->to($to);
     $this->email->subject($subject);
     $this->email->message($message);
     $res = $this->email->send();
     var_dump($res);
     if($res) { return true; } else { return false; }
   }

   public function sendEmail_reset_pwd($to, $token){
     $from     = 'no-reply@mtlaga.ch';
     $subject  = 'Réinitialisation de votre mot de passe MTLAGA';
     $message  = '';
     $message .= "<h2>Vous recevez cette email suite à votre demande de réinitialisation de votre mot de passe</h2>"
              . "<p>Veuillez cliquer sur le lien suivant pour saisir un nouveau mot de passe :  <a href='".site_url()."/auth/reset_tok/?token=$token&email=$to' >nouveau mot de passe</a></p>"
              . "<p>Si ce n'ai pas vous qui avez souhaitez cette requête, veuillez ignoré cette e-mail.</p>"
              . "<p>Bien cordialement, votre équipe de mtlaga</p>"
              . "";
     $this->email->from($from, 'MTLAGA');
     $this->email->to($to);
     $this->email->subject($subject);
     $this->email->message($message);
     $res = $this->email->send();
     if($res) { return true; } else { return false; }
   }
 }
