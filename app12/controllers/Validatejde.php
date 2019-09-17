<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validatejde extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();
        $this->db = $this->load->database('oracledev', TRUE);
    }

    public function checkItem()
    {
        echo json_encode($this->input->post());
    }
}