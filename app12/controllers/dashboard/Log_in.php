<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

Class Log_in extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('captcha');
        $this->load->model('dashboard/M_log_in');
        $this->load->library('encryption');
        $this->load->library('session');
    }

    public function index($url = null) {
        $cek = isset($_SESSION['ACCESS']) ? $_SESSION['ACCESS'] : NULL;
        if ($cek != null) {
            echo "<script>document.location.href='".  base_url('home')."'</script>";
        }
        $values = array(
            'word' => '',
            'img_path' => './ast11/img/chaptcha/',
            'img_url' => base_url() . 'ast11/img/chaptcha',
            'font_path' => base_url() . 'sys11/fonts/texb.ttf',
            'img_width' => '150',
            'img_height' => 50,
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
            "intern" => $data_ch['word']
        );
        $this->session->set_userdata($new);
        $data['image'] = $data_ch['image'];
        $this->load->view('dashboard/V_login', $data);
    }

    public function cek_login() {
        $ch = strtoupper($this->input->post('chaptcha'));
        $sess = strtoupper($this->session->intern);
        if ($sess == $ch ) {
            $cek = $this->M_log_in->cek_intern($_POST);
            if ($cek) {
                $roles = explode(",", $cek->ROLES);
                $roles = array_values(array_filter($roles));
                $new = array(
                    "ID_USER" => $cek->ID_USER,
                    "EMAIL" => $cek->EMAIL,
                    "NAME" => $cek->NAME,
                    "IMG" => $cek->IMG,
                    "COMPANY" => $cek->COMPANY,
                    "ROLES" => $cek->ROLES,
                    "lang" => $_POST['lang']
                );
                $this->session->set_userdata($new);
                $this->output("sukses");
            } else {
                $this->output("username atau password salah");
            }
        } else {
            $this->output("Chaptcha tidak valid");
        }
        $this->output("Oops,terjadi kesalahan");
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
