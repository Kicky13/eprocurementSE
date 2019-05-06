<?php

//if (!defined('BASEPATH'))
//    exit('No direct script access allowed');

class Log_in extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->model('M_log_in');
        $this->load->library('encryption');
        $this->load->library('session');
    }

    public function get_code($data, $exp) {
        $dt['jam'] = substr($data, 0, 2);
        $dt['menit'] = substr($data, 2, 2);
        $dt['tahun'] = substr($data, 4, 4);
        $dt['bulan'] = substr($data, 18, 2);
        $dt['tgl'] = substr($data, 20, 2);
        $dt['pukul'] = $dt['jam'] . ":" . $dt['menit'];
        $dt['tgl_mulai'] = $dt['tahun'] . "-" . $dt['bulan'] . "-" . $dt['tgl'];
        $dt['tgl_mulai_min'] = str_replace("-", "", $dt['tgl_mulai']);
        $dt['tgl_selesai'] = date('Y-m-d', strtotime("+$exp days", strtotime($dt['tgl_mulai'])));
        $dt['tgl_selesai_min'] = str_replace("-", "", $dt['tgl_selesai']);
        $dt['wkt_selesai_min'] = $dt['tgl_selesai_min'] . $dt['jam'] . $dt['menit'];
        $dt['id_user'] = substr($data, 22);
        return $dt;
    }

    public function index($url = null) {
        $data = array();
        $data['note'] = null;
        $data['url'] = null;
        if ($url != null) {//akses vendor pertama kali
            $get_vn = $this->M_log_in->get_vendor($url);
            if (count($get_vn) != 0) {//cek user ada dengan url
                $this->M_log_in->update_vendor(array("URL" => $url), array("STATUS" => "4"));
                $dt = $this->get_code($url, $get_vn->URL_BATAS_HARI);
                $now = date("YmdHi");
                if ($dt['wkt_selesai_min'] < $now) {
                    $data['note'] = "URL sudah kadaluarsa";
                } else {
                    $data['url'] = $url;
                }
            } else {
                $data['note'] = "URL tidak valid, Harap Hubungi Admin";
            }
        }
        $data['all'] = null;
        $res = $this->M_log_in->check_reg();
        if ($res != false)
            $data['all'] = count($res);
        $values = array(
            'word' => '',
            'img_path' => './ast11/img/chaptcha/',
            'img_url' => base_url() . 'ast11/img/chaptcha',
            'font_path' => base_url() . 'sys11/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 60,
            'word_length' => 4,
            'font_size' => 16,
            'expiration' => 3600,
            'pool' => '0123456789',
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(0, 153, 255),
                'text' => array(0, 0, 0),
                'grid' => array(0, 153, 255)
            )
        );
        $data_ch = create_captcha($values);
        $new = array(
            "ch" => $data_ch['word']
        );
        $this->session->set_userdata($new);
        $data['image'] = $data_ch['image'];
        $this->load->view('log_in/V_vendor', $data);
    }

    public function cek_login() {
     if (strtoupper($this->session->ch) == strtoupper($_POST['chaptcha'])) {
//            $_POST['password'] = $this->encryption->encrypt($_POST['password']);
            $cek = isset($_SESSION['ID_VENDOR']) ? $_SESSION['ID_VENDOR'] : NULL;
            if ($cek != null) {
                echo "<script>document.location.href='".  base_url('vn/info/greetings')."'</script>";
            }
            $cek = $this->M_log_in->cek_vendor($_POST);
            if (!$cek) {
                echo "Username or Password is wrong!";
            } else {
                // if ($_POST['url'] != "") {//login pertama kali
                    // $this->M_log_in->update_vendor(array("URL" => $_POST['url']), array("STATUS" => "4"));
                // }
                $new = array(
                    "ID_VENDOR" => $cek[0]->ID_VENDOR,
                    "NAME" => $cek[0]->NAMA,
                    "ID" => $cek[0]->ID,
                    "lang" => $_POST['lang'],
                    "status_vendor" => $cek[0]->STATUS,
                );
                $this->session->set_userdata($new);
                echo "sukses";
            }
        } else {
            //echopre($_SESSION);
            //echopre($_POST);
            echo "Chaptcha Tidak Valid";
        }
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function captcha_refresh() {
        $vals = array(
            'word' => '',
            'img_path' => './ast11/img/chaptcha/',
            'img_url' => base_url() . 'ast11/img/chaptcha',
            'font_path' => base_url() . 'sys11/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 60,
            'word_length' => 4,
            'font_size' => 16,
            'expiration' => 3600,
            'pool' => '0123456789',
            'colors' => array(
                'background' => array(255, 255, 255),
                'border' => array(0, 153, 255),
                'text' => array(0, 0, 0),
                'grid' => array(0, 153, 255)
            )
        );
        $cap = create_captcha($vals);
        $new = array(
            "ch" => $cap['word']
        );
        $this->session->set_userdata($new);
        $this->output($cap['image']);
    }

}
