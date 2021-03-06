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

        return $res;
    }

    /**
     * Get all users favorites
     * @param $email
     * @return mixed
     */
    public function get_user_favorite($email) {
        $id_user = $this->users_model->get_user_id($email);

        $this->db->select('departure, arrival');
        $this->db->from('favorites');
        $this->db->join('users_has_favorites', 'users_has_favorites.favorites_id_favorites = favorites.id_favorites');
        $this->db->where('users_id_user', $id_user);
        $res = $this->db->get()->result();

        return $res;
    }

    /**
     * Check if favorite already exist
     * @param $departure
     * @param $arrival
     * @return bool
     */
    public function favorite_exist($departure, $arrival) {
        $this->db->select('id_favorites, departure, arrival');
        $this->db->from('favorites');
        $this->db->where('departure', $departure);
        $this->db->where('arrival', $arrival);
        $res = $this->db->get()->result();

        if(empty($res)) {
            return false;
        } else {
            return $res[0]->id_favorites;
        }
    }

    /**
     * Check if user has already favorite
     * @param $id_user
     * @param $id_favorite
     * @return bool
     */
    public function user_has_favorite($id_user, $id_favorite) {
        $this->db->select('users_id_user, favorites_id_favorites');
        $this->db->from('users_has_favorites');
        $this->db->where('users_id_user', $id_user);
        $this->db->where('favorites_id_favorites', $id_favorite);
        $res = $this->db->get()->result();

        if(empty($res)) {
            // user n'a pas le fav
            return false;
        } else {
            // user a le fav
            return true;
        }
    }

    /**
     * remove user favorite
     * @param $id_user
     * @param $id_favorite
     * @return mixed
     */
    public function remove_user_favorite($id_user, $id_favorite) {
        $this->db->where("users_id_user", $id_user);
        $this->db->where("favorites_id_favorites", $id_favorite);
        return $this->db->delete("users_has_favorites");
    }

}
