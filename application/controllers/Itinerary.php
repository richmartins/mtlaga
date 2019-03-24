<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Itinerary extends CI_Controller {

    var $header_nav;
    var $meta_data;
    var $result;

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


    /*
    public function itinerary_process() {
        $departure = $this->input->post("departure_city");
        $arrival = $this->input->post("arrival_city");
        $date = $this->input->post("departure_date");
        $time = $this->input->post("departure_time");

        $this->result = $this->itinerary_model->get_data_api($departure, $arrival, $date, $time);

        redirect('itinerary');
    }
    */

    /**
     * Render page
     */
    public function index() {
        $this->meta_data['title'] = "Itinéraire | MTLAGA";
        $this->meta_data['active'] = "Home";

        $data = [
            "header_nav_meta_data" => $this->header_nav,
            "meta_data" => $this->meta_data
        ];

        $departure = $this->input->post("departure_city");
        $arrival = $this->input->post("arrival_city");
        $date = $this->input->post("departure_date");
        $time = $this->input->post("departure_time");

        if(empty($date)) {
            $date = date("Y-m-d");
        }
        if(empty($time)) {
            $time = date("H:i");
        }

        $this->result = $this->itinerary_model->get_data_api($departure, $arrival, $date, $time);

        $search_result = [
            "api" => $this->result,
            "date" => $date,
            "time" => $time
        ];

        $this->load->view("templates/head", $data);
        $this->load->view('templates/header', $data);
        $this->load->view("itinerary_view", $search_result);
        $this->load->view('templates/footer');
    }
}
