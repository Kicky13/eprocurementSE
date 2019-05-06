<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Award extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('string', 'text'));
        $this->load->model('approval/M_approval');
        $this->load->model('approval/M_bl');
        $this->load->model('vendor/M_send_invitation')->model('vendor/M_vendor');
        $this->load->helper('exchange_rate_helper');
        $this->load->model('vn/info/M_vn', 'mvn');
    }

    /*
    * ee where nego = 2
    * award t_eq_data;
    * award = 0 default
    * award = 1 Y perform award
    * award = 2 N to Propose Review EE
    * award = 3 receive award
    * award = 4 Y Approve prepare to Acknowledge
    * award = 5 N Reject, Back to Perform Award = 1 atau award dibuat = 1
    * award = 6 acknowledge user representative
    */
    public function ee($bled_no='')
    {
        if($this->input->post('id'))
        {
            $this->M_bl->update_eq_data();
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'EE';
            if(empty($bled_no))
            {
                $greetings = $this->M_approval->getBledNoNego();
                $data['greetings'] = $greetings;
                $this->template->display('award/ee', $data);
            }
            else
            {
                $msr = $this->db->where(['bled_no'=>$bled_no])->get('t_bl')->row();
                $msr_no = $msr->msr_no;
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $this->template->display('award/ee-form', $data);
            }
        }
    }
    public function par($msr_no='')
    {
        if($this->input->post('id'))
        {
            $data = $this->input->post();
            print_r($data);
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'Perform Award Recomendation';
            if(empty($msr_no))
            {
                $greetings = $this->M_bl->getPar();
                $data['greetings'] = $greetings;
                $this->template->display('award/par', $data);
            }
            else
            {
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $this->template->display('award/par-form', $data);
            }
        }
    }
    public function recomendation()
    {
        $this->M_approval->approvalEdEvaluation();
        $this->session->set_flashdata('message', array(
            'message' => __('success_submit'),
            'type' => 'success'
        ));
        echo "<script>
            window.open('".base_url('home')."','_self');
        </script>";
        exit();
        if($data['packet'] == 1)
        {
            foreach ($data['msr_item'] as $msr_item_id => $vendor_id) {
                $this->db->where(['msr_detail_id'=>$msr_item_id,'created_by'=>$vendor_id,'bled_no'=>$data['id']]);
                $this->db->update('t_bid_detail', ['award'=>1]);

                $bl = $this->db->where(['bled_no'=>$data['id']])->get('t_bl')->row();

                $this->db->where(['vendor_id'=>$vendor_id,'msr_no'=>$bl->msr_no]);
                $this->db->update('t_bl_detail', ['awarder'=>1, 'awarder_date'=>date('Y-m-d')]);
            }
            echo "Success Award";
        }
        else
        {
            /*packet*/
            $bl = $this->db->where(['bled_no'=>$data['id']])->get('t_bl')->row();

            $this->db->where(['vendor_id'=>$data['vendor_id'],'msr_no'=>$bl->msr_no]);
            $this->db->update('t_bl_detail', ['awarder'=>1, 'awarder_date'=>date('Y-m-d')]);

            $this->db->where(['created_by'=>$data['vendor_id'],'bled_no'=>$data['id']]);
            $this->db->update('t_bid_detail', ['award'=>1]);
            echo "Success Award";
        }
    }
    public function approval($msr_no='')
    {
        if($this->input->post('id'))
        {
            $data = $this->input->post();
            $this->db->where(['id'=>$data['id']]);
            $this->db->update('t_eq_data', ['award'=>$data['award']]);
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit'),
                'type' => 'success'
            ));
            echo "Success";
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'Approval Award Recomendation';
            if(empty($msr_no))
            {
                $greetings = $this->M_approval->greeting_award_approval();
                $data['greetings'] = $greetings;
                $data['link'] = 'approval';
                // $data['awardtobeissued'] = false;
                $this->template->display('award/approval', $data);
            }
            else
            {
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $data['approval'] = true;
                $data['msr_no'] = $msr_no;
                $data['awardtobeissued'] = false;
                $data['msr'] = $this->M_approval->findMsrByMsrNo($msr_no);
                $data['bod'] = $this->bodApproval($msr_no);
                $this->template->display('award/approval-form', $data);
            }
        }
    }
    public function ackawardrec($msr_no='')
    {
        if($this->input->post('id'))
        {
            $data = $this->input->post();
            $this->db->where(['id'=>$data['id']]);
            $this->db->update('t_eq_data', ['award'=>6]);
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'Acknowledge Award Recomendation';
            if(empty($msr_no))
            {
                $greetings = $this->M_approval->ackAwardRecomendation();
                $data['greetings'] = $greetings;
                $data['link'] = 'ackawardrec';
                $this->template->display('award/approval', $data);
            }
            else
            {
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $data['ack'] = true;
                $this->template->display('award/approval-form', $data);
            }
        }
    }
    public function ackawradapproval($msr_no='')
    {
        if($this->input->post('id'))
        {
            $data = $this->input->post();
            $this->db->where(['id'=>$data['id']]);
            $this->db->update('t_eq_data', ['award'=>7]);
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'Approval Acknowledge Award';
            if(empty($msr_no))
            {
                $greetings = $this->M_approval->ackAwardRecomendationApproval();
                $data['greetings'] = $greetings;
                $data['link'] = 'ackawradapproval';
                $this->template->display('award/approval', $data);
            }
            else
            {
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $data['ackapproval'] = true;
                $this->template->display('award/approval-form', $data);
            }
        }
    }
    public function receiveawardrecev($msr_no='')
    {
        if($this->input->post('id'))
        {
            $data = $this->input->post();
            $this->db->where(['id'=>$data['id']]);
            $this->db->update('t_eq_data', ['award'=>7]);
        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'Award Recomendation & Evaluation';
            if(empty($msr_no))
            {
                $greetings = $this->M_approval->receiveawardrecev();
                $data['greetings'] = $greetings;
                $data['link'] = 'receiveawardrecev';
                $this->template->display('award/approval', $data);
            }
            else
            {
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $data['receiveawardrecev'] = true;
                $this->template->display('award/approval-form', $data);
            }
        }
    }
    public function awardtobeissued($msr_no='')
    {
        if($this->input->post('id'))
        {
            $data = $this->input->post();
            $edid = $data['id'];
            $this->db->where(['id'=>$data['id']]);
            unset($data['id']);
            foreach ($data as $key => $value) {
                $data[$key] = empty($value) ? null : $value;
            }

            $config['upload_path']  = './upload/award/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'],0755,TRUE);
            }
            $config['allowed_types']= 'pdf';
            $config['encrypt_name']= true;
            $this->load->library('upload', $config);

            if(@$_FILES['path_boc']['tmp_name'])
            {
                if ( ! $this->upload->do_upload('path_boc'))
                {
                    echo $this->upload->display_errors('', '');
                    return false;
                    exit;
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['path_boc'] = $upload_data['file_name'];
                }
            }

            /*if($_FILES['path_bod']['tmp_name'])
            {
                if ( ! $this->upload->do_upload('path_bod'))
                {
                    echo $this->upload->display_errors('', '');
                    return false;
                    exit;
                }
                else
                {
                    $upload_data = $this->upload->data();
                    $data['path_bod'] = $upload_data['file_name'];
                }
            }*/

            $this->db->update('t_eq_data', $data);

            //Send Email
                    ini_set('max_execution_time', 500);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


                    $query = $this->db->query("SELECT distinct g.title as titlemsr,g.company_desc,v.ID_VENDOR  as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE from t_eq_data t
                        join t_bl_detail d on d.msr_no=t.msr_no
                        join t_msr_item r on r.msr_no=d.msr_no and r.msr_no=t.msr_no
                        join t_bid_detail f on f.msr_detail_id=r.line_item and f.award=1 and f.created_by=d.vendor_id
                        join m_vendor v on v.ID=f.created_by
                        join m_notic n on n.ID=40
                        join t_msr g on g.msr_no=t.msr_no
                        where t.id='".$edid."'");
                    if ($query->num_rows() > 0) {
                      $data_role = $query->result();
                      $count = 1;
                    } else {
                      $count = 0;
                    }

                    if ($count === 1) {

                      $str = $data_role[0]->OPEN_VALUE;
                      $str = str_replace('_var1_',$data_role[0]->company_desc,$str);
                      $str = str_replace('_var2_',$data_role[0]->titlemsr,$str);

                      $data = array(
                        'img1' => $img1,
                        'img2' => $img2,
                        'title' => $data_role[0]->TITLE,
                        'open' => $str,
                        'close' => $data_role[0]->CLOSE_VALUE
                      );

                      foreach ($data_role as $k => $v) {
                        $data['dest'][] = $v->recipient;
                      }
                      $flag = $this->sendMail($data);

                    }

                    //End Send Email
            echo "Issued Award Notification";

        }
        else
        {
            $get_menu = $this->M_vendor->menu();
            $dt = array();
            foreach ($get_menu as $k => $v) {
                $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
                $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
                $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
            }
            $data['menu'] = $dt;
            $data['titleApp'] = 'Award Recomendation & Evaluation';
            if(empty($msr_no))
            {
                $greetings = $this->M_approval->awardtobeissued_data();
                $data['greetings'] = $greetings;
                $data['awardtobeissued'] = true;
                $data['link'] = 'awardtobeissued';
                $this->template->display('award/approval', $data);
            }
            else
            {
                $data['t_bl']       = $this->db->where(['msr_no'=>$msr_no])->get('t_bl')->row();
                $data['ed']         = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();
                $data['msr'] = $this->db->select('t_msr.*,m_company.DESCRIPTION company_name,m_msrtype.MSR_DESC msr_name, m_plocation.PGroup_Desc proc_location_name, m_costcenter.COSTCENTER_DESC cost_center_name, m_pmethod.PMETHOD_DESC proc_method_name, m_currency.CURRENCY currency')
        ->join('m_company','m_company.ID_COMPANY=t_msr.id_company')
        ->join('m_msrtype','m_msrtype.ID_MSR=t_msr.id_msr_type')
        ->join('m_plocation','m_plocation.ID_Pgroup=t_msr.id_ploc')
        ->join('m_user','m_user.ID_USER=t_msr.create_by')
        ->join('m_costcenter','m_costcenter.ID_COSTCENTER=m_user.COST_CENTER')
        ->join('m_pmethod','m_pmethod.ID_PMETHOD=t_msr.id_pmethod')
        ->join('m_currency','m_currency.ID=t_msr.id_currency')
        ->where('msr_no',$msr_no)->get('t_msr')->row();
                $data['blDetails']  = $this->vendor_lib->blDetail($msr_no);
                $data['doc']        = $this->db->where(['module_kode'=>'bled','data_id'=>$msr_no])->get('t_upload')->result();
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $data['technicalAttachment'] = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                $data['adminAttachment'] = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                $data['awardtobeissued'] = true;
                $data['sum_award_total_value'] = $this->M_approval->sumawardtotalvalue($msr_no);
                $data['msr_no'] = $msr_no;
                if($data['ed']->currency != 3)
                {
                    $m_currency = $this->db->where(['ID'=>$data['ed']->currency])->get('m_currency')->row();
                    $data['sum_award_total_value'] = exchange_rate($m_currency->CURRENCY, 'USD', $data['sum_award_total_value']);
                }
                $data['js']         = $this->load->view('approval/devbledjs', array(), true);
                $this->template->display('award/issued', $data);
            }
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
                //$this->email->message();
                //$this->email->to($v);

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
                        ';
                //$this->email->message();
                //$this->email->to($content['email']);

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
    public function generate_award_approval($msr_no='')
    {
        $result = $this->M_approval->generate_award_approval($msr_no);
    }
    public function approval_ajax($msr_no='')
    {
        $data['msr_no'] = $msr_no;
        $this->load->view('approval/award_approval_ajax', $data);
    }
    public function par_view($value='')
    {
        $data = $this->input->post();

        $recomendation = $data['recomendation'];
        $this->session->set_userdata('pemenang', $recomendation);

        $data['result'] = $this->load->view('approval/par_view', [], true);
        $data['popup'] = $this->load->view('approval/par_view_popup', [], true);
        echo json_encode($data);
    }
    public function do_award()
    {
        $data = $this->input->post();
        foreach ($variable as $key => $value) {

        }
    }
    public function check_award_validation($value='')
    {
        $post = $this->input->post();
        $msr_no = $post['msr_no'];

        /*bidder not yet evaluation*/
        $t_bl_detail = $this->db->where(['msr_no'=>$msr_no,'confirmed'=>1])->where_in('commercial', [0])->get('t_bl_detail');
        $t_bl_detail_num = $t_bl_detail->num_rows();
        /*bidder fail*/
        $t_bl_detail = $this->db->where(['msr_no'=>$msr_no,'confirmed'=>1])->where_in('commercial', [0,2])->get('t_bl_detail');
        $t_bl_detail_rs = $t_bl_detail->result();
        $bidder_fail = 0;
        /*when as recommendation*/
        foreach ($t_bl_detail_rs as $r) {
            if(in_array($r->vendor_id, $post['recomendation']))
            {
                $bidder_fail = 1;
            }
        }
        /*Insufficient budget*/
        $t_msr_budget = $this->db->where(['status_budget'=>'Insufficient', 'msr_no'=>$msr_no])->get('t_msr_budget');
        $t_msr_budget_num = $t_msr_budget->num_rows();

        /*close = 0 nego*/
        $t_nego = $this->db->where(['closed'=>0, 'msr_no'=>$msr_no])->get('t_nego');
        $t_nego_num = $t_nego->num_rows();

        /*lowest_price_val Total value can not above MSR value*/
        $currency = $this->db->select('m_currency.ID m_currency_id,t_msr.id_currency, t_msr.total_amount, t_eq_data.ee_value')
        ->join('m_currency','m_currency.ID = t_eq_data.currency')
        ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no')
        ->where(['t_eq_data.msr_no'=>$msr_no])->get('t_eq_data')->row();

        $exchange_rate_by_id = exchange_rate_by_id(
            $currency->m_currency_id,
            $currency->id_currency,
            $post['lowest_price_val']
        );

        $total_amount = $currency->ee_value > 0 ? $currency->ee_value : $currency->total_amount;

        $status = true;
        if($t_bl_detail_num > 0 or $bidder_fail == 1 or $t_msr_budget_num > 0 or $t_nego_num > 0 or $exchange_rate_by_id > $total_amount)
        {
            $status = false;
        }


        if($status)
        {
            echo json_encode(['status'=>true]);
        }
        else
        {
            $data['lists'] = [
                'Commercial Evaluation not yet evaluated' => ($t_bl_detail_num > 0 ? 'x' : 'v'),
                'Failed Bidder can not be selected' => ($bidder_fail > 0 ? 'x' : 'v'),
                'Total value can not above MSR value' => ($exchange_rate_by_id > $total_amount ? 'x' : 'v'),
                'Negotiation in progress' =>( $t_nego_num > 0 ? 'x' : 'v'),
                'Sufficient budget' => ($t_msr_budget_num > 0 ? 'x' : 'v'),
            ];
            $html = $this->load->view('award/check_award_validation', $data, true);
            echo json_encode(['html'=>$html]);
        }
    }
    public function bodApproval($msr_no='')
    {
        $m_approval = $this->db->select('m_approval.*')
        ->join('m_approval','m_approval.id = t_approval.m_approval_id', 'left')
        ->where(['data_id'=>$msr_no, 'created_by'=>$this->session->userdata('ID_USER'), 'm_approval.module_kode'=>'award'] )
        ->get('t_approval')->row();
        if($m_approval->opsi == 'coo' or $m_approval->opsi == 'cfo' or $m_approval->opsi == 'ceo')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function review_ee()
    {
        $post = $this->input->post();
        $msr_no = $post['msr_no'];

        $currency = $this->db->select('m_currency.ID m_currency_id,t_msr.id_currency, t_msr.total_amount, m_currency.CURRENCY CURRENCY')
        ->join('m_currency','m_currency.ID = t_eq_data.currency')
        ->join('t_msr','t_msr.msr_no = t_eq_data.msr_no')
        ->where(['t_eq_data.msr_no'=>$msr_no])->get('t_eq_data')->row();

        $exchange_rate_by_id = exchange_rate_by_id(
            $currency->m_currency_id,
            $currency->id_currency,
            $post['lowest_price_val']
        );

        $data['total']      = $exchange_rate_by_id;
        $data['currency']   = $currency;
        $data['msr_no']     = $msr_no;
        $this->load->view('award/review_ee', $data);
    }
    public function review_ee_store()
    {
        $post = $this->input->post();
        $file_name = '';

        if(@$_FILES['ee_file']['tmp_name'])
        {
            $config['upload_path']  = './upload/ee/';
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path'],0755,TRUE);
            }
            $config['allowed_types']= '*';
            $config['encrypt_name']= true;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('ee_file'))
            {
                $err =  $this->upload->display_errors('', '');
                echo "<script>alert($err)</script>";
                echo "<script>window.open('".base_url('approval/approval/tobeadmin/'.$post['msr_no'])."','_self')</script>";
                exit;
            }
            else
            {
                $upload = $this->upload->data();
                $file_name = $upload['file_name'];
            }
        }

        $this->db->where(['msr_no'=>$post['msr_no']]);
        $this->db->update('t_eq_data', [
            'ee_value' => $post['ee_value'],
            'ee_file' => $file_name,
            'ee_desc' => $post['ee_desc'],
        ]);
        echo "<script>
            alert('Success Update EE Review');
            window.open('".base_url('approval/approval/tobeadmin/'.$post['msr_no'])."','_self');
        </script>";
    }
}