<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Itinerary extends CI_Controller {
    
    var $header_nav;
    var $meta_data;

    public function __construct() {
        parent::__construct();
        $this->load->model("itinerary_model");

        $this->load->helper('url');
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
        
        if(isset($_SESSION['email'])){
            $this->meta_data['connected'] = 1;
        }
    }


    public function itinerary_process() {
        $departure = $this->input->post("departure_city");
        $arrival = $this->input->post("arrival_city");
        $result = $this->itineraray_model->get_data_api($departure, $arrival);
        
        if($result) {
            redirect("itinerary");
        } else {
            
        }
    }

    /**
     * render page
     */
    public function index() {
        $this->meta_data['title'] = "Itinéraire | MTLAGA";
        $this->meta_data['active'] = "Home";
        
        $data = [
            "header_nav_meta_data" => $this->header_nav,
            "meta_data" => $this->meta_data
        ]
        
        $this->load->view("templates/head", $data);
    }
}