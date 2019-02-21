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
    }

    public function signup_process(){
      $mail = $this->input->post('mail');
      $password = $this->input->post('password');
      $password_confirm = $this->input->post('password_confirm');

      if($password === $password_confirm){
        redirect('auth/login');
        //use model to add user
      } else {
        redirect('auth/signup');
      }
    }

    public function process(){
      $mail = $this->input->post('mail');
      $password = $this->input->post('password');

      if(($mail == 'toto@tata.ch') && ($password == '1234')){
        redirect('home');
        //log on the user
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
