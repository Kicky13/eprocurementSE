<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Slka extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_slka', 'msl');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor');
        $this->load->library('phpqrcode/qrlib');
    }

    public function index() {
        $id = $this->session->ID_VENDOR;
        $cek = $this->M_all_vendor->cek_session();
        $stat=$this->session->status_vendor;
        // if($stat != 7 && $stat != 21 && $stat != 22 && $stat != 23)
        //     header('Location:' . base_url().'page_404');

        $get_menu = $this->mvn->menu();
        $slka =$this->msl->get_slka($this->session->ID);
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_IND'] = $v->DESCRIPTION_IND;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['DESKRIPSI_ENG'] = $v->DESCRIPTION_ENG;
            $dt[$v->PARENT][$v->ID_MENU_VENDOR]['ICON'] = $v->ICON;
        }

        $all = array();
        $data2 = array();
        $cnt=0;
        $ktr=array(
            '','','',''
        );
        $branch=array();
        foreach($slka as $row) {
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
                        $ktr[1],
                        $ktr[2],
                        $ktr[3],
                        $row['NO_NPWP'],
                        $row['NO_SLKA'],
                        str_replace("XXXX",$row['NO_SLKA'],$row['OPEN_VALUE']),
                        str_replace("XXXX",$row['NO_SLKA'],$row['CLOSE_VALUE']),
                        DateTime::createFromFormat('Y-m-d H:i:s',$row['SLKA_DATE'])->format('d F Y')
                    ],
                ];
            $cnt++;
        }
        if($data[0]['GEN'][1] == '' && count($branch)>0)
        {
            $data[0]['GEN'][1]=$row['ADDRESS'];
            $data[0]['GEN'][2]=$row['FAX'];
            $data[0]['GEN'][3]=$row['TELP'];
        }
        $all['menu'] = $dt;
        $all['slka'] = $data;
        $this->template->display_vendor('vn/info/V_slka', $all);
    }

    public function get_qr()
    {
        $res=$this->msl->get_no_slka($this->session->ID);
        if($res != false)
        {
            $qr=md5($res[0]->NO_SLKA);
            $svgCode = QRcode::png('http:'.base_url().'show_qr?q='.$qr);
        }
        else
            $this->output();
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
}
