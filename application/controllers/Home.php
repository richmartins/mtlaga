<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function index() {
      $this->load->database();

      $this->input->get(array('field1', 'field2'));

        $data = array(
          'title' => 'Home | MTLAGA',
          'content' => 'mon contenu'
        );

        $this->load->helper('url');
        $this->load->view('templates/view_template', $data);
        $this->load->view('include/include_view');
    }
}
