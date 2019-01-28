<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {

        $data = array(
          'title' => 'Home | MTLAGA',
          'content' => 'mon contenu'
        );
        
        $this->load->helper('url');
        $this->load->view('templates/view_template', $data);
    }
}
