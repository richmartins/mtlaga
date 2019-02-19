<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
  function __construct() {
      parent::__construct();

      $this->load->database();

      $this->load->helper('url');

    }

    public function index() {
        $query = $this->db->query("SELECT * FROM users;");

        $header_nav = [
          0 => 'home',
          1 => 'info',
          2 => 'plan'

        ];

        $meta_data = [
          'title' => 'Home | MTLAGA',
          'connected' => 0,
          'active' => 'home'
        ];

        $data = [
          'header_nav_meta_data' => $header_nav,
          'meta_data' => $meta_data
        ];

        $this->load->view('templates/head', $data);
        $this->load->view('templates/header', $data);
        $this->load->view('home_view', $data);
        $this->load->view('templates/footer');
    }

    public function info(){
      $this->load->helper('url');

      $header_nav = [
        0 => 'home',
        1 => 'info',
        2 => 'plan'
      ];

      $meta_data = [
        'title' => 'Info | MTLAGA',
        'connected' => 0,
        'active' => 'info'
      ];
      $data = [
        'header_nav_meta_data' => $header_nav,
        'meta_data' => $meta_data
      ];

      $this->load->view('templates/head', $data);
      $this->load->view('templates/header', $data);
      $this->load->view('about_view', $data);
      $this->load->view('templates/footer');
    }
}
