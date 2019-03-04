<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_model extends CI_Model {
  public $title;
  public $content;

  public function add_rss(){
    $this->title   = $_POST['title'];
    $this->content = $_POST['content'];

    $this->db->insert('entries', $this);
  }
}
