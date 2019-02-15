<?php
defined('BASEPATH') OR exit('No direct script access allowed');
session_start(); //we need to start session in order to access it through CI

class Login extends CI_Controller {
    public function __construct() {
      parent::__construct();

      // Load form helper library
      $this->load->helper('form');

      // Load form validation library
      $this->load->library('form_validation');

      // Load session library
      $this->load->library('session');

      // Load database
      $this->load->database();
      $this->load->model('login_database');
    }

    // Show login page
    public function index() {
      $route['login'] = 'login';
      $this->load->helper('url');
      $this->load->view('templates/head', $data['title']);
      $this->load->view('templates/header');
      $this->load->view('home_view', $data);
      $this->load->view('templates/footer');
    }

    // Show registration page
    public function singup_show() {
      $this->load->view('signup');
    }

    // Validate and store registration data in database
    public function new_user_registration() {

      // Check validation for user input in SignUp form
      $this->form_validation->set_rules('email_value', 'Email', 'trim|required|xss_clean');
      $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
      if ($this->form_validation->run() == FALSE) {

        $this->load->view('signup');
        } else {
          $data = array(
            'user_email' => $this->input->post('email_value'),
            'user_password' => $this->input->post('password')
          );
          $result = $this->login_database->registration_insert($data);
          if ($result == TRUE) {
            $data['message_display'] = 'Registration Successfully !';
            $this->load->view('login_form', $data);
          } else {
            $data['message_display'] = 'Username already exist!';
            $this->load->view('signup', $data);
          }
        }
      }

      // Check for user login process
      public function user_login_process() {

        $this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');

        if ($this->form_validation->run() == FALSE) {
          if(isset($this->session->userdata['logged_in'])){
            $this->load->view('admin_page');
          }else{
            $this->load->view('login_form');
          }
        } else {
          $data = array(
            'username' => $this->input->post('username'),
            'password' => $this->input->post('password')
          );
          $result = $this->login_database->login($data);
          if ($result == TRUE) {

            $username = $this->input->post('username');
            $result = $this->login_database->read_user_information($username);
            if ($result != false) {
              $session_data = array(
                'username' => $result[0]->user_name,
                'email' => $result[0]->user_email,
              );
              // Add user data in session
              $this->session->set_userdata('logged_in', $session_data);
              $this->load->view('admin_page');
            }
          } else {
            $data = array(
              'error_message' => 'Invalid Username or Password'
            );
            $this->load->view('login_form', $data);
          }
        }
      }

      // Logout from admin page
      public function logout() {

        // Removing session data
        $sess_array = array(
          'username' => ''
        );
        $this->session->unset_userdata('logged_in', $sess_array);
        $data['message_display'] = 'Successfully Logout';
        $this->load->view('templates/head', $data['title']);
        $this->load->view('templates/header');
        $this->load->view('home_view', $data);
        $this->load->view('templates/footer');
      }
  }
}
