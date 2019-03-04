<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Favorites_model extends CI_Model {

    public $itineraire;

    public function add_favorites(){
      $this->itineraire = $_POST['itinaire'];

      $this->db->insert('entries', $this);
    }

}
