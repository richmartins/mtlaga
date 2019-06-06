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
        $this->load->model('email_model');

        $this->load->helper('url');
        $this->header_nav = [
            'home' => 'Home',
            'info' => 'Info',
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
     * Toggle user favorite
     * If user has it : remove
     * IF user hasn't it : add
     * @return string - state for notif
     */
    public function toggle_favorite() {
        $id_user = $this->users_model->get_user_id($this->session->userdata['email']);
        $id_favorite = $this->favorites_model->favorite_exist($_POST['departure'], $_POST['arrival']);

        if(!$id_favorite) {
            $id_favorite = $this->favorites_model->add_favorites($_POST['departure'], $_POST['arrival']);
        }

        $user_has_fav = $this->favorites_model->user_has_favorite($id_user, $id_favorite);

        if($user_has_fav) {
            // already has favorite -> remove fav
            $res = $this->favorites_model->remove_user_favorite($id_user, $id_favorite);
            $return = "remove-success";
            if(!$res) {
                $return = "remove-error";
            }
        } else {
            // user hasn't fav -> add favorite
            $res = $this->favorites_model->add_user_favorite($id_user, $id_favorite);
            $return = "add-success";
            if(!$res) {
                $return = "add-error";
            }
        }
        echo $return;
    }

    /**
     * Add journey to user's favorite
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
            /*
            $query_add_user_favorite = $this->favorites_model->add_user_favorite($id_user, $id_favorite);
            echo "error";
            */
            $this->favorites_model->add_user_favorite($id_user, $id_favorite);
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
     * Download generated ics file
     * @param $var
     * @param $var2
     */
    public function generate_ics($departure, $arrival, $time_departure, $time_arrival) {
        if($this->meta_data['connected'] == 0) {
            redirect('Home');
        }
        $this->load->helper('download');

        // initialize var
        $event = [
            'title' => "Voyage de Lausanne à Genève",
            'address' => "Voie 3" . $departure . $arrival,
            'description' => "Détails de votre voyage du 14.04.19 : \\n\\n Départ : " . $time_departure . " de " . $departure . " sur Voie 2 \\n Arrivée : " . $time_arrival . "  à " . $arrival . " sur Voie 4\\n\\n Pour plus de détails : http://www.mtlaga.ch",
            'datestart' => "2019-04-14 12:00:00",
            'dateend' => "2019-04-14 13:45:00"
        ];

        // Build the ics file
        $ical = 'BEGIN:VCALENDAR
VERSION:2.0
CALSCALE:GREGORIAN
BEGIN:VEVENT
NAME:Mon Voyage - MTLAGA
X-WR-CALNAME:Mon Voyage - MTLAGA
DTEND:' . date('Ymd\\THis', strtotime($event['dateend'])) . '
SUMMARY:' . addslashes($event['title']) . '
DESCRIPTION:' . $event['description'] . '
LOCATION:' . addslashes($event['address']) . '
DTSTART:' . date('Ymd\\THis', strtotime($event['datestart'])) . '
END:VEVENT
END:VCALENDAR';

        $name = 'calendar.ics';
        force_download($name, $ical, true);
    }

    public function check_sendEmail_travel(){
      $user = $_SESSION['email'];
      $recipent = $_POST['recipents'];
      $message_user = $_POST['message'];
      $travel_info = $_POST['journey'];
      $self_send = $_POST['me'];

      $recipent_type = gettype($recipent);
      $recipent_array = [];
      if ($self_send === "true") {
        array_push($recipent_array, $user);
      }
      // check $recipent type && if it's not empty
      if ($recipent_type === "string" && $recipent !== ''){
        if(filter_var($recipent, FILTER_VALIDATE_EMAIL)){
          //use send email
          array_push($recipents_array, $recipent);
          return $this->email_model->sendEmail_travel($recipent_array, $user, $message_user, $travel_info);
        }else{
          //error
          return false;
        }
      } elseif ($recipent_type === "array") {
        foreach ($recipent as $v) {
          if(!filter_var($v, FILTER_VALIDATE_EMAIL)){
            //error
            return false;
            exit;
          }
          array_push($recipent_array, $v);
        }
        //use send model
        return $this->email_model->sendEmail_travel($recipent_array, $user, $message_user, $travel_info);
      } else{
        //error
        return false;
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
            "meta_data" => $this->meta_data,
            "scripts_to_load" => ["notification"]
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
