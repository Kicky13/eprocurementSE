<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approval extends CI_Controller {

    protected $itemNumber = "";
    protected static $valueNextNumber = 0;

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('global_helper');
        $this->load->model('vendor/M_approval', 'map')->model('vendor/M_vendor')->model('vendor/M_invitation')->model('vn/info/M_all_vendor', 'mav');
        $this->load->model('vendor/M_show_vendor', 'msv');
        $this->load->model('vendor/m_all_intern', 'mai');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function get_csms() {
        if ($this->input->post('API') == 'SELECT') {
            $id=  stripslashes($this->input->post('id'));
            $res = $this->msv->get_csms($id);
            if ($res == false)
                $this->output(null);
            else
                $this->output($res[0]);
        } else
            $this->output(null);
    }

    public function show_contact($data) {
        $result = $this->map->get_contact($data);
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $tamp = $k + 1;
                $dt[$k][0] = $tamp;
                $dt[$k][1] = $v->NAMA;
                $dt[$k][2] = $v->JABATAN;
                $dt[$k][3] = $v->TELP;
                $dt[$k][4] = $v->EMAIL;
                $dt[$k][5] = $v->HP;
            }
        }
        $this->output($dt);
    }

    public function show_address($data) {
        $result = $this->map->get_address($data);
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->BRANCH_TYPE;
                $dt[$k][2] = $v->ADDRESS;
                $dt[$k][3] = $v->COUNTRY;
                $dt[$k][4] = $v->PROVINCE;
                $dt[$k][5] = $v->CITY;
                $dt[$k][6] = $v->POSTAL_CODE;
                $dt[$k][7] = $v->TELP;
                $dt[$k][8] = $v->HP;
                $dt[$k][9] = $v->FAX;
                $dt[$k][10] = $v->WEBSITE;
            }
        }
        $this->output($dt);
    }

    public function show_akta($data) {
        $result = $this->map->get_akta($data);
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->NO_AKTA;
                $dt[$k][2] = $v->AKTA_DATE;
                $dt[$k][3] = $v->AKTA_TYPE;
                $dt[$k][4] = $v->NOTARIS;
                $dt[$k][5] = $v->ADDRESS;
                $dt[$k][6] = $v->VERIFICATION;
                $dt[$k][7] = $v->NEWS;
                $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></button>';
                $dt[$k][9] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></button>';
                $dt[$k][10] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-info-circle"></i></button>';
            }
        }
        $this->output($dt);
    }

    public function show() {
        $data = $this->map->show();
        if ($data != false) {
            $dt = array();
            $k=0;
            foreach ($data as $row) {
                $dt_note = $this->M_invitation->show_log_vendor_acc($row['ID_VENDOR']);
                if ($row['FILE'] != '') {
                  $attch_file = '<a href="'.base_url("upload/LEGAL_DATA/").$row['FILE'].'" target="_blank" class="btn btn-info btn-sm" title="View File" >Download</a>';
                } else {
                  $attch_file = "-";
                }
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $row['nama'];
                $dt[$k][2] = $row['ID_VENDOR'];
                $dt[$k][3] = $row['description'];
                $dt[$k][4] = dateToIndo($row['CREATE_TIME'], false, true);
                $dt[$k][5] = $attch_file;
                $dt[$k][6] = $dt_note['NOTE'];
                if((($row['sequence']==4)&&($row['module']==1))||(($row['sequence']==1)&&($row['module']==2))){
                    $pil=1;
                }
                else{
                    $pil=0;
                }
                if(($row['sequence']<4)&&($row['module']==1))
                {
                    $dt[$k][7] ='<a class="btn btn-success btn-sm" title="Approve" href="javascript:void(0)" onclick="accept_inv(\'' . $row['supplier_id']. '\',\'' . $row['ID_VENDOR']. '\',\'' . $row['id']. '\',\'' . $row['sequence']. '\')">Approve</a>'
                    . ' <a class="btn btn-danger btn-sm" title="Reject" href="javascript:void(0)" onclick="reject_inv(\'' . $row['supplier_id']. '\',\'' . $row['ID_VENDOR']. '\',\'' . $row['id']. '\',\'' . $row['sequence']. '\')">Reject</a>';
                }
                else
                    $dt[$k][7] = '</a> <button data-toggle="modal" onclick="detail(\'' . $row['supplier_id']. '\',\'' . $row['ID_VENDOR']. '\',\'' . $row['id']. '\','.$pil.',\'' . $row['sequence']. '\')" class="btn btn-sm btn-info" title="Process">Process</button> ';
                $k++;
            }
            $this->output($dt);
        } else {
            $this->output();
        }
    }

    public function check_risk()
    {
        $id=$this->input->post('id');
        $res=$this->map->check_risk($id);
        $this->output($res);
    }

    protected function sendMail($content,$sel) {
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

        //1
        if ($sel==1 && count($content['dest']) != 0 ) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn =' <p>' . $content['img1'] . '<p>
                        <br>' . $open = str_replace("_var1_", $content['nama'],$content['open']) . '
                        <br>
                        ' . $content['close'] . '
                        <br>
                        ';

                $data_email['recipient'] = $v->email;
                $data_email['subject'] = $content['title'];
                $data_email['content'] = $ctn;
                $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
        }
        else if($sel==2)
        {

            $this->load->library('email', $config);
            $this->email->initialize($config);
            $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
            $this->email->to($content['dest']);
            $this->email->subject($content['title']);
            $date_until = date('d F Y', strtotime("+" . $content['hari'] . " days", strtotime(date('Y-m-d'))));
		
			switch (base_url()) {
				case "http://eproc-dev.supreme-energy.com/dev_prod/":
					$hyperlink = "http://eproc-dev.supreme-energy.com/dev_vendor/";
					break;
				case "http://eproc-dev.supreme-energy.com/dev_user/":
					$hyperlink = "http://eproc-dev.supreme-energy.com/dev_user_vendor/";
					break;
				case "http://scm.supreme-energy.com/":
					$hyperlink = "http://eproc.supreme-energy.com/";
					break;
				default:
					$hyperlink = base_url();
			}
		
            $url = "<a href='" . $hyperlink . "log_in/index/" . $content['URL'] . "'>Invitation Link</a>";
            $ctn = ' <p>' . $content['img1'] . '<p>
                            <p>' . $content['open'] . '<p>
                            <br>
                            <table>
                                <tr>
                                    <td>Nama Perusahaan</td>
                                    <td>: ' . $content['nama'] . '</td>
                                </tr>
                            </table>
                            <br>
                            <table>
                                <tr>
                                    <td>Username</td>
                                    <td>: ' . $content['dest'] . '</td>
                                </tr>
                                <tr>
                                    <td>Password</td>
                                    <td>: ' . $content['pass_random'] . '</td>
                                </tr>
                                <tr>
                                    <td>Aktif Sampai</td>
                                    <td>:  ' . $date_until . ' (' . date('H:i') . ')</td>
                                </tr>
                                <tr>
                                    <td>Link</td>
                                    <td>:  ' . $url . '</td>
                                </tr>
                            </table>
                            <br>

                            <br>
                            <p>Supreme Energy.</p>
                            ';
            $data_email['recipient'] = $content['dest'];
            $data_email['subject'] = $content['title'];
            $data_email['content'] = $ctn;
            $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
        }
        else{
          if (count($content['dest']) > 1) {
            foreach ($content['dest'] as $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->to($v);
                $this->email->subject($content['title']);
                $ctn =' <p>' . $content['img1'] . '<p>
                        <br>'.$content['open'].'
                        <br>
                        '.$content['close'].'
                        <br>
                        ';
                $this->email->to($v);

                $data_email['recipient'] = $v;
                $data_email['subject'] = $content['title'];
                $data_email['content'] = $ctn;
                $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
            }
          } else {
            $this->load->library('email', $config);
            $this->email->initialize($config);
            $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
            $this->email->subject($content['title']);
            $ctn =' <p>' . $content['img1'] . '<p>
                    <br>' . $content['open'] . '
                    <br>
                    ' . $content['close'] . '
                    <br>
                    ';

            if (is_array($content['dest'])){
                $data_email['recipient'] = $content['dest'][0];
            }else{
                $data_email['recipient'] = $content['dest'];
            }
            $data_email['subject'] = $content['title'];
            $data_email['content'] = $ctn;
            $data_email['ismailed'] = 0;

                if ($this->db->insert('i_notification',$data_email)) {
                    $flag = 1;
                } else {
                    $flag = 0;
                }
          }

        }

        if ($flag == 1)
            return true;
        else
            return false;
    }

    public function getlist($id_vendor) {
        $tot_un_apv = 0;
        $total = 0;
        $flag=0;
        $eng='Required';
        $ind='Wajib';
        // $res=$this->map->get_checklist($id_vendor);
        $info=$this->map->get_vendor_info($id_vendor);
        $val_btn = 0;
        $dt = array();
        $dt_checklist_user = array();

        $get_idv = $this->db->query("select ID FROM m_vendor WHERE ID_VENDOR = '".$id_vendor."' ");
        $qry_chk = $this->map->get_checklist($get_idv->row()->ID);
        // $res = $this->mav->check_gns();
        $header = $this->mav->get_header();
        $arr_head = array();
        $chk = $qry_chk->result_array();
        // $total = 0;
        $total_checklist = 0;
        $no = 1;
        $flag = 0;
        $split = explode(",", $info[0]->CLASSIFICATION);

        $status_approve = 0;
        // echopre($dt_checklist_user);

        echo'
        <input style="display : none;" value="' . $tot_un_apv . '" name="tot_un_apv" id="tot_un_apv">
        <input style="display : none;" value="' . $total . '" name="tot_none" id="tot_none">
        <input style="display : none;" value="' . $val_btn . '" name="validate_btn" id="validate_btn">
        <table class="table table-striped table-bordered table-hover display" width="100%">
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>' . lang('Deskripsi', 'Description') . '</th>
                <th><span>Status</span></th>
                <th>' . lang('Verifikasi', 'Check') . '</th>
            </tr>
        </thead>
        <tbody>';
        foreach ($header as $key => $value) {

          echo '<tr>
                   <td colspan="5" class="text-centered"><h5><b>'.$value['code'].'. '.$value['description'].'</b></h5></td>
               </tr>';

               foreach ($chk as $arr) {
                 if ($value['description'] == $arr['description']) {

                   if ($arr['TOTAL'] === null) {
                     $status = '<a href="#"><i class="fa fa-minus text-secondary"></i></a>';
                   } elseif ($arr['TOTAL'] > 0) {
                     $status_approve = 1;
                     $status = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
                     if ($arr['ismandatory'] == 1) {
                       $total_checklist+= 1;
                     }
                   } else {
                     $status_approve = 0;
                     $status = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
                   }


                   $total += $arr['ismandatory'];
                   // $total_checklist += $arr['TOTAL'];

                   $tbody = '<tr class="tr-'.str_replace(' ', '_', strtolower($arr['DESC_ENG'])).'">
                             <td>' . $no++ . '.</td>
                             <td>' . $arr['DESC_ENG'] . '</td>
                             <td>' . $arr['STATUS'] . '</td>
                             <td>' . $status . '</td>
                             </tr>';


                   // if($arr["DESC_ENG"] === "Goods" ) {
                   //     if(in_array('Penyedia Barang', $split, true)){
                   //       echo $tbody;
                   //     } else {
                   //
                   //     }
                   // }
                   // else if($arr["DESC_ENG"] === "Services") {
                   //   if(in_array('Jasa Pemborongan', $split, true)){
                   //     echo $tbody;
                   //   } elseif (in_array('Penyedia Jasa', $split, true)) {
                   //     echo $tbody;
                   //   } else {
                   //
                   //   }
                   // }
                   // else if($arr['DESC_ENG'] === "Consultant Service") {
                   //   if(in_array('Konsultan', $split, true)){
                   //     echo $tbody;
                   //   } else {
                   //
                   //   }
                   // }
                   // else {
                   //   echo $tbody;
                   //   // echo $res[0]->CLASSIFICATION;
                   // }
                   echo $tbody;
                 }
               }
        }

        echo '<tr style="display:none"><td style="display:none"><input id="status_approve" value=' . $status_approve . '><input id="total_wajib" value=' . $total . '><input id="total_check_mandatory" value=' . $total_checklist . '></tr></td>';
        echo '</tbody></table>';
        exit;
    }


    // public function getlist($id_vendor) {
    //     $tot_un_apv = 0;
    //     $total = 0;
    //     $flag=0;
    //     $eng='Required';
    //     $ind='Wajib';
    //     $res=$this->map->get_checklist($id_vendor);
    //     $info=$this->map->get_vendor_info($id_vendor);
    //     $val_btn = 0;
    //     $dt=array();
    //     if($res['RISK']==0)
    //     {
    //         $flag=1;
    //         $eng='Optional';
    //         $ind='Kondisional';
    //     }
    //     foreach ($res as $k => $v) {
    //         if ($v == 1) {
    //           // $dt['val_btn'] = 1;
    //             $dt[$k] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
    //         } else if ($v == '') {
    //             $total++;
    //             // $dt['val_btn'] = 2;
    //             $dt[$k] = '<a href="#"><i></i></a>';
    //             if(($k == 'CSMS' && $flag==1) || $k =='RISK')
    //             {
    //               // $dt['val_btn'] = 1;
    //                 $dt[$k] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
    //                 $total--;
    //             }
    //         } else if ($v == 0) {
    //             $tot_un_apv++;
    //             // $dt['val_btn'] = 0;
    //             $dt[$k] = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
    //             if(($k == 'CSMS' && $flag==1) || $k =='RISK'){
    //                 $tot_un_apv--;
    //             }
    //         }
    //     }
    //
    //     if(strpos(strtolower($info[0]->CLASSIFICATION),'barang') === false){
    //         $tot_un_apv--;
    //         $total--;
    //         $str_goods = 'Optional';
    //     } else {
    //       $str_goods = 'Required';
    //     }
    //     if(strpos(strtolower($info[0]->CLASSIFICATION),'jasa') === false){
    //         $tot_un_apv--;
    //         $total--;
    //         $str_jasa = 'Optional';
    //     } else {
    //       $str_jasa = 'Required';
    //     }
    //
		// $rep_data = array_replace($res,array_fill_keys(array_keys($res, null), 2));
		// //var_dump($rep_data);
    // $count = array_count_values($rep_data);
    //
		// if(array_key_exists(1, $count)) {
		// if ($flag == 1) { $leng = $count[1] >= 20; } else { $leng = $count[1] >= 21; }
    //   if ($leng) {
    //     $val_btn = 0;
    //   } else {
    //     $val_btn = 1;
    //   }
    // } else {
    //   $val_btn = 1;
    // }
    // // echopre($leng);
    //
    //     echo '
    //                         <input style="display : none;" value="' . $tot_un_apv . '" name="tot_un_apv" id="tot_un_apv">
    //                         <input style="display : none;" value="' . $total . '" name="tot_none" id="tot_none">
    //                         <input style="display : none;" value="' . $val_btn . '" name="validate_btn" id="validate_btn">
    //                         <table class="table table-striped table-bordered table-hover display" width="100%">
    //                             <thead>
    //                                 <tr>
    //                                     <th>#</th>
    //                                     <th>' . lang('Deskirpsi', 'Description') . '</th>
    //                                     <th><span>Status</span></th>
    //                                     <th>' . lang('Verifikasi', 'Check') . '</th>
    //                                 </tr>
    //                             </thead>
    //                             <tbody>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>A. General Information</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>Company Information</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['GENERAL1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>2.</td>
    //                                     <td>Company Address</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['GENERAL2'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>3.</td>
    //                                     <td>Company Contact</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['GENERAL3'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>B. Data Legal</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>Deed</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['LEGAL1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>2.</td>
    //                                     <td>Bussiness License </td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['LEGAL2'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>3.</td>
    //                                     <td>TDP</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['LEGAL3'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>4.</td>
    //                                     <td>NPWP</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['LEGAL4'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>5.</td>
    //                                     <td>' . lang('Direktorat Panas Bumi', 'Geothermal Directorate') . '</td>
    //                                     <td>' . lang('Kondisional', 'Optional') . '</td>
    //                                     <td>' . $dt['LEGAL5'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>6.</td>
    //                                     <td>' . lang('SKT MIGAS (Dirjen Minyak & Gas Bumi)', 'Oil and Gas Certificate') . '</td>
    //                                     <td>' . lang('Kondisional', 'Optional') . '</td>
    //                                     <td>' . $dt['LEGAL6'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>7.</td>
    //                                     <td>SPPKP</td>
    //                                     <td>' . lang('Kondisional', 'Optional') . '</td>
    //                                     <td>' . $dt['LEGAL7'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>8.</td>
    //                                     <td>' . lang('SKT PAJAK', 'Tax Certificate') . '</td>
    //                                     <td>' . lang('Kondisional', 'Optional') . '</td>
    //                                     <td>' . $dt['LEGAL8'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>C. Goods & Service</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>Agency Certification & Principal</td>
    //                                     <td>' . lang('Kondisional', 'Optional') . '</td>
    //                                     <td>' . $dt['GNS1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>2.</td>
    //                                     <td>Goods</td>
    //                                     <td>' . $str_goods . '</td>
    //                                     <td>' . $dt['GNS3'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>3.</td>
    //                                     <td>Services</td>
    //                                     <td>' . $str_jasa . '</td>
    //                                     <td>' . $dt['GNS2'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>D. Bank & Finance</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>Bank Account</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['BNF1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>2.</td>
    //                                     <td>Balance Sheet</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['BNF2'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>E. Company Mangement</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>List of Board of Directors</td>
    //                                     <td>' . lang('Wajib', 'Required') . '</td>
    //                                     <td>' . $dt['MANAGEMENT1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>2.</td>
    //                                     <td>List of Shareholders</td>
    //                                     <td>' . lang('Kondisinoal', 'Optional') . '</td>
    //                                     <td>' . $dt['MANAGEMENT1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>F. Certification & Experience</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>General Certification</td>
    //                                     <td>' . lang('Kondisional', 'Optional') . '</td>
    //                                     <td>' . $dt['CNE1'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>2.</td>
    //                                     <td>Company Experience</td>
    //                                     <td>' . lang('Kondisinoal', 'Optional') . '</td>
    //                                     <td>' . $dt['CNE2'] . '</td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td colspan="5" class="text-centered"><b>G. Contractor SHE Mangement System (CSMS)</b></td>
    //                                 </tr>
    //                                 <tr>
    //                                     <td>1.</td>
    //                                     <td>CSMS</td>
    //                                     <td>' . lang($ind,$eng) . '</td>
    //                                     <td>' . $dt['CSMS'] . '</td>
    //                                 </tr>
    //                             </tbody>
    //                         </table>';
    // }

    public function ambil_attch_vendor($id){
        // $id = $this->input->post("idx");
        $data = $this->map->attch_vendor($id);
        $dt = array();
        $no = 1;
        foreach ($data as $value) {
          $type_file = pathinfo($value->FILE_URL);
          echo '<tr>
                  <td scope="row">'.$no++.'</td>
                  <td>'.$type_file['extension'].'</td>
                  <td>'.stripslashes($value->DESCRIPTION).'</td>
                  <td>'.stripslashes($value->FILE_URL).'</td>
                  <td><button class="btn btn-sm btn-primary" data-toggle="modal"  onclick="review_akta(\'' . base_url("upload/CSMS/").$value->FILE_URL . '\')" title="Preview File" id="aksi1" data-id='.stripslashes($value->ID).'><i class="fa fa-chevron-circle-right"></i></button></td>
                </tr>';
        }
        exit;
    }

    public function change_btn($status) {
        $id=stripslashes($this->input->post('id_vendor'));
        $idT=stripslashes($this->input->post('idT'));
        $seq=stripslashes($this->input->post('seq'));
        $module=$this->db->query("select distinct(module) as module from t_approval_supplier where supplier_id='".$this->input->post('id_vendor')."' and status_approve=0 ")->result();
        $flag_ver=0;
        if($status == 8)
        {
            $un_apv=$this->input->post('tot_un_apv');
            $apv_none=$this->input->post('tot_none');
            if($apv_none > 0){
                $this->output(array('status'=>'Error','msg'=>'Oops,Masih ada data yang belum di verifikasi'));
            }
            if($un_apv > 0){
                $status=13;
            }
            else
            {
                $status=7;
                $flag_ver=1;
            }
        }
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";
        $upd = array(
            'status_approve' =>'1',
            'note' => $this->input->post('note'),
            'updatedate' => date('Y-m-d H:i:s'),
        );
        $dt_email=null;


        $content=$this->map->get_email_dest($id,$idT,$status,$seq);

        $rec=$content[0]['recipients'];


        if (($seq >= 1 && $seq < 4) && $status == 13) {
          // email reject sequence 1 - 3
          $content2 = $this->map->get_email_reject($seq, $id);
          $var_link = "<br><br>Klik link berikut untuk memproses <a href='" . base_url() . "in' class='btn btn-primary btn-lg'>Link Portal</a><br><br>";
          $note_reject = '<br> Supplier : '.$content2[0]->VENDOR.'
                          <br> Dengan catatan :  '.$this->input->post('note').'. <br> Mohon untuk melakukan perbaikan data, ';
          $data = array(
              'id' => $id,
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content2[0]->TITLE,
              'open' => str_replace('_var1_', $note_reject, $content2[0]->OPEN_VALUE.$var_link),
              'close' => $content2[0]->CLOSE_VALUE,
          );
          foreach ($content2 as $k => $v) {
              $data['dest'][] = $v->EMAIL;
          }
        } else {
          // email reject sequence 4 - 6
          if((($seq==3 || $seq==6)&&($module[0]->module==1))||($status == 13)){
            $res = $_POST['email'];
            if ($seq == 3 && $status == 9) {
              $var_link = ' ';
            } else {
              $var_link = "<br><br>Klik link berikut untuk memproses <a href='" . base_url() . "' class='btn btn-primary btn-lg'>Link Portal</a><br><br>";
            }
          } else{
            $res = $this->map->get_email_rec($rec);
            $var_link = "<br><br>Klik link berikut untuk memproses <a href='" . base_url() . "in' class='btn btn-primary btn-lg'>Link Portal</a><br><br>";
          }

          $note = '<br> Supplier : '.$content[0]['NAMA'].'
                   <br> Note :  '.$this->input->post('note').' ';
          $data = array(
              'id' => $id,
              'hari' => $content[0]['hari'],
              'nama' => $content[0]['NAMA'],
              'dest' => $res,
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content[0]['TITLE'],
              'open' => str_replace('_var1_', $note, $content[0]['OPEN_VALUE'].$var_link),
              'close' => $content[0]['CLOSE_VALUE']
          );
        }

        // sendmail
        if ($rec != null && $seq!=3 && $seq!=6 && $status!=13) {
          //ngirim user internal notifikasi
          $data['user']=$_POST['email'];
          $flag = $this->sendMail($data,1);
        } elseif (($seq >= 1 && $seq <= 3) && $status == 13) {
          $data['user']=$_POST['email'];
          $flag = $this->sendMail($data,3);
        } elseif (($seq >= 4 && $seq <= 6) && $status == 13) {
          // reject sequence 4 - 6 (kirim ke supplier)
          $data['user']=$_POST['email'];
          $flag = $this->sendMail($data,3);
        } elseif(($seq == 3)&&($module[0]->module==1)&&($status != 13)) {
          // Ngirim ke vendor utk isi form
          $pass_random = rand(100000, 999999);
          $pass = stripslashes(str_replace('/','_',crypt($pass_random, mykeyencrypt)));
          $data['pass_random']=$pass_random;
          $data['pass']=$pass;
          date_default_timezone_set("Asia/Jakarta");
          $mini_url = date("HiY") . rand(100000000, 999999999) . date("md") . $id;
          $data['URL']=$mini_url;
          $res=$this->map->set_pswd($data);
          $flag = $this->sendMail($data,2);
        } elseif ($seq == 6 && $status == 7) {
          // Ngirim ke vendor lulus admin
          $data['user']=$_POST['email'];
          //$flag = $this->sendMail($data,10);
          $flag=true;
        } else {
          $flag = true;
        }

        /*if(($rec != null && $status != 13 && $status != 9)||$flag_ver==1)
            $res=$this->map->get_email_rec($rec);
        else
            $res=$_POST['email'];
        */


        // Terkait Email
        // if($rec != null && $seq!=3 && $seq!=6 && $status!=13)
        // {
        //     //ngirim user internal notifikasi
        //     $data['user']=$_POST['email'];
        //     $flag = $this->sendMail($data,1);
        //     // echopre('approve');
        //     // exit;
        // }
        // else if((($seq == 4)&&($module[0]->module==1)&&($status == 13))){
        //     // Ngirim ke vendor reject
        //     // foreach($qq_roles as $val) {
        //     //   $data['user'][] = $val->EMAIL;
        //     // }
        //     // $flag = $this->sendMail($data,3);
        //     // echopre('reject');
        //     // exit;
        //
        //     $data['user']= $qq_roles->row()->EMAIL;
        //     $data['dest']= $qq_roles->row()->EMAIL;
        //     $flag = $this->sendMail($data,3);
        // }
        // else if((($seq !=3)&&($module[0]->module==1))||(($seq ==3)&&($module[0]->module==2))){
        //     // Ngirim ke vendor
        //     // echopre('reject 2');
        //     // exit;
        //
        //     $data['user']= $qq_roles->row()->EMAIL;
        //     $data['dest']= $qq_roles->row()->EMAIL;
        //     $flag = $this->sendMail($data,3);
        // } elseif (($seq == 3)&&($module[0]->module==1)&&($status == 13)) {
        //     $data['user']= $qq_roles->row()->EMAIL;
        //     $data['dest']= $qq_roles->row()->EMAIL;
        //     $flag = $this->sendMail($data,3);
        //     // echopre('reject 4');
        //     // exit;
        // }
        // else if(($seq == 3)&&($module[0]->module==1)&&($status != 13))
        // {
        //     // Ngirim ke vendor utk isi form
        //     $pass_random = rand(100000, 999999);
        //     $pass = stripslashes(str_replace('/','_',crypt($pass_random, mykeyencrypt)));
        //     $data['pass_random']=$pass_random;
        //     $data['pass']=$pass;
        //     date_default_timezone_set("Asia/Jakarta");
        //     $mini_url = date("HiY") . rand(100000000, 999999999) . date("md") . $id;
        //     $data['URL']=$mini_url;
        //     $res=$this->map->set_pswd($data);
        //     $flag = $this->sendMail($data,2);
        //     // echopre('reject 5');
        //     // exit;
        // }

        if($status == 13){ $stts = '12'; } else { $stts = $seq; }
        $data_log=array(
            "ID_VENDOR"=>$id,
            "STATUS"=> $stts,
            "CREATE_TIME"=>date('Y-m-d H:i:s'),
            "CREATE_BY"=>$_SESSION['ID_USER'],
            "TYPE"=>"SUP"
        );
        $note=stripslashes($this->input->post('note'));
        if(isset($note)){
            $data_log['NOTE']=$note;
        }
        $log=$this->map->add('log_vendor_acc',$data_log);
        $upd_stat = false;
        $toJDE = true;
        if(($seq > 1 && $flag && $status !=13)||(($seq==1)&&($module[0]->module==2) && $status !=13))
        {
            $sel=0;
            $upd['seq_strt']=$content[0]['sequence'];
            if($seq != 6)
                $upd['seq_now']=$content[0]['sequence']+1;
            else
                $upd['seq_now']=$content[0]['sequence'];

            if($content[0]['max_seq']==$content[0]['sequence'])
            {

            // ================================ Kirim JDE ==============================
                $dtAlamat = array(
                    'a.ID_VENDOR' => $_POST['id_vendor'],
                    'BRANCH_TYPE' => 'KANTOR PUSAT',
                    'a.STATUS' => 1
                );
                $dt = $this->map->alamatperusahaan($dtAlamat);
                $dt2 = false;
                if ($dt == false) {
                    $dtAlamat = array(
                        'a.ID_VENDOR' => $_POST['id_vendor'],
                        'a.STATUS' => 1);
                    $dt = $this->map->alamatperusahaan($dtAlamat,true);
                }
                $dtCountry = array(
                    'name' => $dt[0]->COUNTRY
                );
                //$dt2 = $this->map->get_Country_Code($dtCountry);

                /*$data_jde = array(
                    'ADDRESS_LINE1' => stripslashes($dt[0]->ADDRESS),
                    'ADDRESS_LINE2' => stripslashes($dt[0]->PROVINCE),
                    'ENTITY_ID' => stripslashes($dt[0]->ID_EXTERNAL), //id angka
                    'CITY' => stripslashes($dt[0]->CITY),
                    'COUNTRY_CODE' => stripslashes($dt[0]->COUNTRY),
                    'POSTAL_CODE' => stripslashes($dt[0]->POSTAL_CODE),
                    'BISNIS UNIT' => 10101,
                    'E_ADDRESS' => stripslashes($_POST['email']),
                    'ENTITY_TAX_ID' => stripslashes($_POST['entity_tax_id']),
                    'ENTITY_NAME' => stripslashes($_POST['entity_name']),
                    'PHONE_NUMBER' => $dt[0]->TELP
                );*/
                if($content[0]['module']==1)
                {
                    $res = $this->msv->get_slka();
                    $num =1;
                    if($res != false) {
                        $num = $res[0]->NO_SLKA + 1;
                        $upd['NO_SLKA'] = str_pad($num,4, '0', STR_PAD_LEFT);
                        $upd['STATUS'] = '7';
                        $upd['SLKA_DATE']=date('Y-m-d H:i:s');
                        $sel=1;
                        // $toJDE = $this->change_jde($data_jde); //upload_JDE
                        $datas['doc_no'] = stripslashes($_POST['id_vendor']);
                        $datas['doc_type'] = 'm_supp';
                        $datas['isclosed'] = 0;
                        $this->db->insert('i_sync',$datas);
                        $upd['ID_EXTERNAL']=self::$valueNextNumber;
                    }
                }
                else if($content[0]['module']==2){
                    // $toJDE = $this->change_jde_update($data_jde); //upload_JDE
                    $datas['doc_no'] = stripslashes($_POST['id_vendor']);
                    $datas['doc_type'] = 'm_supp_edit';
                    $datas['isclosed'] = 0;
                    $this->db->insert('i_sync',$datas);
                }

                $vendor = $this->db->where('ID', $this->input->post('id_vendor'))
                ->get('m_vendor')
                ->row();
                $template = $this->db->where('id', 14)
                ->get('m_notic')
                ->row();
                $mail = $template->OPEN_VALUE.$template->CLOSE_VALUE;
                $this->db->insert('i_notification', array(
                    'recipient' => $vendor->ID_VENDOR,
                    'subject' => $template->TITLE,
                    'content' => str_replace('XXXX', $vendor->NO_SLKA, $mail),
                    'ismailed' => 0
                ));
            }
            else{
                $upd['NO_SLKA']='';
            }

            $upd['module']=$content[0]['module'];
            if($toJDE){
                $upd_stat = $this->map->upd($id,"0",'t_approval_supplier', $upd,0,$sel);
            }

        }
        else if($status == 13 && $flag)
        {
            // Data Ditolak
            $upd['module']=$content[0]['module'];
            $seq=$content[0]['sequence'];
            $seq_last =$content[0]['sequence'];
            $upd['seq_now']=$seq;
            $rej_step=$content[0]['reject_step'];
            if($rej_step != 0){
                $seq=$seq-$rej_step;
            }
            $upd['seq_strt']=$seq;
            $upd['seq_last']=$seq_last;
            $upd['status_approve']=0;
            $upd['extra_case']=1;
            $upd['edit_content']=0;
            $upd_stat = $this->map->upd($id,"1",'t_approval_supplier', $upd,2);
        }
        else{
            $this->output(array('status'=>'Error','msg'=>'Oops,Terjadi Kesalahan pengiriman email'));
        }

        if($upd_stat == false){
            $this->output(array('status'=>'Error','msg'=>'Oops,Terjadi Kesalahan penyimpanan data'));
        }
        else{
            $this->output(array('status'=>'Success','msg'=>'Data berhasil disimpan'));
            // $ressss = array(
            //   'sequence' => $seq,
            //   'sequence_last' => $seq_last,
            //   'status' => $status,
            //   'modul' => $module[0]->module,
            //   'email_post' => $_POST['email'],
            //   'email_content' => $haha,
            //   'recipient' => $this->map->get_email_rec($rec),
            // );
            // echo json_encode($ressss);
        }
    }

    public function requestJDE_insertSupplier() {
        ini_set('max_execution_time', 300);
        error_reporting(0);
        ini_set('display_errors', 0);
        $req_no = "";
        $result = true;
        $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='m_supp' and isclosed=0 limit 1");
        if($query_check_out->num_rows()>0){
             $result_check = $query_check_out->result();
            $req_no = $result_check[0]->doc_no;
            $query_select_supp = $this->db->query("select b.*,a.NAMA, a.ID, a.ID_VENDOR, a.NO_SLKA, CASE WHEN LENGTH(b.ADDRESS)>3 THEN b.ADDRESS ELSE b2.ADDRESS END as ADDRESS, CASE WHEN LENGTH(b.ADDRESS2)>3 THEN b.ADDRESS2 ELSE b2.ADDRESS2 END as ADDRESS2, CASE WHEN LENGTH(b.ADDRESS3)>3 THEN b.ADDRESS3 ELSE b2.ADDRESS3 END as ADDRESS3,
           CASE WHEN LENGTH(b.ADDRESS4)>3 THEN b.ADDRESS4 ELSE b2.ADDRESS4 END as ADDRESS4, b.COUNTRY, b.CITY, b.WEBSITE, b.POSTAL_CODE, b.TELP, b.FAX,
            c.NO_NPWP
            from m_vendor a
            LEFT JOIN m_vendor_address b ON b.ID_VENDOR=a.ID AND (b.BRANCH_TYPE='KANTOR PUSAT' OR b.BRANCH_TYPE='HEAD OFFICE')
            LEFT JOIN m_vendor_address b2 on b2.ID_VENDOR=a.ID AND (b2.BRANCH_TYPE='KANTOR CABANG' OR b2.BRANCH_TYPE='BRANCH OFFICE')
            LEFT JOIN m_vendor_npwp c ON c.ID_VENDOR=a.ID
            where a.ID='".$req_no."' ");
            $res = $query_select_supp->result();
            // echopre($res);
            $ch = curl_init('https://10.1.1.94:89/PY910/GetNextNumber_mgr');
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57X010/">
<soapenv:Header>
  <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
    soapenv:mustUnderstand="1">
    <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
      xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <wsse:Username>scm</wsse:Username>
      <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">abpberjaya</wsse:Password>
    </wsse:UsernameToken>
  </wsse:Security>
</soapenv:Header>

   <soapenv:Body>
      <orac:GetNextNumber_mgr>
         <nextNumberingIndexNumber>
            <value>1</value>
         </nextNumberingIndexNumber>
         <productCode>57</productCode>
      </orac:GetNextNumber_mgr>
   </soapenv:Body>
</soapenv:Envelope>';
        $headers = array(
            #"Content-type: application/soap+xml;charset=\"utf-8\"",
            "Content-Type: text/xml",
            "charset:utf-8",
            "Accept: application/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        );

            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv3);
            #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 );
            curl_setopt($ch, CURLOPT_SSLVERSION, 'all');
            #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_DEFAULT);

            curl_setopt($ch, CURLOPT_VERBOSE, true);
    //      $verbose = fopen('testing.log', 'w+');
    //      curl_setopt($ch, CURLOPT_STDERR, $verbose);


            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

            $data_curl = curl_exec($ch);
            //echo curl_error($ch);
            curl_close($ch);
            if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
                $itemNumber = substr($data_curl,strpos($data_curl,'<nextNumberRange1>')+18,((strpos($data_curl,'</nextNumberRange1>'))-(strpos($data_curl,'<nextNumberRange1>')+18)));

                self::$valueNextNumber = substr($itemNumber,strpos($itemNumber,'<value>')+7,((strpos($itemNumber,'</value>'))-(strpos($itemNumber,'<value>')+7)));

                self::$valueNextNumber = 300000 +  intval(self::$valueNextNumber);


                $ch = curl_init('https://10.1.1.94:89/PY910/AddressBookManager?WSDL');
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP010000/">
                            <soapenv:Header>
                            <wsse:Security
                            xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
                            soapenv:mustUnderstand="1">
                            <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                            <wsse:Username>SCM</wsse:Username>
                            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">abpberjaya</wsse:Password>
                            </wsse:UsernameToken>
                            </wsse:Security>
                            </soapenv:Header>
                            <soapenv:Body>


                            <orac:processAddressBook>
                             <addressBook>
                             <address>
                                <addressLine1>' . $res[0]->ADDRESS . '</addressLine1>
                                <addressLine2>' . $res[0]->ADDRESS2 . '</addressLine2>
                                <addressLine3>' . $res[0]->ADDRESS3 . '</addressLine3>
                                <addressLine4>' . $res[0]->ADDRESS4 . '</addressLine4>
                                <city>' . $res[0]->CITY . '</city>
                                <countryCode>' . $res[0]->COUNTRY . '</countryCode>
                                <postalCode>' . $res[0]->POSTAL_CODE . '</postalCode>
                             </address>
                             <businessUnit>10101</businessUnit>
                             <electronicAddresses>
                                <actionType>1</actionType>
                                <contactId>0</contactId>
                                <electronicAddress>' . $res[0]->ID_VENDOR . '</electronicAddress>
                                <electronicAddressTypeCode>E</electronicAddressTypeCode>
                             </electronicAddresses>
                             <entity>
                                <entityId>' . self::$valueNextNumber . '</entityId>
                                <entityTaxId>' . $res[0]->NO_NPWP . '</entityTaxId>
                             </entity>
                             <entityName>' . $res[0]->NAMA . '</entityName>
                             <entityNameSecondary>-</entityNameSecondary>
                             <!--<entityTaxIdAdditional>378888888881234</entityTaxIdAdditional>-->
                             <entityTypeCode>V</entityTypeCode>
                             <isEntityTypePayables>1</isEntityTypePayables>
                             <isEntityTypeReceivables>0</isEntityTypeReceivables>
                             <phoneNumbers>
                                <actionType>1</actionType>
                                <contactId>0</contactId>
                                <phoneNumber>' . $res[0]->TELP . '</phoneNumber>
                                <phoneTypeCode>FAX</phoneTypeCode>
                             </phoneNumbers>
                             <processing>
                                <actionType>1</actionType>
                                <processingVersion>ZJDE0001</processingVersion>
                             </processing>
                             </addressBook>
                            </orac:processAddressBook>


                            </soapenv:Body>
                            </soapenv:Envelope>';
                $headers = array(
                    #"Content-type: application/soap+xml;charset=\"utf-8\"",
                    "Content-Type: text/xml",
                    "charset:utf-8",
                    "Accept: application/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "Content-length: " . strlen($xml_post_string),
                );

                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv3);
                #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 );
                curl_setopt($ch, CURLOPT_SSLVERSION, 'all');
                #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_DEFAULT);

                curl_setopt($ch, CURLOPT_VERBOSE, true);
        //      $verbose = fopen('testing.log', 'w+');
        //      curl_setopt($ch, CURLOPT_STDERR, $verbose);


                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

                $data = curl_exec($ch);
                //echo curl_error($ch);
                curl_close($ch);
                if (strpos($data, 'HTTP/1.1 200 OK') !== false) {
                   $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='m_supp' and doc_no='".$req_no."' and isclosed=0");
                   $query_update = $this->db->query("update m_vendor set ID_EXTERNAL='".self::$valueNextNumber."' where ID='".$req_no."' ");
                }else{
                    // echo "Gagal Exec JDE SUPP REG -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
                    echopre($xml_post_string);
                }

            }else{
                // echo "Gagal Exec JDE SUPP NEXT NUMBER -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
                echopre($xml_post_string);
            }
        }else{
          echo "Execution - Reg Supp Code at ".date("Y-m-d H:i:s");
        }
        $data_log['script_type'] = 'm_reg_supp';
        $this->db->insert('i_sync_log',$data_log);
        $this->db->close();
    }


    public function requestJDE_updateSupplier() {
        ini_set('max_execution_time', 300);
        error_reporting(0);
        ini_set('display_errors', 0);
        $req_no = "";
        $result = true;
        $query_check_out = $this->db->query("select doc_no from i_sync where doc_type='m_supp_edit' and isclosed=0 limit 1");
        if($query_check_out->num_rows()>0){
             $result_check = $query_check_out->result();
            $req_no = $result_check[0]->doc_no;
            $query_select_supp = $this->db->query("select b.*,a.NAMA, a.ID, a.ID_VENDOR, a.NO_SLKA, CASE WHEN LENGTH(b.ADDRESS)>3 THEN b.ADDRESS ELSE b2.ADDRESS END as ADDRESS, CASE WHEN LENGTH(b.ADDRESS2)>3 THEN b.ADDRESS2 ELSE b2.ADDRESS2 END as ADDRESS2, CASE WHEN LENGTH(b.ADDRESS3)>3 THEN b.ADDRESS3 ELSE b2.ADDRESS3 END as ADDRESS3,
           CASE WHEN LENGTH(b.ADDRESS4)>3 THEN b.ADDRESS4 ELSE b2.ADDRESS4 END as ADDRESS4, b.COUNTRY, b.CITY, b.WEBSITE, b.POSTAL_CODE, b.TELP, b.FAX,
            c.NO_NPWP,a.ID_EXTERNAL
            from m_vendor a
            LEFT JOIN m_vendor_address b ON b.ID_VENDOR=a.ID AND b.BRANCH_TYPE='KANTOR PUSAT'
            LEFT JOIN m_vendor_address b2 on b2.ID_VENDOR=a.ID AND b2.BRANCH_TYPE='KANTOR CABANG'
            LEFT JOIN m_vendor_npwp c ON c.ID_VENDOR=a.ID
            where a.ID='".$req_no."' ");
            $res = $query_select_supp->result();
            // echopre($res);
            $ch = curl_init('https://10.1.1.94:89/PY910/GetNextNumber_mgr');
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP57X010/">
<soapenv:Header>
  <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
    xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
    soapenv:mustUnderstand="1">
    <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
      xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
      <wsse:Username>scm</wsse:Username>
      <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">abpberjaya</wsse:Password>
    </wsse:UsernameToken>
  </wsse:Security>
</soapenv:Header>

   <soapenv:Body>
      <orac:GetNextNumber_mgr>
         <nextNumberingIndexNumber>
            <value>1</value>
         </nextNumberingIndexNumber>
         <productCode>57</productCode>
      </orac:GetNextNumber_mgr>
   </soapenv:Body>
</soapenv:Envelope>';
        $headers = array(
            #"Content-type: application/soap+xml;charset=\"utf-8\"",
            "Content-Type: text/xml",
            "charset:utf-8",
            "Accept: application/xml",
            "Cache-Control: no-cache",
            "Pragma: no-cache",
            "Content-length: " . strlen($xml_post_string),
        );

            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv3);
            #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 );
            curl_setopt($ch, CURLOPT_SSLVERSION, 'all');
            #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_DEFAULT);

            curl_setopt($ch, CURLOPT_VERBOSE, true);
    //      $verbose = fopen('testing.log', 'w+');
    //      curl_setopt($ch, CURLOPT_STDERR, $verbose);


            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

            $data_curl = curl_exec($ch);
            //echo curl_error($ch);
            curl_close($ch);
            if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {

                $ch = curl_init('https://10.1.1.94:89/PY910/AddressBookManager?WSDL');
            $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP010000/">
                            <soapenv:Header>
                            <wsse:Security
                            xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
                            soapenv:mustUnderstand="1">
                            <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
                            xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
                            <wsse:Username>SCM</wsse:Username>
                            <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">abpberjaya</wsse:Password>
                            </wsse:UsernameToken>
                            </wsse:Security>
                            </soapenv:Header>
                            <soapenv:Body>


                            <orac:processAddressBook>
                             <addressBook>
                             <address>
                                <addressLine1>' . $res[0]->ADDRESS . '</addressLine1>
                                <addressLine2>' . $res[0]->ADDRESS2 . '</addressLine2>
                                <addressLine3>' . $res[0]->ADDRESS3 . '</addressLine3>
                                <addressLine4>' . $res[0]->ADDRESS4 . '</addressLine4>
                                <city>' . $res[0]->CITY . '</city>
                                <countryCode>' . $res[0]->COUNTRY . '</countryCode>
                                <postalCode>' . $res[0]->POSTAL_CODE . '</postalCode>
                             </address>
                             <businessUnit>10101</businessUnit>
                             <electronicAddresses>
                                <actionType>1</actionType>
                                <contactId>0</contactId>
                                <electronicAddress>' . $res[0]->ID_VENDOR . '</electronicAddress>
                                <electronicAddressTypeCode>E</electronicAddressTypeCode>
                             </electronicAddresses>
                             <entity>
                                <entityId>' . $res[0]->ID_EXTERNAL . '</entityId>
                                <entityTaxId>' . $res[0]->NO_NPWP . '</entityTaxId>
                             </entity>
                             <entityName>' . $res[0]->NAMA . '</entityName>
                             <entityNameSecondary>-</entityNameSecondary>
                             <!--<entityTaxIdAdditional>378888888881234</entityTaxIdAdditional>-->
                             <entityTypeCode>V</entityTypeCode>
                             <isEntityTypePayables>1</isEntityTypePayables>
                             <isEntityTypeReceivables>0</isEntityTypeReceivables>
                             <phoneNumbers>
                                <actionType>1</actionType>
                                <contactId>0</contactId>
                                <phoneNumber>' . $res[0]->TELP . '</phoneNumber>
                                <phoneTypeCode>FAX</phoneTypeCode>
                             </phoneNumbers>
                             <processing>
                                <actionType>2</actionType>
                                <processingVersion>ZJDE0001</processingVersion>
                             </processing>
                             </addressBook>
                            </orac:processAddressBook>


                            </soapenv:Body>
                            </soapenv:Envelope>';
                $headers = array(
                    #"Content-type: application/soap+xml;charset=\"utf-8\"",
                    "Content-Type: text/xml",
                    "charset:utf-8",
                    "Accept: application/xml",
                    "Cache-Control: no-cache",
                    "Pragma: no-cache",
                    "Content-length: " . strlen($xml_post_string),
                );

                curl_setopt($ch, CURLOPT_HEADER, true);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_SSLv3);
                #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1_0 );
                curl_setopt($ch, CURLOPT_SSLVERSION, 'all');
                #curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_MAX_DEFAULT);

                curl_setopt($ch, CURLOPT_VERBOSE, true);
        //      $verbose = fopen('testing.log', 'w+');
        //      curl_setopt($ch, CURLOPT_STDERR, $verbose);


                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

                $data = curl_exec($ch);
                //echo curl_error($ch);
                curl_close($ch);
                if (strpos($data, 'HTTP/1.1 200 OK') !== false) {
                   $query_update = $this->db->query("update i_sync set isclosed=1,updatedate=now() where doc_type='m_supp_edit' and doc_no='".$req_no."' and isclosed=0");
                }else{
                    // echo "Gagal Exec JDE SUPP REG -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
                    echopre($xml_post_string);
                }

            }else{
                // echo "Gagal Exec JDE SUPP NEXT NUMBER -  Doc No ".$req_no." at ".date("Y-m-d H:i:s");
                echopre($xml_post_string);
            }
        }else{
          echo "Execution - Update Supp Code at ".date("Y-m-d H:i:s");
        }
        $data_log['script_type'] = 'm_supp_edit';
        $this->db->insert('i_sync_log',$data_log);
        $this->db->close();
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $all = $this->map->get_alldata();
        $all1 = $this->map->get_vendor();
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
        $this->template->display('vendor/V_approval', $data);
    }

