<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Review_update extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->model('vendor/M_show_vendor', 'msv')->model('vendor/M_vendor')->model('vendor/M_send_invitation');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('vendor/M_review_update', 'mru');
        $this->load->database();
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show_contact($data) {
        $result = $this->mru->get_contact($data);
        $dt = array();
        if ($result != false) {
            foreach ($result as $k => $v) {
                $tamp = $k + 1;
                $dt[$k][0] = $tamp;
                $dt[$k][1] = $v->NAMA;
                $dt[$k][2] = $v->JABATAN;
                $dt[$k][3] = $v->TELP;
                $dt[$k][4] = $v->EMAIL;
                $dt[$k][6] = $v->HP;
            }
        }
        $this->output($dt);
    }

    public function get_status($status) {
        foreach ($status as $k => $v) {
            $stts[$v->STATUS]['IND'] = $v->DESCRIPTION_IND;
            $stts[$v->STATUS]['ENG'] = $v->DESCRIPTION_ENG;
        }
        return $stts;
    }

    public function show() {
        $status = $this->M_send_invitation->show_status();
        $status = $this->get_status($status);
        $data = $this->mru->show();
        if ($data != false) {
            $dt = array();
            foreach ($data as $k => $v) {
                $dt[$k][0] = $k + 1;
                $dt[$k][1] = $v->NAMA;
                $dt[$k][2] = $v->ID_VENDOR;
                // if($_SESSION['lang']=='ENG'){
                //     $SST = $status[$v->STATUS]['ENG'];
                // }else{
                //     $SST = $status[$v->STATUS]['IND'];
                // }

                $dt[$k][3] = $status[$v->STATUS]['ENG'];
                $dt[$k][4] = '</a> <button data-toggle="modal" onclick="add(\'' . $v->ID . '\',\'' . $v->ID_VENDOR . '\')" class="btn btn-sm btn-primary btnproses" title="Verifikasi Data Vendor"><i class="fa fa-chevron-circle-right"></i>&nbspProcess</button> ';
            }
            $this->output($dt);
        } else {
            $this->output();
        }
    }

    public function approve() {
        $data = ($_POST);
        $result = $this->mru->data_approve($data);
        $this->output($result);
    }

    public function reject() {
        $data = ($_POST);
        $result = $this->mru->data_reject($data);
        $this->output($result);
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
        $this->template->display('vendor/V_review_update', $data);
    }

    public function get_data($id) {
        $res = $this->mru->get_legal($id);
        $slka=$this->mru->get_slka($id);
        $data = array();
        $data2 = array();
        $cnt = 0;
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
                    $v->OPEN_VALUE,
                    $v->CLOSE_VALUE
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

    public function getlist($id_vendor) {
      $tot_un_apv = 0;
      $total = 0;
      $total_upd = 0;
      $tot_un_apv_upd = 0;

      foreach ($this->mru->get_checklist($id_vendor) as $k => $v) {
          if ($v == 1) {
              $dt[$k] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
          } else if ($v == '') {
              $total++;
              $dt[$k] = '<a href="#"><i></i></a>';
          } else if ($v == 0) {
              $dt[$k] = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
              $tot_un_apv++;
          }
      }

      foreach ($this->mru->get_checklist_update($id_vendor) as $key => $value) {
          if ($value == 1) {
              $dt2[$key] = '<a href="#"><i class="fa fa-check text-navy"></i></a>';
          } else if ($value == '') {
              $total_upd++;
              $dt2[$key] = '<a href="#"><i></i></a>';
          } else if ($value == 0) {
              $dt2[$key] = '<a href="#"><i class="fa fa-times text-danger"></i></a>';
              $tot_un_apv_upd++;
          }
      }
      // $this->output($dt);
        echo '
              <input  type="hidden" value="' . $tot_un_apv_upd . '" name="tot_un_apv" id="tot_un_apv">
              <input  type="hidden" value="' . $total_upd . '" name="tot_none" id="tot_none">

              <table class="table table-striped table-bordered table-hover display" width="100%">
              <thead>
                  <tr>
                      <th>#</th>
                      <th>' . lang('Deskirpsi', 'Description') . '</th>
                      <th><span>Status</span></th>
                      <th>Update</th>
                      <th>' . lang('Verifikasi', 'Check') . '</th>
                  </tr>
              </thead>
              <tbody>
                  <tr>
                      <td colspan="6" class="text-centered"><b>A. Data Umum</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>Info Perusahaan</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['GENERAL1'] . '</td>
                      <td>' . $dt['GENERAL1'] . '</td>
                  </tr>
                  <tr>
                      <td>2.</td>
                      <td>Alamat Perusahaan</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['GENERAL2'] . '</td>
                      <td>' . $dt['GENERAL2'] . '</td>
                  </tr>
                  <tr>
                      <td>3.</td>
                      <td>Kontak Perusahaan</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['GENERAL3'] . '</td>
                      <td>' . $dt['GENERAL3'] . '</td>
                  </tr>
                  <tr>
                      <td colspan="6" class="text-centered"><b>B. Data Legal</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>Akta</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['LEGAL1'] . '</td>
                      <td>' . $dt['LEGAL1'] . '</td>
                  </tr>
                  <tr>
                      <td>2.</td>
                      <td>Surat Izin Usaha Perdagangan (SIUP)</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['LEGAL2'] . '</td>
                      <td>' . $dt['LEGAL2'] . '</td>
                  </tr>
                  <tr>
                      <td>3.</td>
                      <td>Tanda Daftar Perusahaan (TDP)</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['LEGAL3'] . '</td>
                      <td>' . $dt['LEGAL3'] . '</td>
                  </tr>
                  <tr>
                      <td>4.</td>
                      <td>Nomor Pokok Wajib Pajak (NPWP)</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['LEGAL4'] . '</td>
                      <td>' . $dt['LEGAL4'] . '</td>
                  </tr>
                  <tr>
                      <td>5.</td>
                      <td>Direktorat panas bumi</td>
                      <td>' . lang('Kondisional', 'Optional') . '</td>
                      <td>' . $dt2['LEGAL5'] . '</td>
                      <td>' . $dt['LEGAL5'] . '</td>

                  </tr>
                  <tr>
                      <td>6.</td>
                      <td>Surat Keterangan Terdaftar MIGAS (Dirjen Minyak & Gas Bumi)</td>
                      <td>' . lang('Kondisional', 'Optional') . '</td>
                      <td>' . $dt2['LEGAL6'] . '</td>
                      <td>' . $dt['LEGAL6'] . '</td>
                  </tr>
                  <tr>
                      <td>7.</td>
                      <td>SPPKP</td>
                      <td>' . lang('Kondisional', 'Optional') . '</td>
                      <td>' . $dt2['LEGAL7'] . '</td>
                      <td>' . $dt['LEGAL7'] . '</td>
                  </tr>
                  <tr>
                      <td>8.</td>
                      <td>' . lang('SKT PAJAK', 'TAX cERTIFICATE') . '</td>
                      <td>' . lang('Kondisional', 'Optional') . '</td>
                      <td>' . $dt2['LEGAL8'] . '</td>
                      <td>' . $dt['LEGAL8'] . '</td>
                  </tr>
                  <tr>
                      <td colspan="6" class="text-centered"><b>C. Barang & Jasa yang Bisa Dipasok</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>Sertifikasi Keagenan & Prinsipal</td>
                      <td>' . lang('Kondisional', 'Optional') . '</td>
                      <td>' . $dt2['GNS1'] . '</td>
                      <td>' . $dt['GNS1'] . '</td>
                  </tr>
                  <tr>
                      <td>2.</td>
                      <td>Barang</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['GNS2'] . '</td>
                      <td>' . $dt['GNS2'] . '</td>
                  </tr>
                  <tr>
                      <td>3.</td>
                      <td>Jasa</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['GNS3'] . '</td>
                      <td>' . $dt['GNS3'] . '</td>
                  </tr>
                  <tr>
                      <td colspan="6" class="text-centered"><b>D. Data Bank & Keuangan</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>Dafar Rekening Bank</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['MANAGEMENT1'] . '</td>
                      <td>' . $dt['MANAGEMENT1'] . '</td>
                  </tr>
                  <tr>
                      <td>2.</td>
                      <td>Neraca Keuangan</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['MANAGEMENT2'] . '</td>
                      <td>' . $dt['MANAGEMENT2'] . '</td>
                  </tr>
                  <tr>
                      <td colspan="6" class="text-centered"><b>E. Pengurus Perusahaan</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>Dewan Direksi</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['BNF1'] . '</td>
                      <td>' . $dt['BNF1'] . '</td>
                  </tr>
                  <tr>
                      <td>2.</td>
                      <td>Daftar Pemilik Saham</td>
                      <td>' . lang('Kondisinoal', 'Optional') . '</td>
                      <td>' . $dt2['BNF2'] . '</td>
                      <td>' . $dt['BNF2'] . '</td>
                  </tr>
                  <tr>
                      <td colspan="6" class="text-centered"><b>F. Sertifikasi & Pengalaman Perusahaan</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>Sertifikasi Umum</td>
                      <td>' . lang('Kondisional', 'Optional') . '</td>
                      <td>' . $dt2['CNE1'] . '</td>
                      <td>' . $dt['CNE1'] . '</td>
                  </tr>
                  <tr>
                      <td>2.</td>
                      <td>Pengalaman Perusahaan</td>
                      <td>' . lang('Kondisinoal', 'Optional') . '</td>
                      <td>' . $dt2['CNE2'] . '</td>
                      <td>' . $dt['CNE2'] . '</td>
                  </tr>
                  <tr>
                      <td colspan="6" class="text-centered"><b>G. Contractor SHE Mangement System (CSMS)</b></td>
                  </tr>
                  <tr>
                      <td>1.</td>
                      <td>CSMS</td>
                      <td>' . lang('Wajib', 'Required') . '</td>
                      <td>' . $dt2['CSMS'] . '</td>
                      <td>' . $dt['CSMS'] . '</td>
                  </tr>
              </tbody>';
    }

    public function dataakta($id) {
        $data = $this->mru->dataakta($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NO_AKTA);
            $dt[$k][2] = stripslashes($v->AKTA_DATE);
            $dt[$k][3] = stripslashes($v->AKTA_TYPE);
            $dt[$k][4] = stripslashes($v->NOTARIS);
            $dt[$k][5] = stripslashes($v->ADDRESS);
            $dt[$k][6] = stripslashes($v->VERIFICATION);
            $dt[$k][7] = stripslashes($v->NEWS);
            $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->AKTA_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][9] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->VERIFICATION_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][10] = '<button onclick="review_akta(\'' . base_url() . 'upload/LEGAL_DATA/AKTA/' . $v->NEWS_FILE . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        $this->output($dt);
    }

    public function show_datasertifikasi($id) {
        $data = $this->msv->show_datasertifikasi($id);
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

    public function alamatperusahaan($id) {
        $data = $this->mru->alamatperusahaan($id);
        $dt = array();
        $base = base_url();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BRANCH_TYPE);
            $dt[$k][2] = stripslashes($v->ADDRESS);
            $dt[$k][3] = stripslashes($v->COUNTRY);
            $dt[$k][4] = stripslashes($v->PROVINCE);
            $dt[$k][5] = stripslashes($v->CITY);
            $dt[$k][6] = stripslashes($v->POSTAL_CODE);
            $dt[$k][7] = stripslashes($v->TELP);
            $dt[$k][8] = stripslashes($v->HP);
            $dt[$k][9] = stripslashes($v->FAX);
            $dt[$k][10] = stripslashes($v->WEBSITE);
        }
        $this->output($dt);
    }

    public function datakontakperusahaan($id) {
        $data = $this->mru->datakontakperusahaan($id);
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

    public function daftarjasa($id) {
        $data = $this->mru->daftarjasa($id);
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
        $data = $this->mru->daftarbarang($id);
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
        $data = $this->mru->show_company_management($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->NAME);
            $dt[$k][2] = stripslashes($v->POSITION);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->NO_ID);
            $dt[$k][6] = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NO_ID . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
            $dt[$k][7] = stripslashes($v->VALID_UNTIL);
            $dt[$k][8] = stripslashes($v->NPWP);
            $dt[$k][9] = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_DEWAN_DIREKSI/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_shareholders($id) {
        $data = $this->mru->show_vendor_shareholders($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->TYPE);
            $dt[$k][2] = stripslashes($v->NAME);
            $dt[$k][3] = stripslashes($v->PHONE);
            $dt[$k][4] = stripslashes($v->EMAIL);
            $dt[$k][5] = stripslashes($v->VALID_UNTIL);
            $dt[$k][6] = stripslashes($v->NPWP);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/COMPANY_MANAGEMENT/DAFTAR_PEMILIK_SAHAM/' . $v->FILE_NPWP . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_financial_bank_data($id) {
        $data = $this->mru->show_financial_bank_data($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->YEAR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->CURRENCY);
            $dt[$k][4] = stripslashes($v->ASSET_VALUE);
            $dt[$k][5] = stripslashes($v->DEBT);
            $dt[$k][6] = stripslashes($v->BRUTO);
            $dt[$k][7] = stripslashes($v->NETTO);
            $dt[$k][8] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/NERACA/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_vendor_bank_account($id) {
        $data = $this->mru->show_vendor_bank_account($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->BANK_NAME);
            $dt[$k][2] = stripslashes($v->BRANCH);
            $dt[$k][3] = stripslashes($v->ADDRESS);
            $dt[$k][4] = stripslashes($v->NO_REC);
            $dt[$k][5] = stripslashes($v->CURRENCY);
            //$dt[$k][6] = stripslashes($v->FILE_URL);
            $dt[$k][6] = '<button onclick="review_akta(\'' . base_url() . 'upload/FINANCIAL_BANK/BANK/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }

    public function show_experience($id) {
        # code...
        $data = $this->mru->show_experience_experience($id);
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
        $data = $this->mru->show_certification($id);
        $dt = array();
        foreach ($data as $k => $v) {
            $dt[$k][0] = $k + 1;
            $dt[$k][1] = stripslashes($v->CREATOR);
            $dt[$k][2] = stripslashes($v->TYPE);
            $dt[$k][3] = stripslashes($v->NO_DOC);
            $dt[$k][4] = stripslashes($v->CREATE_BY);
            $dt[$k][5] = stripslashes($v->VALID_SINCE);
            $dt[$k][6] = stripslashes($v->VALID_UNTIL);
            $dt[$k][7] = '<button onclick="review_akta(\'' . base_url() . 'upload/CE/CERTIFICATION/' . $v->FILE_URL . '\')" class="btn btn-sm btn-primary"><i class="fa fa-file-o"></i></button>';
        }
        echo json_encode($dt);
    }
    
    public function send_comment()
    {
        $data=array(
          "VALUE"=>stripslashes($this->input->post('msg')),
          "TYPE"=>stripslashes($this->input->post('type')),
          "TIME"=>date('Y-m-d H:i:s'),
          "SENDER"=>$this->session->ID_USER,
          "RECEIVER"=>stripslashes($this->input->post('id')),
        );
        $res=$this->mru->add('m_status_vendor_chat',$data);
        $this->output($res);
    }

    public function comment() {
        $type = $this->input->post('type');
        $id = $this->input->post('id');
        $q = $this->mru->get_comment($id, $type);
        if($q == false)
            $this->output();
        foreach ($q as $k => $v) {
            if($v->SENDER != $id)
            {
            echo'<div class="chat">
                    <div class="chat-body" style="margin:0px">
                            <div class="chat-content">
                                <p>'.$v->VALUE.'</p>
                                <br/><p>'.$v->TIME.'</p>
                            </div>
                    </div>
                </div>';
            }
            else
            {
            echo'<div class="chat chat-left">
                    <div class="chat-body">
                        <div class="chat-content" style="margin:0px">
                            <p>'.$v->VALUE.'</p>
                            <br/><p>'.$v->TIME.'</p>
                        </div>
                    </div>
                </div>';
            }
        }
        exit;
    }

    public function get_csms() {
        if ($this->input->post('API') == 'SELECT') {
            $id = stripslashes($this->input->post('id'));
            $res = $this->mru->get_csms($id);
            if ($res == false)
                $this->output(null);
            else
                $this->output($res[0]);
        } else
            $this->output(null);
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

        if (count($content['dest']) != 0 && !isset($content['email'])) {
            foreach ($content['dest'] as $k => $v) {
                $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
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
        }
        else
        {
            $this->load->library('email', $config);
                $this->email->initialize($config);
                $this->email->from($mail['email'], '[SYSTEM] EPROC SUPREME ENERGY');
                $this->email->subject($content['title']);
                $ctn = ' <p>' . $content['img1'] . '<p>
                        <br>' . $content['open'] . '
                        <br>
                        ' . $content['close'] . '
                        <br>
                        <p>Supreme Energy.</p>
                        ';
                $data_email['recipient'] = $content['email'];
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;
                if ($this->db->insert('i_notification',$data_email)) {
                     return true;
                } else {
                    return false;
                }
        }
        if ($flag == 1)
            return true;
        else
            return false;
    }


    public function change_btn($status) {

        $cek = $this->mru->cek($_POST);
        $data = array(
            //'UPDATE_BY' => $_SESSION['ID'],
            'UPDATE_TIME' => date('Y-m-d H:i:s'),
            $_POST['type'] => $status
        );
        if (count($cek) == 0) {//insert
            $data['ID_VENDOR'] = $_POST['id'];
            $data['CREATE_BY'] = $_SESSION['ID_USER'];
            $data['CREATE_TIME'] = date('Y-m-d H:i:s');
            $data['STATUS'] = '2';
            $q = $this->mru->add('m_status_vendor_data', $data);
        } else {//upd
            $q = $this->mru->upd('ID_VENDOR', 'm_status_vendor_data', $_POST['id'], $data);
        }
        if ($q == 1) {
            //note tidak kosong
            if ($_POST['note'] != '') {
                $data = array(
                    'RECEIVER' => $_POST['id'],
                    'SENDER' => $_SESSION['ID_USER'],
                    'VALUE' => stripslashes($_POST['note']),
                    'TYPE' => $_POST['type']
                );
                $qry = $this->mru->add('m_status_vendor_chat', $data);
                if ($qry == 1) {
                    echo "sukses";
                } else {
                    echo "Catatan tidak tersimpan";
                }
            } else {
                echo "sukses";
            }
        } else {
            echo "Proses Gagal, silahkan coba lagi!";
        }
    }

    public function checklist_app() {
        $id = $this->input->post('id_vendor');
        $un_app = $this->input->post('tot_un_apv');
        $none = $this->input->post('tot_none');
        $status = 23;
        $flag = 0;

        // if ($none > 0) {
        //     echo json_encode(array("msg" => "Masih ada data yang belum direview"));
        //     exit;
        // }
        // if ($un_app > 0){
        //   echo json_encode(array("msg" => "Masih ada data yang belum direview"));
        //   exit;
        // }

        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        if ($un_app > 0) {
          $status = 14;
          $emaildest = 15;
        } else {
          $status = 23;
          $emaildest = 10;
        }

        $content = $this->mru->get_email_dest($emaildest);
        $content[0]->ROLES = explode(",", $content[0]->ROLES);
        $res = $this->mru->get_user($content[0]->ROLES, count($content[0]->ROLES));
        $data = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $content[0]->TITLE,
            'open' => str_replace("nama_supplier", $id, $content[0]->OPEN_VALUE),
            'close' => $content[0]->CLOSE_VALUE
        );
        foreach ($res as $k => $v) {
            $data['dest'][] = $v->EMAIL;
        }
        $flag = $this->sendMail($data);

          // $content = $this->mru->get_email_dest(10);
          // $data = array(
          //     'email' => $id,
          //     'img1' => $img1,
          //     'img2' => $img2,
          //     'title' => $content[0]->TITLE,
          //     'open' =>  $content[0]->OPEN_VALUE,
          //     'close' => $content[0]->CLOSE_VALUE,
          //     'dest' =>array()
          // );
          // $flag = $this->sendMail($data);

          $sendemail = true;

          $rubah_data = array(
              'STATUS' => $status
          );

          $data_update2 = array(
              'ID_VENDOR' => $id,
              'STATUS' => $status,
              'CREATE_BY' => $this->session->userdata['ID_USER']
          );

          $this->mru->update('ID_VENDOR', 'm_vendor', $id, $rubah_data);
          $this->mru->add_show_vendor('log_vendor_acc', $data_update2);
          echo json_encode(array('status' => true));
    }

    public function checklist_app_approve_upd() {
        $id = $this->input->post('id_vendor');
        $un_app = $this->input->post('tot_un_apv');
        $none = $this->input->post('tot_none');
        $status = 7;
        $flag = 0;

        if ($none > 0) {
            echo json_encode(array("msg" => "Masih ada data yang belum direview"));
            exit;
        }
        if ($un_app > 0){
          echo json_encode(array("msg" => "Masih ada data yang belum direview"));
          exit;
        }

        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        if ($id != "") {
          $content = $this->mru->get_email_dest(10);
          $data = array(
              'email' => $id,
              'img1' => $img1,
              'img2' => $img2,
              'title' => $content[0]->TITLE,
              'open' =>  $content[0]->OPEN_VALUE,
              'close' => $content[0]->CLOSE_VALUE,
              'dest' => $id
          );
          $flag = $this->sendMail($data);

          $sendemail = true;

          $rubah_data = array(
              'STATUS' => $status
          );

          $data_update2 = array(
              'ID_VENDOR' => $id,
              'STATUS' => $status,
              'CREATE_BY' => $this->session->userdata['ID_USER']
          );

          // $this->mru->update('ID_VENDOR', 'm_vendor', $id, $rubah_data);
          // $this->mru->add_show_vendor('log_vendor_acc', $data_update2);
          echo json_encode(array('status' => true));
        } else {
          echo json_encode(array('status' => false));
        }
    }

    public function get_slka()
    {
        $qry=$this->db->select('NO_SLKA')
            ->from('m_vendor')
            ->order_by('NO_SLKA DESC')
            ->limit('1')
            ->get();
        return $qry->result();
    }

    public function ambil_attch_vendor($id){
      // $id = $this->input->post("idx");
      $data = $this->mru->attch_vendor($id);
      $dt = array();
      $no = 1;
      foreach ($data as $value) {
        $type_file = pathinfo($value->FILE_URL);
        echo '<tr>
                <td scope="row">'.$no++.'</td>
                <td>'.$type_file['extension'].'</td>
                <td>'.stripslashes($value->DESCRIPTION).'</td>
                <td>'.stripslashes($value->FILE_URL).'</td>
                <td><button class="btn btn-sm btn-primary" data-toggle="modal"  onclick="review(\'' . $value->FILE_URL . '\')" title="Preview File" id="aksi1" data-id='.stripslashes($value->ID).'><i class="fa fa-chevron-circle-right"></i></button></td>
              </tr>';
      }
      // $no = 1;
      // foreach ($data as $arr) {
      //   $result[] = array(
      //     0 => $no++,
      //     1 => substr($arr['FILE_URL'], strpos($arr['FILE_URL'], ".") + 1),
      //     2 => $arr['DESCRIPTION'],
      //     3 => $arr['FILE_URL'],
      //     4 => 'LALALA',
      //   );
      // }
      // $this->output($result);
      // foreach ($data as $k => $v) {
      //     $dt[$k][0] = $k + 1;
      //     $dt[$k][1] = substr($v->FILE_URL, strpos($v->FILE_URL, ".") +1);
      //     $dt[$k][2] = stripslashes($v->DESCRIPTION);
      //     $dt[$k][3] = stripslashes($v->FILE_URL);
      //     $dt[$k][4] = stripslashes($v->FILE_URL);
      // }
      // $this->output($dt);
    }

}
