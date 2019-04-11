<?php

defined('BASEPATH') OR exit('No direct script access allowed');
class Itinerary extends CI_Controller {

    var $header_nav;
    var $meta_data;
    var $result;
    var $favorites;

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model("itinerary_model");
        $this->load->model('users_model');
        $this->load->model('favorites_model');

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
     * Add journey to user's favourite
     * @return bool|string
     */
    public function add_favorites() {
        $id_user = $this->users_model->get_user_id($this->session->userdata['email']);
        $id_favorite = $this->favorites_model->favorite_exist($_POST['departure'], $_POST['arrival']);
        $id_link_favorite = $this->favorites_model->user_has_favorite($id_user, $id_favorite);

        if(!$id_link_favorite) {
            if(!$id_favorite) {
                $id_favorite = $this->favorites_model->add_favorites($_POST['departure'], $_POST['arrival']);
            }
            $query_add_user_favorite = $this->favorites_model->add_user_favorite($id_user, $id_favorite);
            if($query_add_user_favorite) {
                return true;
            } else {
                return "Error";
            }
        } else {
            // user has already fav
            return true;
        }
    }

    /**
     * Remove user favorite link
     * @param $departure
     * @param $arrival
     * @return bool
     */
    public function remove_favorite() {
       $id_user = $this->users_model->get_user_id($this->session->userdata['email']);
       $id_favorite = $this->favorites_model->favorite_exist($_POST['departure'], $_POST['arrival']);
       $res =  $this->favorites_model->remove_user_favorite($id_user, $id_favorite);

       if($res) {
           echo "success";
       } else {
           echo "error";
       }
    }

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
        $this->favorites = [];
        if($this->meta_data['connected']) {
            $this->favorites = $this->favorites_model->get_user_favorite($this->session->userdata['email']);
        }


        $search_result = [
            "api" => $this->result,
            "favorites" => $this->favorites,
            "date" => $date,
            "time" => $time
        ];

        $this->load->view("templates/head", $data);
        $this->load->view('templates/header', $data);
        $this->load->view("itinerary_view", $search_result);
        $this->load->view('templates/footer');
    }
}
