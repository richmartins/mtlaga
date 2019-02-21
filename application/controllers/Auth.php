<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//session_start(); //we need to start session in order to access it through CI

class Auth extends CI_Controller {
    var $header_nav;
    public function __construct() {
      parent::__construct();
      $this->load->helper('url');
      $this->header_nav = [
        'home' => 'Home',
        'info' => 'Info',
        'plan' => 'Plan'
      ];
    }

    public function process(){
      $mail = $this->input->post('mail');
      $password = $this->input->post('password');

      if(($mail == 'toto@tata.ch') && ($password == '1234')){
        redirect('home');
      }
    }

    public function signup() {
      $meta_data = [
        'title' => 'S\'inscrire | MTLAGA',
        'connected' => 0,
        'active' => 'Home'
      ];

      $data = [
        'header_nav_meta_data' => $this->header_nav,
        'meta_data' => $meta_data
      ];


      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('signup_view', $data);
      $this->load->view('templates/footer');

    }
    // Show login page
    public function login() {
      $meta_data = [
        'title' => 'Login | MTLAGA',
        'connected' => 0,
        'active' => 'Home'
      ];

      $data = [
        'header_nav_meta_data' => $this->header_nav,
        'meta_data' => $meta_data
      ];


      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('login_view', $data);
      $this->load->view('templates/footer');
  }
}
