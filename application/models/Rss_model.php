<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_model extends CI_Model {
  public $title;
  public $content;

  public function __construct(){
    parent::__construct();
    $this->load->database();
  }

  public function add_rss(){
    $this->title   = $_POST['title'];
    $this->content = $_POST['content'];

    $this->db->insert('rss', $this);
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
