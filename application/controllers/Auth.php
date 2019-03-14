<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//session_start(); //we need to start session in order to access it through CI

class Auth extends CI_Controller {
    var $header_nav;
    var $meta_data;

    public function __construct() {
      parent::__construct();
      $this->load->helper('url');
      $this->header_nav = [
        'home' => 'Home',
        'info' => 'Info',
        'plan' => 'Plan'
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
     * process
     */
    public function logoff(){
      $this->session->unset_userdata('email');
      redirect('home');
    }

    //before sending email
    public function reset_pwd_process() {
        $email = $this->input->get('mail');
        $res = $this->users_model->check_email($email);
        if($res){
          $token = $this->users_model->get_token($email);
          $this->users_model->sendEmail_reset_pwd($email, $token);
          $info = 'Veuillez consulter votre adresse mail pour réinitialiser votre mot de passe';
          $this->session->set_flashdata('info', $info);
          redirect('auth/login');
        }else{
          $error = 'Cette adresse mail n\'existe pas !';
          $this->session->set_flashdata('error', $error);
          redirect('auth/reset');
        }
      }

      //after sending email
      public function reset_tok(){
        $token = $this->input->get('token');
        $email = $this->input->get('email');
        // check db si il existe
        $res = $this->users_model->check_token($token);
        if ($res) {
          $this->session->flashdata('reset_step' => '2', 'email' => $email, 'token' => $token);
          redirect('auth/reset');
        } else {
          exit;
        }
      }

      public function change_db_pwd(){
        $pwd = $this->input->post('password');
        $pwd_confirm = $this->input->post('password_confirm');
        $email = $this->input->post('email');
        $token = $this->input->post('token');

        if ($pwd == $pwd_confirm) {
          $res = $this->users_model->update_password($email, $pwd)
          if ($res) { redirect('auth/login'); } else { /*whatever*/}
        }
      }

      public function signup_process(){
        $email = $this->input->post('mail');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');

        if($this->users_model->check_email($email)){
            if($password !== $password_confirm){
              $error = 'Vous devez saisir 2 fois le même mode passe !';
              $this->session->set_flashdata('error', $error);
              redirect('auth/signup');
            }

            $data = [
              'email' => $email,
              'hash_password' => $this->users_model->hash_password($password),
              'admin' => 0,
              'created_at' => date('Y-m-d'),
              'confirmed' => 0,
              'confirmed_at' => null,
              'confirmation_token' => bin2hex(random_bytes(20)),
              'remember' => 0,
            ];

            $success = $this->users_model->add_user($data);

            if($success == true){
              redirect('auth/login', 'refresh');
            }else{
              $error = 'Une erreur c\'est produite, veuillez contacter admin@mtlaga.ch';
              $this->session->set_flashdata('error', $error);
              redirect('auth/signup', 'refresh');
            }

        } else {
          $error = 'L\'adresse mail que vous avez saisi existe déjà !';
          $this->session->set_flashdata('error', $error);
          redirect('auth/signup', 'refresh');
        }
    }

    public function login_process(){
      $email = $this->input->post('mail');
      $password = $this->input->post('password');

      if($this->users_model->check_password($email,$password)){
          $this->session->set_userdata(array('email'=>$email));
          redirect('home');
      }else{
          $error = 'L\'adresse mail ou le mot de passe saisi sont incorect';
          $this->session->set_flashdata('error', $error);
          redirect('auth/login');
      }
    }

    /*
     * pages
     */

    public function reset(){
      $this->meta_data['title'] = 'réinitialiser mot de passe | MTLAGA';
      $this->meta_data['active'] = 'Home';

      $data = [
        'header_nav_meta_data' => $this->header_nav,
        'meta_data' => $this->meta_data
      ];

      if($this->session->flashdata('reset_step') = '2'){
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('resetpwd_step_two_view', $data);
        $this->load->view('templates/footer');
      } else {
        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('resetpwd_step_one_view', $data);
        $this->load->view('templates/footer');
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
