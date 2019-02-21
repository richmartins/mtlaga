<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//session_start(); //we need to start session in order to access it through CI

class Auth extends CI_Controller {
    public function __construct() {
      parent::__construct();
      $this->load->helper('url');

    // Show login page
    public function login() {

      $data = [
        'title' => 'Login | MTLAGA',
        'content' => 'blabla',
        'connected' => 0
      ];

      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('login_view', $data);
      $this->load->view('templates/footer');
  }
}
