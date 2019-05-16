<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log_in_in extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_log_in');
        $this->load->library(array('encryption', 'session'));
        $this->load->helper('captcha');
    }

    public function index() {
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
        $this->load->view('log_in/V_intern', $data);
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function cek_login() {
        $ch = strtoupper($this->input->post('chaptcha'));
        $sess = strtoupper($this->session->intern);		
        if ($sess == $ch ) {

          $cek_ad = $this->M_log_in->cek_intern_ex($_POST);
         
//			  var_dump($cek_ad); exit;
		  if (count($cek_ad) > 0) {
            $login_ad = $this->login_ad($_POST['username'], $_POST['password']);
            if ($login_ad != false && $login_ad == $cek_ad->id_external && $cek_ad->is_external == 1) {
              $roles = explode(",", $cek_ad->ROLES);
              $roles = array_values(array_filter($roles));
              $get_menu = $this->M_log_in->get_menu_in($roles);
			  $get_task = $this->M_log_in->get_task_in($roles);
			  $new = array(
                  "ID_USER" => $cek_ad->ID_USER,
                  "EMAIL" => $cek_ad->EMAIL,
                  "NAME" => $cek_ad->NAME,
                  "IMG" => $cek_ad->IMG,
                  "COMPANY" => $cek_ad->COMPANY,
                  "DEPARTMENT" => $cek_ad->ID_DEPARTMENT,
                  "ROLES" => $cek_ad->ROLES,
                  "ACCESS" => $get_menu,
                  "TASK" => $get_task,
                  "lang" => $_POST['lang']
              );
              $this->session->set_userdata($new);
              $this->output("sukses");
            } else {
              $this->output("Your username or password active directory is wrong");
            }
          } else {
            $cek = $this->M_log_in->cek_intern($_POST);
            if ($cek) {
                $roles = explode(",", $cek->ROLES);
                $roles = array_values(array_filter($roles));
                $get_menu = $this->M_log_in->get_menu_in($roles);
				$get_task = $this->M_log_in->get_task_in($roles);
                $new = array(
                    "ID_USER" => $cek->ID_USER,
                    "EMAIL" => $cek->EMAIL,
                    "NAME" => $cek->NAME,
                    "IMG" => $cek->IMG,
                    "COMPANY" => $cek->COMPANY,
                    "DEPARTMENT" => $cek->ID_DEPARTMENT,
                    "ROLES" => $cek->ROLES,
                    "ACCESS" => $get_menu,
					"TASK" => $get_task,
                    "lang" => $_POST['lang']
                );
                $this->session->set_userdata($new);
                $this->output("sukses");
            } else {
                $this->output("username or password wrong");
            }
          }
         } else {
             $this->output("Chaptcha not valid");
         }
        // $this->output("Oops,terjadi kesalahan");

    }

    public function captcha_refresh() {
        $vals = array(
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
        $cap = create_captcha($vals);
        $new = array(
            "intern" => $cap['word']
        );
        $this->session->set_userdata($new);
        echo $cap['image'];
    }

    public function login_ad($username, $password){
      if(isset($username) && isset($password)){

          $adServer = "ldap://jktad01.supreme-energy.local";

          $ldap = ldap_connect($adServer);

          if (ldap_set_option($ldap, LDAP_OPT_NETWORK_TIMEOUT, 5)) {
            $ldaprdn = 'supreme-energy' . "\\" . $username;

            ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
            ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

            $bind = @ldap_bind($ldap, $ldaprdn, $password);


            if ($bind) {
              $filter="(sAMAccountName=$username)";
  		        $ldap_base_dn="dc=supreme-energy,dc=local";
              $result = ldap_search($ldap,$ldap_base_dn,$filter);
              //ldap_sort($ldap,$result,"sn");
              $info = ldap_get_entries($ldap, $result);

              for ($i=0; $i<$info["count"]; $i++)
              {
                  if($info['count'] > 1)
                      break;

  			          return $info[$i]["samaccountname"][0];
              }
          } else {
            return false;
          }

        } else {
          return false;
        }
  	  } else {
        return false;
      }
    }

}
