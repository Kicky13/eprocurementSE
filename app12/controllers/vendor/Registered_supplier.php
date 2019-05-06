<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Registered_supplier extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('vendor/M_registered_supplier', 'mrs');
        $this->load->model('vendor/M_send_invitation');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_invitation');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('vendor/M_approve_update', 'mau');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_status($status) {
        foreach ($status as $k => $v) {
            $stts[$v->STATUS]['IND'] = $v->DESCRIPTION_IND;
            $stts[$v->STATUS]['ENG'] = $v->DESCRIPTION_ENG;
        }
        return $stts;
    }

    public function get_data($id) {
        $res = $this->mrs->get_legal($id);
        $slka=$this->mrs->get_slka_data($id);
        $data = array();
        $data2 = array();
        $cnt=0;
        $ktr=array(
            '','','',''
        );
        $branch=array();
        foreach($res as $row) {
            if (!isset($output[$row['ID']])) {
                // Form the desired data structure
                if(strcmp($row['BRANCH_TYPE'],'KANTOR PUSAT') == 0)
                {
                    $ktr[1]=$row['ADDRESS'];
                    $ktr[2]=$row['FAX'];
                    $ktr[3]=$row['TELP'];
                }
                else
                {
                    $branch[0]=$row['BRANCH_TYPE'];
                    $branch[1]=$row['ADDRESS'];
                    $branch[2]=$row['FAX'];
                    $branch[3]=$row['TELP'];
                }
                $data[0] = [
                    "GEN" => [
                        $row['NAMA'],
                        $row['PREFIX'],
                        $row['CLASSIFICATION'],
                        $row['CUALIFICATION'],
                        $row['CUALIFICATION'],
                        $ktr[1],
                        $ktr[2],
                        $ktr[3]
                    ],
                    "NPWP" => [
                        $row['NO_NPWP'],
                        $row['NOTARIS_ADDRESS'],
                        $row['NPWP_PROVINCE'],
                        $row['NPWP_CITY'],
                        $row['POSTAL_CODE'],
                        $row['NPWP_FILE']
                    ],
                ];
                $data2[$row['CATEGORY']]= array(
                        $row['TYPE'],
                        $row['VALID_SINCE'],
                        $row['VALID_UNTIL'],
                        $row['CREATOR'],
                        $row['NO_DOC'],
                        $row['FILE_URL'],
                );
            }
            $cnt++;
        }
        foreach($slka as $k => $v)
        {

            $data3[0]=[
                "SLKA" =>[
                    str_replace("XXXX",$v->NO_SLKA,$v->OPEN_VALUE),
                    str_replace("XXXX",$v->NO_SLKA,$v->CLOSE_VALUE),
                    DateTime::createFromFormat('Y-m-d H:i:s',$v->SLKA_DATE)->format('d F Y')
                ]
            ];
        }
        $data=array_merge($data, $data3);
        $data=array_merge($data, $data2);
        if($data[0]['GEN'][5] == '' && count($branch)>0)
        {
            $data[0]['GEN'][6]=$row['ADDRESS'];
            $data[0]['GEN'][7]=$row['FAX'];
            $data[0]['GEN'][8]=$row['TELP'];
        }
        $this->output($data);
    }

    public function show() {
        $data = $this->mrs->show2($this->input->get('id'));
        if ($data) {
            $dt = array();
            $k=0;
            foreach ($data as $row) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $row['NO_SLKA'];
                $dt[$k][2] = $row['ID_EXTERNAL'];
                $dt[$k][3] = $row['NAMA'];
                $dt[$k][4] = $row['PREFIX'];
                $dt[$k][5] = $row['CLASSIFICATION'];
                $dt[$k][6] = $row['email'];
                $dt[$k][7] = $row['status_doc'];
                if ($row['status_doc']) {
                    $tmp='&nbsp<button data-toggle="modal" title="Send Email" onclick="send_mail(\'' . $row['ID'] . '\',\'' . $row['email'] . '\')" class="btn btn-sm btn-primary">Send</i></button>';
                    $tmp.='&nbsp<button data-toggle="modal" title="Document Expired" onclick="document_expired(\''.$row['ID'].'\')" class="btn btn-sm btn-warning">Exp. Document</button>';
                } else {
                    $tmp = '&nbsp<button data-toggle="modal" title="Send Email" class="btn btn-sm btn-success" disabled>Resend</button>';
                    $tmp .= '&nbsp<button data-toggle="modal" title="Document Expired" class="btn btn-sm btn-warning" disabled>Exp. Document</button>';
                }
                $dt[$k][8] = '<button data-toggle="modal" title="Document Detail" onclick="detail(\'' . $row['ID'] . '\',\'' . $row['email'] . '\')" class="btn btn-sm btn-info">Detail</button>'
                        . '&nbsp<button data-toggle="modal" title="Edit" onclick="edit_data(\'' . $row['ID'] . '\', \'' . $row['email'] . '\')" class="btn btn-sm btn-warning">Edit Account</button>'
                        . '&nbsp'.$tmp;
                $k++;

                //<button data-toggle="modal" title="Delete" onclick="delete_data(\'' . $row['ID'] . '\')" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
            }
            $this->output($dt);
        } else {
            $this->output();
        }
    }

    public function add_kontak() {
        $result = false;
        if ($this->input->post('api') == 'insert') {
            $data_kontak = array(
                'ID_VENDOR' => stripslashes($this->input->post('VENDOR')),
                'NAMA' => stripslashes($this->input->post('NAMA')),
                'JABATAN' => stripslashes($this->input->post('JABATAN')),
                'TELP' => stripslashes($this->input->post('TELP')),
                'EXTENTION'=> stripslashes($this->input->post('EXTENTION')),
                'HP' => stripslashes($this->input->post('HP')),
                'EMAIL' => stripslashes($this->input->post('EMAIL')),
                'CREATE_BY' => $this->session->ID,
                'STATUS' => "1"
            );
            $result = $this->mrs->add_data_kontak($data_kontak);
            $this->output($result);
        } else {
            $this->output("failed");
        }
    }

    public function send_email()
    {
        $email=stripslashes($this->input->post('email'));
        $id=stripslashes($this->input->post('id'));
        $content=$this->mrs->get_email_dest(22);
        // $data=$this->mrs->get_data_exp($id);
        $data = $this->mrs->get_document_expired($id);

        $all=array();
        $all['msg']='<table>
            <thead>
                <tr>
                    <th style="text-align:center">No</th>
                    <th style="text-align:center">Document No</th>
                    <th style="text-align:center">Tipe Dokumen</th>
                    <th style="text-align:center">Berakhir Tanggal</th>
                </tr>
            </thead>
            <tbody>
        ';
        $tamp='';
        if($data != false)
        {
            foreach($data as $k => $v){
                $all['msg'] .= '<tr>
                <td style="text-align:center">'.($k+1).'</td>
                <td style="text-align:center">'.$v->NO_DOC.'</td>
                <td style="width:200px;text-align:center"> '.$v->CATEGORY.' </td>
                <td style="text-align:center">'.$v->VALID_UNTIL.'</td>';
                $tamp = $v->CATEGORY;
            }
        }
        $all['msg'].='</tbody></table>';
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
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $open=str_replace('var_1',$all['msg'],$content[0]->OPEN_VALUE);

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
        $this->email->subject($content[0]->TITLE);
        $ctn = ' <p>' .$img1 . '<p>
                        <br>' . $open . '
                        <br>
                        ' . $content[0]->CLOSE_VALUE . '
                        <br>
                        <center><p>' . $img2 . '<p><center>';
        $data_email['recipient'] = $email;
        $data_email['subject'] = $content[0]->TITLE;
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;
        $data_email['doc_type'] = '%';
        $this->email->to($email);
        if ($this->db->insert('i_notification',$data_email)) {
            $this->output(array('msg'=>"Notificaion send ","status"=>'success'));
        } else {
            $this->output(array('msg'=>"Notificaion not send ","status"=>'failed'));
        }
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

    public function edit_data() {
        $this->load->library('encryption');

        $id = $this->input->post('edit_supp_id');
        $mail = $this->input->post('edit_supp_user');
        $pass = $this->input->post('edit_supp_pass');
        $check = $this->mrs->verify_mail($id, $mail);

        if (count($check) > 0) {
            $this->output(array('msg' => 'Email already exists!', 'status' => 'Failed'));
        } else {
            $data['ID_VENDOR'] = $mail;
            $data['UPDATE_BY'] = $this->session->userdata('ID_USER');
            $data['UPDATE_TIME'] = date('Y-m-d H:i:s');
            if (strlen($pass) > 0)
                $data['PASSWORD'] = stripslashes(str_replace('/', '_', crypt($pass, mykeyencrypt)));

            if ($this->mrs->edit_data($id, $data)) {

              // sendMail
              $content = $this->M_invitation->show_temp_email(69);
              $email = $this->M_invitation->get_email($id);

              $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
              $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
              $url = "<a href='http:" . base_url() . "' class='btn btn-primary btn-lg'>Go To Login</a>";
              $data = array(
                  'email' => $email->ID_VENDOR,
                  'img1' => $img1,
                  'img2' => $img2,
                  'pass' => $pass,
                  'link' => $url,
                  'title' => $content->TITLE,
                  'open' => $content->OPEN_VALUE,
                  'close' => $content->CLOSE_VALUE
              );
                $this->sendMail($data);
                $this->output(array('msg' => 'Data has been updated!', 'status' => 'Success'));
            } else {
                $this->output(array('msg' => 'Oops, something went wrong!', 'status' => 'Failed'));
            }
        }
    }

    public function delete()
    {
        $id=  stripslashes($this->input->post('id'));
        $dt=array(
          "STATUS"=>'0'
        );
        $res=$this->mrs->delete($id,$dt);
        if($res)
            $this->output($res);
        else
            $this->output(false);
    }

    public function search()
    {
        $API=  stripslashes($this->input->post('API'));
        $id=stripslashes($this->input->post('ID'));
        if($API == "SELECT")
        {
            $res=$this->mrs->get_data($id);
            if($res != false)
            {
                $this->output($res);
            }
            else
                $this->output(false);
        }
        else
        {
            $this->output(false);
        }
    }

    public function get_qr($id)
    {
        $this->load->library('phpqrcode/qrlib');
        $res=$this->mrs->get_slka($id);
        if($res!=false)
        {
            $qr=md5($res[0]->NO_SLKA);
            $svgCode = QRcode::png('http:'.base_url().'show_qr?q='.$qr);
        }
        else
            $this->output(false);
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $data['vendor'] = [];
        $data['menu'] = [];
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('vendor/V_registered_supplier', $data);
    }

    public function datakontakperusahaan($id) {
        $data = $this->mau->datakontakperusahaan($id);
        $dt = array();
        $base = base_url();
        $btn='';
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAMA);
            $dt[$k][2] = stripslashes($v->JABATAN);
            $dt[$k][3] = stripslashes($v->TELP);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->HP);
            if($v->NOTIFICATION == 0)
                $btn="<button class='btn btn-sm btn-primary' onclick=set(".$v->ID_VENDOR.",".$v->KEYS.")>Set</button";
            else
                $btn="<button class='btn btn-sm btn-danger' onclick=unset(".$v->ID_VENDOR.",".$v->KEYS.")>Unset</button";
            $dt[$k][6] = $btn;
        }
        $this->output($dt);
    }

    public function set_notif()
    {
        $sel=stripslashes($this->input->post('sel'));
        $id=stripslashes($this->input->post('email'));
        $key=stripslashes($this->input->post('key'));
        $dt=array();
        if($sel == 'SET')
            $dt=array('NOTIFICATION'=>'1');
        else
            $dt=array('NOTIFICATION'=>'0');
        $res=$this->mrs->set_notif($id,$key,$dt);

        if($res ==  false)
            $this->output(array('Status'=>'Error','msg'=>'Oops,Something wrong'));
        else
            $this->output(array('Status'=>'Success','msg'=>'Data Saved'));
    }

    public function document_expired($id) {
        $result = $this->mrs->get_document_expired($id);
        $this->load->view('vendor/V_document_expired', array(
            'result' => $result
        ));
    }


    public function send_email_auto()
    {
        /*$email=stripslashes($this->input->post('email'));
        $id=stripslashes($this->input->post('id'));*/
        $email='';
        $doc_type='';
        $content=$this->mrs->get_email_dest(22);
        $data=$this->mrs->get_data_exp_auto();
        $all=array();
        $all['msg']='<table>
            <thead>
                <tr>
                    <th style="text-align:center">No</th>
                    <th style="text-align:center">Document Type</th>
                    <th style="text-align:center">Document No</th>
                    <th style="text-align:center">Expired Until</th>
                    <th style="text-align:center">Status</th>
                </tr>
            </thead>
            <tbody>
        ';
        $tamp='';
        if($data != false)
        {
            foreach($data as $k => $v){
                $email = $v->EMAIL;
                $doc_type = $v->CATEGORY;
                $all['msg'].='<tr><td style="text-align:center">'.($k+1).'</td>
                                    <td style="width:200px;text-align:center"> '.$v->CATEGORY.' </td>
                                    <td style="width:200px;text-align:center"> '.$v->NO_DOC.' </td>
                                    <td style="width:200px;text-align:center"> '.$v->VALID_UNTIL.' </td>
                                    <td style="text-align:center">'.$v->STATUS_DOCUMENT.'</td>
                              </tr>';
                $tamp=$v->CATEGORY;
            }
        }
        $all['msg'].='</tbody></table>';
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
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $open=str_replace('var_1',$all['msg'],$content[0]->OPEN_VALUE);

        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
        $this->email->subject($content[0]->TITLE);
        $ctn = ' <p>' .$img1 . '<p>
                        <br>' . $open . '
                        <br>
                        ' . $content[0]->CLOSE_VALUE . '
                        <br>
                        <center><p>' . $img2 . '<p><center>';
        $data_email['recipient'] = $email;
        $data_email['subject'] = $content[0]->TITLE;
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;
        $data_email['doc_type'] = $doc_type;
        $this->email->to($email);
        if ($email!='') {
            $this->db->insert('i_notification',$data_email);
        }

    }
}
