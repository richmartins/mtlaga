<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
    public function index() {

      $route['login'] = 'login';
      $this->load->helper('url');
      $this->load->view('templates/head', $data['title']);
      $this->load->view('templates/header');
      $this->load->view('home_view', $data);
      $this->load->view('templates/footer');
    }
}
