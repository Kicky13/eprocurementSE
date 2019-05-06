<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cpm_complete extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('procurement/M_cpm_complete', 'mcc');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('vendor/M_approval', 'map');
    }

    public function index() {
        $cek = $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('procurement/V_cpm_complete', $data);
    }
/* ===========================================-------- API START------- ====================================== */
    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }
    public function send()
    {
        $res=$this->process();
        $po=$this->input->post("po");
        $phase=$this->input->post("phase");
        $res=false;
        $res=$this->mcc->send_data($po,$phase);
        $data_log=array(
            "ID_VENDOR"=>$_SESSION['ID'],
            "STATUS"=>'1',
            "CREATE_TIME"=>date('Y-m-d H:i:s'),
            "CREATE_BY"=>$_SESSION['ID'],
            "TYPE"=>"CPM",
            "NOTE"=>stripslashes($_POST['note'])
        );
        if($res)
        {
            $res=$this->mcc->update_data($po,$phase);
            $log=$this->mcc->add('log_vendor_acc',$data_log);
        }
        if($res != false)
            $this->output(array('status'=>'Success', 'msg'=>'Data has been saved!'));
        else
            $this->output(array('status'=>'Failed', 'msg'=>'Oops, something went wrong!'));
    }

    public function draft()
    {
        $res=$this->process();
        if($res != false)
            $this->output(array("status"=>"Success", "msg"=>"Data has been saved!"));
        else
            $this->output(array("status"=>"Failed", "msg"=>"Oops, something went wrong!"));
    }

    public function calc($id)
    {
        $val=$this->input->post('value');
        $res=$this->mcc->calc_weight($id,$val);
        return $this->output((int)$res[0]->weight);
    }

    public function process()
    {
        $dt=array();
        $cnt=0;
        $po=$this->input->post("po");
        $phase=$this->input->post("phase");
        $check=$this->mcc->check($po,$phase);
        $tamp=0;
        $cntTamp=0;
        $flag=0;
        foreach($_POST as $k => $v)
        {
            if($k != 'po' && $k != 'phase' && $k !='note')
            {
                if($flag==0)
                    $cnt=0;
                $flag=1;
                $dlm=strpos($k,"_");
                $id=substr($k,0,$dlm);
                $sel=substr($k,$dlm+1,strlen($k));
                if($tamp == $id)
                    $cnt=$cntTamp;
                $dt[$cnt]['cpm_detail_id']=$id;

                if($sel == '0')
                    $dt[$cnt]['actual_score']=$v;
                else
                    $dt[$cnt]['actual_weight']=$v;
                if($check[0]['total'] == 0)
                {
                    $dt[$cnt]["cpm_id"]=$check[0]['id'];
                    $dt[$cnt]["phase_id"]=$phase;
                    $dt[$cnt]["createby"]=$_SESSION['ID'];
                    $dt[$cnt]["createdate"]=date('Y-m-d H:i:s');
                }
                $tamp=$id;
                $cntTamp=$cnt;
            }
            $cnt++;
        }
        if($check[0]['total'] == 0)
        {
            $data=array(
                "cpm_id"=>$check[0]['id'],
                "phase_id"=>$phase,
                "createby"=>$_SESSION['ID'],
                "createdate"=>date('Y-m-d H:i:s')
            );
            $res=$this->mcc->add("t_cpm_detail_phase",$data);
            if($res == false)
                return $res;

            $res=$this->mcc->save_draft($dt);
        }
        else
            $res=$this->mcc->update_draft($dt,$check[0]['id'],$phase);
        // echopre($dt);
        // exit;

        return $res;
    }

/* ===========================================       Add data START     ====================================== */
    public function get_header() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mcc->get_header($po, $vendor);
        if ($res) {
            $res[0]->delivery_date = date('j F Y', strtotime($res[0]->delivery_date));
        }
        return $this->output($res);
    }

    public function get_list() {
        $res = $this->mcc->get_list();
        $dt = array();
        if (count($res) > 0) {
            foreach ($res as $k => $v) {
                $dt[$k][0] = $k+1;
                $dt[$k][1] = $v['po_no'];
                $dt[$k][2] = $v['cpm_id'];
                $dt[$k][3] = $v['title'];
                $dt[$k][4] = $v['ABBREVIATION'];
                $dt[$k][5] = $v['NAMA'];
                // $dt[$k][5] = date('j F Y', strtotime($v['due_date']));
                $dt[$k][6] = "<span class='badge badge badge-pill badge-success'>".$v['status']."</span>";
                $dt[$k][7] = "<button class='btn btn-sm btn-success' onclick='process(\"".$v['po_no']."\",".$v['id'].",".$v['vendor_id'].")'>Detail</button>";
            }
        }
        return $this->output($dt);
    }

    public function get_cpm_detail()
    {
        $po=$this->input->post('po');
        $phase=$this->input->post('phase');
        $vendor=$this->input->post('vendor');
        $res=$this->mcc->get_cpm_detail($po,$vendor,$phase);
        if($res != false)
            return $this->output($res);
        return $this->output();
    }

    public function get_upload($po) {
        $dt = array();
        $res = $this->mcc->get_upload($po);
        if ($res != false) {
            $count = 1;
            foreach($res as $k => $v) {
                $dt[$k][0] = $count;
                $dt[$k][1] = ucwords($v['type']);
                $dt[$k][2] = $v['file_name'];
                $dt[$k][3] = date('M j, Y H:i', strtotime($v['createdate']));
                $dt[$k][4] = "<span class='badge badge-pill badge-success'>".$v['name']."</span>";
                $dt[$k][5] = "<button class='btn btn-sm btn-primary' onclick=preview('".$v['path']."')><i class='fa fa-file'></i></button>";
                $count++;
            }
            return $this->output($dt);
        }
        else
            $this->output();
    }

    public function get_history() {
        $po = $this->input->post('po');
        $vendor = $this->input->post('vendor');
        $res = $this->mcc->get_history($po);
        if ($res != false && count($res) > 0) {
            $c = 0;
            foreach ($res as $k => $v) {
                $dt[$c][0] = $c + 1;
                $dt[$c][1] = ($v['phase'] == '' ? 'Pre Vendor' : $v['phase']);
                $dt[$c][2] = $v['description'];
                $dt[$c][3] = $v['keterangan'];
                $dt[$c][4] = date('M j, Y H:i', strtotime($v['created_at']));
                $c++;
            }
            return $this->output($dt);
        } else {
            return $this->output();
        }
    }
}
