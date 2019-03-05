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
        'active' => ''
      ];
      $this->load->model('users_model');

    }

    /*
     * process
     */

    public function reset_pwd_process() {
        $email = $this->input->post('mail');
        $res = $this->users_model->check_email($email);
        if($res){
          //get token of email
          //send email
        }else{
          redirect('auth/reset');
        }
      }

      public function new_pwd_process(){

      }

      public function signup_process(){
        $email = $this->input->post('mail');
        $password = $this->input->post('password');
        $password_confirm = $this->input->post('password_confirm');


        if($password === $password_confirm){
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
              $signup_status = 'sucess';
              redirect('auth/login');
            }else{
              $signup_status = null;
              redirect('auth/signup');
            }
        }
    }

    public function login_process(){
      $email = $this->input->post('mail');
      $password = $this->input->post('password');

      if($this->users_model->check_password($email,$password)){
          // session_start();
          // $_SESSION['email'] = $email;
          redirect('home');
      }else{
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

      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('resetpwd_view', $data);
      $this->load->view('templates/footer');

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

      (isset($signup_status)) ? $this->meta_data['signup'] = 'sucess' : $this->meta_data['signup'] = 'failed';

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
