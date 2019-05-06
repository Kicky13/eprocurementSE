<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class All_intern extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function log_out() {
        $this->session->sess_destroy();
        header('Location:' . base_url() . 'in/');
    }

    public function check_lang_sess() {
        $this->output($_SESSION['lang']);
    }

    public function change_lang($lang) {
        $this->session->set_userdata(array("lang" => $lang));
        echo $lang;
    }

    public function set_sess() {
        $this->session->lang = $_POST['lang'];
    }

    public function get_notif() {

        if (!empty($_POST['idnya'])) { $idnya = $_POST['idnya']; } else { $idnya = ""; }
        $res = $this->mai->get_notification($idnya);
        $all = $res->result_array();
        $total = $res->num_rows();
        $all = array_values(array_filter($all)); //distroy null value
        $str = '<a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="fa fa-bell-o"></i>
                  <span class="badge badge-pill badge-default badge-warning badge-default badge-up badgetotal">'.$total.'</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                  <li class="dropdown-menu-header">
                      <h6 class="dropdown-header m-0">
                          <span class="grey darken-2">Notification</span>
                          <span class="notification-tag badge badge-default badge-warning float-right m-0 badgetotalnew">'.$total.' New</span>
                      </h6>
                  </li>
                  <li class="scrollable-container media-list notif1" id="style-1">';

          foreach ($all as $row) {
              if ($row['description'] != '') {
                  $str .= '
                  <a href="javascript:void(0)">
                    <div class="media">
                        <div class="media-body">
                          <h6 class="media-heading">' . substr($row["ID"], 0, 40) . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . substr($row["description"], 0, 35) . '<br/></p>
                          <small>
                            <time datetime="' . $row['CREATE_TIME'] . '" class="media-meta text-muted"> '.$row['CREATE_TIME'].'</time>
                          </small>
                        </div>
                    </div>
                </a>';
              }
          }

        $str .= '</li>
              </ul>';
        echo $str;
        exit;
    }

    public function update_notif(){
      $data = array(
        'READ' => '1'
      );
      $this->mai->update_notif($data);
    }

    public function update_notif_msg(){
      $idnya = $this->session->userdata['ID_USER'];
      $this->mai->update_notif_msg($idnya);
    }

    public function status_chat(){
      if (!empty($_POST['idnya'])) { $idnya = $_POST['idnya']; } else { $idnya = ""; }
      $res = $this->mai->status_chat($idnya);
      $all = $res->result_array();
      $total = $res->num_rows();
      $all = array_values(array_filter($all)); //distroy null value
      $str = '<a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="fa fa-envelope-o"></i>
                <span class="badge badge-pill badge-default badge-danger badge-default badge-up badgetotalmsg">'.$total.'</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                <li class="dropdown-menu-header">
                    <h6 class="dropdown-header m-0">
                        <span class="grey darken-2">Messages</span>
                        <span class="notification-tag badge badge-default badge-danger float-right m-0 badgetotalnewmsg">'.$total.' New</span>
                    </h6>
                </li>
                <li class="scrollable-container media-list notif1" id="style-1">';

        foreach ($all as $row) {
            if ($row['VALUE'] != '') {
                $str .= '
                <a href="javascript:void(0)">
                  <div class="media">
                      <div class="media-body">
                        <h6 class="media-heading">' . $row['SENDER'] . '</h6>
                        <p class="notification-text font-small-3 text-muted">' . substr($row["VALUE"], 0, 20) . '<br/></p>
                        <small>
                          <time datetime="' . $row['TIME'] . '" class="media-meta text-muted"> '.$row['TIME'].'</time>
                        </small>
                      </div>
                  </div>
              </a>';
            }
        }

      $str .= '</li>
            </ul>';
      echo $str;
      exit;
    }

    public function show_notif(){
      if (!empty($_POST['idnya'])) { $idnya = $_POST['idnya']; } else { $idnya = ""; }
      $res = $this->mai->get_notification($idnya);
      $all = $res->result_array();
      $total = $res->num_rows();
      $all = array_values(array_filter($all));
      $result = array();

      $result = array(
        'total' => $total,
        'data' => $all
      );

      echo json_encode($result);
    }

}

?>
