<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
  var $header_nav;
  var $meta_data;

  public function __construct() {
    parent::__construct();
    $helper = array('url', 'captcha_helper');
    $this->load->helper($helper);
    $this->load->model('email_model');

    $this->header_nav = [
      'home' => 'Home',
      'info' => 'Info',
    ];

    $this->meta_data = [
      'title' => '',
      'connected' => 0,
      'active' => '',
      'error' => null
    ];

    $this->load->model('users_model');
    if(isset($_SESSION['email'])){
      $this->meta_data['connected'] = 1;
    }
  }

  /*
   * process *****************************************************************
   */

  public function reset_pwd_process() {
    $email = $this->input->get('mail');
    if($res){
      $token = $this->users_model->get_token_reset($email);
      $res_mail = $this->email_model->sendEmail_reset_pwd($email, $token);
      if ($res_mail){
        $info = 'Veuillez consulter votre adresse mail pour réinitialiser votre mot de passe';
        $this->session->set_flashdata('class','info');
        $this->session->set_flashdata('info', $info);
        redirect('auth/login');
      } else{
        $error = 'Une erreur c\'est produite, veuillez recommencer ou contacter l\'équipe MTLAGA';
        $this->session->set_flashdata('class','error');
        $this->session->set_flashdata('error', $error);
        redirect('auth/reset');
      }
    }else{
      $error = 'Cette adresse mail n\'existe pas !';
      $this->session->set_flashdata('class','error');
      $this->session->set_flashdata('error', $error);
      redirect('auth/reset');
    }
  }

  public function reset_tok(){
    $token = $this->input->get('token');
    $email = $this->input->get('email');
    $data = array('token' => $token, 'email' => $email);
    $res = $this->users_model->check_token($token, $email);
    if ($res) {
      $this->session->set_flashdata($data);
      redirect('auth/newpassword');
    } else {
      show_404();
    }
  }

  public function change_db_pwd(){
    $pwd = $this->input->post('password');
    $pwd_confirm = $this->input->post('password_confirm');
    $email = $this->input->post('email');
    $token = $this->input->post('token');
    $data = array('token' => $token, 'email' => $email);

    $match_pwd = $this->users_model->match_password($pwd, $pwd_confirm);
    if ($match_pwd){
      $res = $this->users_model->update_password($email, $pwd);
      if ($res) { redirect('auth/login'); } else { $this->session->set_flashdata('error', 'somehting went wrong'); }
    }else{
      $error = $match_pwd;
      $this->session->set_flashdata('class','error');
      $this->session->set_flashdata('error', $error);
      $this->session->set_flashdata($data);
      redirect('auth/newpassowrd');
    }
  }

  public function signup_process(){
    $email = $this->input->post('mail');
    $password = $this->input->post('password');
    $password_confirm = $this->input->post('password_confirm');

    $confirm_token = bin2hex(random_bytes(20));

    $res_pass_match   = $this->users_model->match_password($password, $password_confirm);
    $res_valid_email  = $this->users_model->valid_email($email);
    $res_valid_pass   = $this->users_model->valid_password($password);
    $res_email_exists = $this->users_model->exists_email($email);

    $res = array($res_pass_match, $res_valid_email, $res_valid_pass, $res_email_exists);
    foreach ($res as $v) {
      if ($v !== true) {
        $error = $v;
        $this->session->set_flashdata('class','error');
        $this->session->set_flashdata('error', $error);
        redirect('auth/signup');
        exit;
      }
    }

    $data = [
      'email' => $email,
      'hash_password' => $this->users_model->hash_password($password),
      'admin' => 0,
      'created_at' => date('Y-m-d'),
      'confirmed' => 0,
      'confirmed_at' => null,
      'confirmation_token' => $confirm_token,
      'remember' => 0,
    ];

    $success = $this->users_model->add_user($data);

    if($success == true){
      $this->email_model->sendEmail_confirm($email, $confirm_token);
      $this->session->set_flashdata('email', $email);
      redirect('auth/login');
    } else {
      $error = 'Une erreur c\'est produite, veuillez contacter admin@mtlaga.ch';
      $this->session->set_flashdata('class','error');
      $this->session->set_flashdata('error', $error);
      redirect('auth/signup', 'refresh');
    }
  }

  public function resend_confirm(){
    $email = $this->input->get('email');
    $confirm_token = $this->users_model->get_confirm_token($email);
    if($confirm_token !== null){
      $this->session->set_flashdata('email', $email);
      $this->email_model->sendEmail_confirm($email, $confirm_token);
      redirect('auth/login');
    } else {
      $error = 'could not get users token';
      $this->session->set_flashdata('error', $error);
      redirect('auth/login');
    }
  }

  public function confirm(){
    $email = $this->input->get('email');
    $token = $this->input->get('token');
    if($this->users_model->check_token_confirm($token, $email)){
      $res = $this->users_model->confirmed($email);
      if($res){
        $info = 'Votre compte a été confirmé avec succès !';
        $this->session->set_flashdata('class','success');
        $this->session->set_flashdata('info', $info);
        redirect('auth/login');
      } else {
        $error = 'Une erreur c\'est produite, veuillez contacter admin@mtlaga.ch';
        $this->session->set_flashdata('class','error');
        $this->session->set_flashdata('error', $error);
        redirect('auth/signup', 'refresh');
      }
    } else {
      $error = 'Une erreur c\'est produite, veuillez contacter admin@mtlaga.ch';
      $this->session->set_flashdata('class','error');
      $this->session->set_flashdata('error', $error);
      redirect('auth/signup', 'refresh');
    }
  }

  public function logoff(){
    $this->session->unset_userdata('email');
    redirect('home');
  }

  public function login_process(){
    $email = $this->input->post('mail');
    $password = $this->input->post('password');

    $res_check_email    = $this->users_model->check_email($email);
    $res_check_password = $this->users_model->check_password($email,$password);
    $res_check_confirm  = $this->users_model->confirmed_login($email);
    $res = array($res_check_email, $res_check_password, $res_check_confirm);

    foreach ($res as $v) {
      if ($v !== true) {
        $error = $v;
        $this->session->set_flashdata('class','error');
        $this->session->set_flashdata('error', $error);
        redirect('auth/login');
        exit;
      }
    }

    $this->session->set_userdata(array('email'=>$email));
    redirect('home');
  }

  /*
   * pages render ***********************************************************
   */
  // reset password render
  //step 1
  public function reset(){
    $this->meta_data['title'] = 'réinitialiser mot de passe | MTLAGA';
    $this->meta_data['active'] = 'Home';

    $data = [
      'header_nav_meta_data' => $this->header_nav,
      'meta_data' => $this->meta_data
    ];

    $this->load->view('templates/head', $data);
    $this->load->view('templates/header', $data);
    $this->load->view('resetpwd_step_one_view', $data);
    $this->load->view('templates/footer');
  }

  //step 2
  public function newpassword(){
    if($this->session->flashdata('token') !== null){
      $this->meta_data['title'] = 'réinitialiser mot de passe | MTLAGA';
      $this->meta_data['active'] = 'Home';

      $data = [
        'header_nav_meta_data' => $this->header_nav,
        'meta_data' => $this->meta_data
      ];

      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('resetpwd_step_two_view', $data);
      $this->load->view('templates/footer');
    } else {
      show_404();
    }
  }


  public function signup() {
    $this->meta_data['title'] = 'S\'inscrire | MTLAGA';
    $this->meta_data['active'] = 'Home';

    $data = [
      'header_nav_meta_data' => $this->header_nav,
      'meta_data' => $this->meta_data
    ];

    $this->load->view('templates/head', $data);
    $this->load->view('templates/header', $data);
    $this->load->view('signup_view', $data);
    $this->load->view('templates/footer');
  }

  public function login() {
    $this->meta_data['title'] = 'Login | MTLAGA';
    $this->meta_data['active'] = 'Home';

    $data = [
      'header_nav_meta_data' => $this->header_nav,
      'meta_data' => $this->meta_data
    ];

    $this->load->view('templates/head', $data);
    $this->load->view('templates/header', $data);
    $this->load->view('login_view', $data);
    $this->load->view('templates/footer');
  }
}
?>
