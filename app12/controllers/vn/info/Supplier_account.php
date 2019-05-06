<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier_account extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->model('vn/info/M_supplier_account', 'mse');
      $this->load->model('vendor/M_invitation');
      $this->load->model('vn/info/M_vn', 'mvn');
  }

  protected function sendMail($content) {
      $mail = get_mail();
      $config = array();
      $config['protocol'] = $mail['protocol'];
      $config['smtp_crypto'] = $mail['crypto'];
      if($mail['protocol'] == 'smtp'){
          $config['smtp_pass'] = $mail['password'];
      }

      //$config['protocol'] = 'mail';
      //$config['smtp_crypto'] = '';

      $config['crlf'] = "\r\n";
      $config['mailtype'] = 'html';
      $config['smtp_host'] = $mail['smtp'];
      $config['smtp_port'] = $mail['port'];
      $config['smtp_user'] = $mail['email'];
      $config['charset'] = "utf-8";
      $config['newline'] = "\r\n";

      $this->load->library('email', $config);
      $this->email->initialize($config);
      $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
      $this->email->to($content['email']);
      $this->email->subject($content['title']);

      $ctn = ' <p>' . $content['img1'] . '<p>
                      <p>' . $content['open'] . '<p>
                      <br>
                      <table>
                          <tr>
                              <td>Username</td>
                              <td>: ' . $content['email'] . '</td>
                          </tr>
                          <tr>
                              <td>Password</td>
                              <td>: ' . $content['pass'] . '</td>
                          </tr>
                          <tr>
                              <td>Link</td>
                              <td>:  ' . $content['link'] . '</td>
                          </tr>
                      </table>
                      <br>

                      <br>
                      <p>Supreme Energy.</p>
                      ';
      $this->email->message($ctn);

      $data_email['recipient'] = $content['email'];
      $data_email['subject'] = $content['title'];
      $data_email['content'] = $ctn;
      $data_email['ismailed'] = 0;
      //$this->db->insert('i_notification',$data_email);
      if ($this->db->insert('i_notification',$data_email)) {
          return true;
      } else {
          return false;
      }
  }

  public function index() {
      $id = $this->session->ID_VENDOR;
      $get_menu = $this->mvn->menu();
      $data_vendor = $this->mse->get_supplier_account($this->session->ID);

      $dt = array();
      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
          $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
      }
      $data['menu'] = $dt;
      $data['data_vendor'] = $data_vendor;
      $this->template->display_vendor('vn/info/V_supplier_account', $data);
  }

  public function get_supplier_account(){
    $idx = $this->session->ID;
    $data_vendor = $this->mse->get_supplier_account($idx);
    echo json_encode($data_vendor);
  }

  public function update(){
    $email = $this->input->post("email");
    $password = $this->input->post("password");
    $re_password = $this->input->post("re_password");
    $res = array();
    if ($password === $re_password) {
      $data = array(
        'ID_VENDOR' => $email,
        'PASSWORD' => stripslashes(str_replace('/', '_', crypt($password, mykeyencrypt))),
      );
      $query = $this->mse->update($data);
      if ($query) {
        // sendMail
        $content = $this->M_invitation->show_temp_email(69);
        $email = $this->M_invitation->get_email($this->session->ID);

        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $url = "<a href='http:" . base_url() . "' class='btn btn-primary btn-lg'>Go To Login</a>";
        $data_email = array(
            'email' => $email->ID_VENDOR,
            'img1' => $img1,
            'img2' => $img2,
            'pass' => $password,
            'link' => $url,
            'title' => $content->TITLE,
            'open' => $content->OPEN_VALUE,
            'close' => $content->CLOSE_VALUE
        );
          $this->sendMail($data_email);

        $res['success'] = true;
        $res['password'] = true;
      } else {
        $res['success'] = false;
        $res['password'] = false;
      }
    } else {
      $res['success'] = false;
      $res['password'] = false;
    }

    echo json_encode($res);
  }

}
