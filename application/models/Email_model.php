<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {
  public function __construct(){
     parent::__construct();
      $this->load->helper('url');

      date_default_timezone_set('Europe/Zurich');    // This was to cater for an error given to me earlier
      $this->config->load('email', TRUE);//load email config file
      $configuration = $this->config->item('mail', 'email'); //email configuration

      $this->load->library('email');
      $this->email->set_mailtype("html");
      $this->email->initialize($configuration); //initializes email configuration
  }

   public function sendEmail_confirm($to, $token){
     $from     = 'no-reply@mtlaga.ch';
     $subject  = 'Confirmation de compte MTLAGA';
     $message  = '';
     $message .= "<h2>Vous recevez cette email suite à votre inscription chez <a href='https://mtlaga.ch'>MTLAGA</a></h2>"
              . "<p>Veuillez cliquer sur le lien suivant pour confirmer votre inscription et profiter de toutes les fonctionnalités de MTLAGA :  <a href='".site_url()."/auth/confirm/?token=$token&email=$to' >Confirmation</a></p>"
              . "<p>Si ce n'ai pas vous qui avez souhaité cette requête, veuillez ignoré cette e-mail.</p>"
              . "<p>Bien cordialement,<br /> votre équipe de mtlaga</p>"
              . "";
     $this->email->from($from, 'MTLAGA');
     $this->email->to($to);
     $this->email->subject($subject);
     $this->email->message($message);
     $this->email->set_mailtype("html");
     $res = $this->email->send();

     return $res;
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
     $this->email->set_mailtype("html");
     $res = $this->email->send();
     return $res;
   }
 }
?>
