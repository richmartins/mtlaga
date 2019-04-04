<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_model extends CI_Model {

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function getRss(){
    $this->db->select('title, content');
    $this->db->from('rss');
    $query = $this->db->get();
    $rss = [];
    if ($query->num_rows() >= 1){
      foreach ($query->result() as $row) {
        $rss[$row->title] = $row->content;
      }
      return $rss;
    }
  }
}
