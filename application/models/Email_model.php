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

  /**
  * Default confirmation email
  * @param $to => will receive the email
  * @param $token => token of the user for further check
  * @return boolean
  */
  public function sendEmail_confirm($to, $token){
   $from     = 'no-reply@mtlaga.ch';
   $subject  = 'Confirmation de compte MTLAGA';
   $message  = '';
   $message .= "<h2>Vous recevez cet email suite à votre inscription chez <a href='https://mtlaga.ch'>MTLAGA</a></h2>"
            . "<p>Veuillez cliquer sur le lien suivant pour confirmer votre inscription et profiter de toutes les fonctionnalités de MTLAGA :  <a href='".site_url()."/auth/confirm/?token=$token&email=$to' >Confirmation</a></p>"
            . "<p>Si vous n'avez fait aucune demande, veuillez ignorer cet e-mail.</p>"
            . "<p>Bien cordialement,<br /> votre équipe mtlaga</p>"
            . "";
   $this->email->from($from, 'MTLAGA');
   $this->email->to($to);
   $this->email->subject($subject);
   $this->email->message($message);
   $this->email->set_mailtype("html");
   $res = $this->email->send();

   return $res;
  }

  /**
  * Default reset password email
  * @param $to => will receive the email
  * @param $token => token of the user for further check
  * @return boolean
  */
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

  /**
  * itinerary email
  * @param $to => who will receive the email
  * @param $user => user email
  * @param $user_message => message from sender
  * @param $travel_info
  * @return boolean
  */
  public function sendEmail_travel($to, $user, $user_message, $travel_info){
    $departure_time_stamp = (int) $travel_info['from']['departureTimestamp'];
    $arrival_timestamp    = (int) $travel_info['to']['arrivalTimestamp'];
    $departure_platform   = '';
    $arrival_platform     = '';

    $departure_location = $travel_info['from']['location']['name'];
    $departure_date     = date('d.m.Y', $departure_time_stamp);
    $departure_hour     = date('H:i', $departure_time_stamp);

    $arrival_location   = $travel_info['to']['location']['name'];
    $arrival_date       = date('d.m.Y', $arrival_timestamp);
    $arrival_hour       = date('H:i', $arrival_timestamp);

    if ($travel_info['from']['platform'] != null) {
      $departure_platform = ', sur la voie ' . $travel_info['from']['platform'];
    }

    if ($travel_info['to']['platform'] != null) {
      $arrival_platform = ', sur la voie ' . $travel_info['to']['platform'];
    }

    $from     = 'no-reply@mtlaga.ch';
    $subject  = 'Informations sur votre itineraire';
    $message  = '';
    $message .= "<h3>MTLAGA</h3>";
    $message .= "<p><b>Message de : " . $user . "</b></p>";
    $message .= "<p>" . $user_message . "</p>";
    $message .= "<p><b>Détails de votre voyage du " . $departure_date . "</b></p>";
    $message .= "<p>Départ : ". $departure_hour ." de ". $departure_location . $departure_platform . "<br />"
             . "Arrivée : " . $arrival_hour ." à ". $arrival_location . $arrival_platform . "</p>";

    $message .= "<p>Pour plus de détails : <a href='https://mtlaga.ch'>https://mtlaga.ch/</p>";

    $this->email->from($from, $user);
    $this->email->to($to);
    $this->email->subject($subject);
    $this->email->message($message);
    $this->email->set_mailtype("html");
    $res = $this->email->send();

    return $res;
  }
}
?>
