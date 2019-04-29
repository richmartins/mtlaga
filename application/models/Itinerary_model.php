<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Itinerary_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * get itinerary data form opendata API
     * return formated json
     */
    public function get_data_api($departure, $arrival, $date, $time) {

      $params = [
        "from" => $departure,
        "to" => $arrival,
        "limit" => 15,
        "date" => $date,
        "time" => $time
      ];

      $url = "http://transport.opendata.ch/v1/connections?" . http_build_query($params);

      $options= [
            CURLOPT_URL => $url,
            CURLOPT_HEADER => false,
            CURLOPT_FAILONERROR => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET'
      ];

      $curl = curl_init();
      if(empty($curl)) {
        die("Une erreur est survenue");
      }

      curl_setopt_array($curl,$options);
      $results = json_decode(curl_exec($curl));

      if(curl_errno($curl)){
          die("Une erreur est survenue");
      }

      //if($result['connections'])

      curl_close($curl);
      return $results;
    }

}
