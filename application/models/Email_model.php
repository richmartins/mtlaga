<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Email extends CI_Model {
  public function __construct(){
     parent::__construct();
     $this->load->library('email');

      //SMTP & mail configuration
      $config = array(
          'protocol'  => 'smtp',
            'smtp_host' => 'mail.infomaniak.com',
          'smtp_port' => 587,
          'smtp_user' => 'no-reply@hadrien-louis.ch',
          'smtp_pass' => 'gmail_password',
          'mailtype'  => 'html',
          'charset'   => 'utf-8'
      );
      $this->email->initialize($config);
      $this->email->set_mailtype("html");
      $this->email->set_newline("\r\n");

      //Email content
      $htmlContent = '<h1>Sending email via SMTP server</h1>';
      $htmlContent .= '<p>This email has sent via SMTP server from CodeIgniter application.</p>';

      $this->email->to('recipient@example.com');
      $this->email->from('sender@example.com','MyWebsite');
      $this->email->subject('How to send email via SMTP server in CodeIgniter');
      $this->email->message($htmlContent);

      //Send email
      $this->email->send();

      /////////////////////////////$this->load->library('encrypt');///////////to avoid spamming of mail////////////////////////
      /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

      ////CHANGE SETTINGS IN GOGLE ACCOUNTS/////
      ////MY ACCOUNT>SIGNING IN TO GOOGLE(under sign in & security)/////
      ////SWITCH OFF 2 STEP VERIFICATION/////
      ////IN CONNECTED APPS N SITES>SWITCH ONN---"ALLOW LESS SECURE APPS"----/////

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
     $this->email->send()
     // if() { return true; } else { return false; }
   }
 }