// ==================================================== Get Data ========================================================
    public function get_data($id) {
        $res = $this->map->get_legal($id);
        $slka = $this->map->get_slka($id);
        $ktp = $this->map->get_info_ktp($id);
        $data = array();
        $data2 = array();
        $cnt = 0;
        foreach ($res as $row) {
            if (!isset($output[$row['ID']])) {
                // Form the desired data structure
                $data[0] = [
                    "GEN" => [
                        $row['NAMA'],
                        $row['PREFIX'],
                        $row['CLASSIFICATION'],
                        $row['CUALIFICATION'],
                        $row['SUFFIX'],
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
                $data2[$row['CATEGORY']] = array(
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
        foreach ($slka as $k => $v) {

            $data3[0] = [
                "SLKA" => [
                    str_replace("XXXX",$v->SLKA, $v->OPEN_VALUE),
                    str_replace("XXXX",$v->SLKA, $v->CLOSE_VALUE),
                    $v->ADDRESS,
                    $v->TELP,
                    $v->FAX,
                ]
            ];
        }

        $data_ktp = array();
        if (count($ktp) > 0) {
          foreach ($ktp as $key => $value) {
            $data_ktp[0] = [
              "KTP" => [
                $value['name'],
                $value['nik'],
                $value['city'],
                $value['expired_date'],
                $value['file_url'],
              ]
            ];
          }
        } else {
          $data_ktp[0] = [
            "KTP" => [
              '',
              '',
              '',
              '',
              '',
            ]
          ];
        }

        $data = array_merge($data, $data3);
        $data = array_merge($data, $data2);
        $data = array_merge($data, $data_ktp);

        $this->output($data);
    }

    public function alamatperusahaan($id) {
        $where = array(
            'a.ID_VENDOR' => $id,
            'a.STATUS' => 1
        );

        $data = $this->map->alamatperusahaan($where);
        if($data == false)
            $this->output(array());
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BRANCH_TYPE);
            $dt[$k][2] = stripslashes($v->ADDRESS);
            $dt[$k][3] = stripslashes($v->ADDRESS2);
            $dt[$k][4] = stripslashes($v->ADDRESS3);
            $dt[$k][5] = stripslashes($v->ADDRESS4);
            $dt[$k][6] = stripslashes($v->COUNTRY);
            $dt[$k][7] = stripslashes($v->PROVINCE);
            $dt[$k][8] = stripslashes($v->CITY);
            $dt[$k][9] = stripslashes($v->POSTAL_CODE);
            $dt[$k][10] = stripslashes($v->TELP);
            $dt[$k][11] = stripslashes($v->FAX);
            $dt[$k][12] = stripslashes($v->WEBSITE);
        }
        $this->output($dt);
    }

    public function datakontakperusahaan($id) {
        $data = $this->map->datakontakperusahaan($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAMA);
            $dt[$k][2] = stripslashes($v->JABATAN);
            $dt[$k][3] = stripslashes($v->TELP);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->HP);
        }
        $this->output($dt);
    }

    public function dataakta($id) {
        $data = $this->map->dataakta($id);
        $dt = array();
        $base = base_url();

        foreach ($data as $k => $v) {
          if ($v->AKTA_FILE != '') {
            $akta_file = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $akta_file = '-';
          }

          if ($v->VERIFICATION_FILE != '') {
            $verif_file = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $verif_file = '-';
          }

          if ($v->NEWS_FILE != '') {
            $news_file = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-success"><i class="fa fa-file-o"></i></button>';
          } else {
            $news_file = '-';
          }
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NO_AKTA);
            $dt[$k][2] = stripslashes($v->AKTA_DATE);
            $dt[$k][3] = stripslashes($v->AKTA_TYPE);
            $dt[$k][4] = stripslashes($v->NOTARIS);
            $dt[$k][5] = stripslashes($v->ADDRESS);
            $dt[$k][6] = stripslashes($v->VERIFICATION);
            $dt[$k][7] = stripslashes($v->NEWS);
            $dt[$k][8] = $akta_file;
            $dt[$k][9] = $verif_file;
            $dt[$k][10] = $news_file;
        }
        $this->output($dt);
    }

    public function show_datasertifikasi($id) {
        $data = $this->map->show_datasertifikasi($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->ISSUED_BY);
            $dt[$k][2] = stripslashes($v->NO_DOC);
            $dt[$k][3] = stripslashes($v->VALID_SINCE);
            $dt[$k][4] = stripslashes($v->VALID_UNTIL);
            $dt[$k][5] = stripslashes($v->DESCRIPTION);
            $dt[$k][6] = "<button class='btn btn-primary' onclick=review_akta('" . $base . 'upload/CERTIFICATION/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";
        }
        $this->output($dt);
    }

    public function daftarjasa($id) {
        $data = $this->map->daftarjasa($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->GROUP);
            $dt[$k][2] = stripslashes($v->SUB_GROUP);
            $dt[$k][3] = stripslashes($v->NAME);
            $dt[$k][4] = stripslashes($v->DESCRIPTION);
            $dt[$k][5] = stripslashes($v->CERT_NO);
        }
        $this->output($dt);
    }

    public function daftarbarang($id) {
        $data = $this->map->daftarbarang($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->GROUP);
            $dt[$k][2] = stripslashes($v->SUB_GROUP);
            $dt[$k][3] = stripslashes($v->NAME);
            $dt[$k][4] = stripslashes($v->DESCRIPTION);
            $dt[$k][5] = stripslashes($v->CERT_NO);
        }
        $this->output($dt);
    }

    public function show_company_management($id) {
        $data = $this->map->show_company_management($id);
        $dt = array();
        foreach ($data as $k => $v) {
          if ($v->FILE_NPWP == '' || $v->FILE_NPWP == 'failed') {
            $file_npwp = '-';
          } else {
            $file_npwp = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
          }

          if ($v->FILE_NO_ID) {
            $file_ektp = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NO_ID . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
          } else {
            $file_ektp = '-';
          }

            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->POSITION);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->NO_ID);
            $dt[$k][6] = $file_ektp;
            $dt[$k][7] = stripslashes($v->NPWP);
            $dt[$k][8] = $file_npwp;
        }
        echo json_encode($dt);
    }

    public function show_vendor_shareholders($id) {
        $data = $this->map->show_vendor_shareholders($id);
        $dt = array();
        foreach ($data as $k => $v) {
          if ($v->FILE_NPWP == "" || $v->FILE_NPWP == 'failed') {
            $file_npwp = '-';
          } else {
            $file_npwp = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
          }

            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->PHONE);
            $dt[$k][3] = stripslashes($v->EMAIL);
            $dt[$k][4] = stripslashes($v->NPWP);
            $dt[$k][5] = $file_npwp;
        }
        echo json_encode($dt);
    }

    public function show_financial_bank_data($id) {
        $data = $this->map->show_financial_bank_data($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->YEAR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->CURRENCY);
            $dt[$k][4] = numIndo($v->ASSET_VALUE);
            $dt[$k][5] = numIndo($v->DEBT);
            $dt[$k][6] = numIndo($v->BRUTO);
            $dt[$k][7] = numIndo($v->NETTO);
            $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/NERACA/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_bank_account($id) {
        $data = $this->map->show_vendor_bank_account($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BANK_NAME);
            $dt[$k][2] = stripslashes($v->BRANCH);
            $dt[$k][3] = stripslashes($v->ADDRESS);
            $dt[$k][4] = stripslashes($v->NO_REC);
            $dt[$k][5] = stripslashes($v->NAME);
            $dt[$k][6] = stripslashes($v->CURRENCY);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/BANK/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_experience($id) {
        # code...
        $data = $this->map->show_experience_experience($id);
        $dt = array();
        foreach ($data as $k => $v) {
            # code...
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->CUSTOMER_NAME);
            $dt[$k][2] = stripslashes($v->PROJECT_NAME);
            $dt[$k][3] = stripslashes($v->PROJECT_DESCRIPTION);
            $dt[$k][4] = stripslashes($v->PROJECT_VALUE);
            $dt[$k][5] = stripslashes($v->CURRENCY);
            $dt[$k][6] = stripslashes($v->CONTRACT_NO);
            $dt[$k][7] = stripslashes($v->START_DATE);
            $dt[$k][8] = stripslashes($v->END_DATE);
            $dt[$k][9] = stripslashes($v->CONTACT_PERSON);
            $dt[$k][10] = stripslashes($v->PHONE);
        }
        echo json_encode($dt);
    }

    public function show_certification($id) {
        $url = "upload/CERTIFICATION/";
        $data = $this->map->show_certification($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            # code...
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->CREATOR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->NO_DOC);
            $dt[$k][4] = stripslashes($v->CREATE_BY);
            $dt[$k][5] = stripslashes($v->VALID_SINCE);
            $dt[$k][6] = stripslashes($v->VALID_UNTIL);
            $dt[$k][7] = "<button class='btn btn-sm btn-success' onclick=review_akta('" . $base . 'upload/CE/CERTIFICATION/' . $v->FILE_URL . "')><i class='fa fa-file-o'></i></button>";

        }

        echo json_encode($dt);
    }


}
