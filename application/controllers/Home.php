<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
        $this->load->database();
        $query = $this->db->query("SELECT email FROM users;");

        $data = array(
          'title' => 'Home | MTLAGA',
          'content' => $res
        );

        $this->load->helper('url');
        $this->load->view('templates/view_template', $data);
    }
}
