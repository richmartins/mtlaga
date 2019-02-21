<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
  var $header_nav;

  function __construct() {
      parent::__construct();
      $this->load->database();
      $this->load->helper('url');
      $this->header_nav = [
        'home' => 'Home',
        'info' => 'Info',
        'plan' => 'Plan'
      ];
    }

    public function index() {
        $meta_data = [
          'title' => 'Home | MTLAGA',
          'connected' => 0,
          'active' => 'Home'
        ];

        $data = [
          'header_nav_meta_data' => $this->header_nav,
          'meta_data' => $meta_data
        ];

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('home_view', $data);
        $this->load->view('templates/footer');
    }

    public function info(){
      $meta_data = [
        'title' => 'Info | MTLAGA',
        'connected' => 0,
        'active' => 'Info'
      ];
      $data = [
        'header_nav_meta_data' => $this->header_nav,
        'meta_data' => $meta_data
      ];

      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('about_view', $data);
      $this->load->view('templates/footer');
    }
}
