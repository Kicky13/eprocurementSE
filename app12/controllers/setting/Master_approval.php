<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_approval extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');        
        $this->load->model('vendor/M_all_intern', 'mai');
        $this->load->model('setting/M_master_approval', 'mmc');        
        $this->load->model('vendor/M_vendor');        
    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show() {
        $result = $this->mmc->get_data();        
        $dt = array();
        if ($result != false) {                        
            foreach ($result as $k => $v) {                
                $dt[$k][0] = $k+1;                
                $dt[$k][1] = $v->user_roles;
                $dt[$k][2] = $v->sequence;
                $dt[$k][3] = $v->description;
                $dt[$k][4] = $v->modul;
                $dt[$k][5] = $v->reject_step;
                $dt[$k][6] = $v->email_approve;
                $dt[$k][7] = $v->email_reject;
                $dt[$k][8] = $v->edit_content;
                $dt[$k][9] = $v->extra_case;                
                $stat=$v->status;
                if($stat==1)
                    $stat="ACTIVE"; 
                else
                    $stat="NOT ACTIVE";                               
                $dt[$k][10] = $stat;
                if($k == 0)
                    $first='<button class="btn btn-sm btn-default disabled" onclick="up('.$v->id.','.$v->sequence.')"><i class="fa fa-arrow-up"></i></button>';
                else
                    $first='<button class="btn btn-sm btn-primary" onclick="up('.$v->id.','.$v->sequence.')"><i class="fa fa-arrow-up"></i></button>';
                if($k == count($result)-1)                    
                    $btn= '&nbsp<button class="btn btn-sm btn-default disabled" onclick="down('.$v->id.','.$v->sequence.')"><i class="fa fa-arrow-down"></i></button>';           
                else
                $btn= '&nbsp<button class="btn btn-sm btn-primary" onclick="down('.$v->id.','.$v->sequence.')"><i class="fa fa-arrow-down"></i></button>';           
                $end='&nbsp<button class="btn btn-sm btn-info" onclick="edit('.$v->id.')"><i class="fa fa-edit"></i></button>';
                $dt[$k][11] = $first.$btn.$end;
            }
        }
        $this->output($dt);
    }    

    public function add_data()
    {        
        $dt=array(
            "module"=>stripslashes($this->input->post('modul')),
            "user_roles"=>stripslashes($this->input->post('jabatan')),
            "description"=>stripslashes($this->input->post('desc')),            
            "sequence"=>stripslashes($this->input->post('seq')),            
            "reject_step"=>stripslashes($this->input->post('rej_step')),            
            "email_approve"=>stripslashes($this->input->post('mail_app')),            
            "email_reject"=>stripslashes($this->input->post('mail_rej')),            
            "extra_case"=>stripslashes($this->input->post('extra_case')),            
            "edit_content"=>stripslashes($this->input->post('edit_con')),            
            "STATUS"=>stripslashes($this->input->post('status')),
        );
        $key=stripslashes($this->input->post('key'));
        if($key == 0)
        {            
            $dt['createdate']=date('Y-m-d H:i:s');
            $dt['createby']=$_SESSION['ID_USER'];
            $dt['updateby']=$_SESSION['ID_USER'];
            $res=$this->mmc->cek($dt);
            if($res!= false)
            {
                $res=$this->mmc->add($dt);
                if($res != false)
                    $this->output(array("msg"=>"Data Berhasil Disimpan","Status"=>"Success"));
                else
                    $this->output(array("msg"=>"Data Gagal Disimpan","Status"=>"Error"));
            }
            else
            {
                $this->output(array("msg"=>"Data sudah ada","Status"=>"Error"));
            }
        }
        else{
            $dt['updatedate']=date('Y-m-d H:i:s');
            $dt['createby']=$_SESSION['ID_USER'];
            $dt['updateby']=$_SESSION['ID_USER'];
            $dt['id']=$key;
            $res=$this->mmc->update($dt);
            if($res != false)
                $this->output(array("msg"=>"Data Berhasil Disimpan","Status"=>"Success"));
            else
                $this->output(array("msg"=>"Data Gagal Disimpan","Status"=>"Error"));
        }
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
        $this->template->display('setting/V_master_approval', $data);
    }   

    public function get_ids()
    {
        $id=$this->input->post('id');
        $res=$this->mmc->get_ids($id);
        if($res != false)
            $this->output($res);
        else
            $this->output('false');
    }

    public function get_sel()
    {
        $dt=array();        
        $res=$this->mmc->get_sel();
        if($res != false)
        {                        
            foreach($res as $k => $v)
            {
                $dt['modul'][$k]=$v->modul;                
                $dt['id'][$k]=$v->id_mod;
                $dt['jabatan'][$k]=$v->jabatan;
                $dt['user'][$k]=$v->id_user;                
            }                        
            $dt['modul']=array_unique($dt['modul']);
            $dt['id']=array_unique($dt['id']);
            $dt['jabatan']=array_unique($dt['jabatan']);
            $dt['user']=array_unique($dt['user']);
            $new=array('modul'=>'','jabatan'=>'');
            
            foreach($dt['jabatan'] as $k => $v)                     
                $new['jabatan'].='<option value=\''.$dt['user'][$k].'\'>'.$v.'</option>';                                        
            foreach($dt['modul'] as $k => $v)            
                $new['modul'].='<option value=\''.$dt['id'][$k].'\'>'.$v.'</option>';
            $this->output(array('status'=>'Success',$new));
        }
        else{
            $this->output(array('status'=>'Error','msg'=>'Oops,Terjadi Kesalahan'));
        }
    }

    public function change_seq()
    {
        $id=stripslashes($this->input->post('id'));
        $sel=stripslashes($this->input->post('sel'));
        $seq=stripslashes($this->input->post('seq'));
        if($sel == "up")
            $seq -=1;
        else
            $seq +=1;
        $dt=array('sequence'=>$seq,'id'=>$id);
        $res=$this->mmc->change_seq($dt);
        if($res)
            $this->output(array('status'=>'Success','msg'=>'Berhasil update'));
        else
            $this->output(array('status'=>'Error','msg'=>'Oops,Terjadi Kesalahan'));        
    }
}