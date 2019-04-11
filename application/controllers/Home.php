<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    var $header_nav;
    var $meta_data;
    var $rss;
    function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('favorites_model');
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

        $this->load->model('rss_model');

        if(!empty($this->rss_model->getRss())) {
          $this->rss = $this->rss_model->getRss();
          $this->meta_data['rss'] = $this->rss;
        }

        if(isset($_SESSION['email'])){
          $this->meta_data['connected'] = 1;
        }
      }

      public function index() {
          $this->meta_data['title'] = 'Home | MTLAGA';
          $this->meta_data['active'] = 'Home';

          $user_favorites = "";
          if(isset($this->session->userdata['email'])) {
              $user_favorites = $this->favorites_model->get_user_favorite($this->session->userdata['email']);
          }

          $data = [
            'header_nav_meta_data' => $this->header_nav,
            'meta_data' => $this->meta_data,
            'user_favorites' => $user_favorites
          ];

          $this->load->view('templates/head', $data);
          $this->load->view('templates/header', $data);
          $this->load->view('home_view', $data);
          $this->load->view('templates/footer');
        }

        public function info(){
          $this->meta_data['title'] = 'Info | MTLAGA';
          $this->meta_data['active'] = 'Info';

          $data = [
            'header_nav_meta_data' => $this->header_nav,
            'meta_data' => $this->meta_data
          ];


          $this->load->view('templates/head', $data);
          $this->load->view('templates/header', $data);
          $this->load->view('about_view', $data);
          $this->load->view('templates/footer');
        }
}
