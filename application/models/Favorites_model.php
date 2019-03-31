<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Favorites_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('users_model');
    }

    /**
     * add favorite itinerary to table favorite
     * @param $departure
     * @param $arrival
     * @return bool
     */
    public function add_favorites($departure, $arrival){
        $data = [
            'departure' => $departure,
            'arrival' => $arrival
        ];

        $res =  $this->db->insert('favorites', $data);

        if($res) {
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return false;
        }

    }

    /**
     * Link favorite to user in users_has_favorites
     * @param $id_user
     * @param $id_favorite
     * @return bool
     */
    public function add_user_favorite($id_user, $id_favorite) {
        $data = [
            'users_id_user' => $id_user,
            'favorites_id_favorites' => $id_favorite
        ];
        $res =  $this->db->insert('users_has_favorites', $data);

        if($res) {
            return true;
        } else {
            return false;
        }
    }

    public function get_user_favorite($email) {
        $id_user = $this->users_model->get_user_id($email);

        $this->db->select('departure, arrival');
        $this->db->from('favorites');
        $this->db->join('users_has_favorites', 'users_has_favorites.favorites_id_favorites = favorites.id_favorites');
        $this->db->where('users_id_user', $id_user);
        $res = $this->db->get()->result();

        return $res;
    }

}
