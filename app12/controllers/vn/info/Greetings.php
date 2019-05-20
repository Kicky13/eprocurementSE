<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Greetings extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('exchange_rate');
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('vn/info/M_slka', 'msl');
        $this->load->model('vn/info/M_vn', 'mvn');
        $this->load->model('vn/info/M_all_vendor');
        $this->load->model('approval/M_bl');
        $this->load->model('vendor/M_message');
        $this->load->model('procurement/M_regret_letter');
        $this->load->model('m_base');
        $this->load->model('procurement/m_service_receipt');
        $this->load->model('procurement/arf/m_arf_notification');
        $this->load->model('procurement/arf/m_arf_response');
        $this->load->model('procurement/arf/m_arf_recommendation_preparation');
        $this->load->model('procurement/arf/T_approval_arf_recom');
        $this->load->model('procurement/arf/m_arf_nego');
        $this->load->helper('exchange_rate_helper')->helper(array('form', 'array', 'url', 'exchange_rate'));
        $this->load->library('phpqrcode/qrlib');
    }

    public function index() {
        $id = $this->session->userdata('ID_VENDOR');
        $cek = $this->M_all_vendor->cek_session();
        $stat=$this->session->status_vendor;
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
        $all['menu'] = $dt;
        $this->template->display_vendor('vn/info/V_greetings', $all);
    }

    public function list($type='')
    {
        if ($type == 1) {
            $title = 'Confirmed Participation';
        } elseif ($type == 10) {
            $title = 'Decline Participation';
        } elseif ($type == 11) {
            $title = 'Bid Submited';
        } else {
            $title = 'Unconfirmed Participation';
        }
        $id = $this->session->ID_VENDOR;
        $cek = $this->M_all_vendor->cek_session();
        $stat=$this->session->status_vendor;

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
        $all['type'] = $type;
        $all['title'] = $title;
        $this->template->display_vendor('vn/info/V_greetings_list', $all);
    }

    public function detail($type='', $bled_no='') {
        $this->session->set_userdata('referred_from', current_url());
        $msr_no = str_replace('OQ', 'OR', $bled_no);
        $id = $this->session->ID_VENDOR;
        $cek = $this->M_all_vendor->cek_session();
        $stat=$this->session->status_vendor;

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
        $this->db->where_in('module_kode', array('bidnote'))
        ->where('vendor_id', $this->session->ID)
        ->where('data_id', $bled_no)
        ->update('t_note', array(
            'is_read' => 1
        ));
        $this->db->where_in('module_kode', array('addendum_bled'))
        ->where('vendor_id', $this->session->ID)
        ->where('data_id', $msr_no)
        ->update('t_note', array(
            'is_read' => 1
        ));
        $branch=array();
        $all['type'] = $type;
        $all['bled_no'] = $bled_no;
        $all['msr_no'] = $msr_no;
        $all['js']         = $this->load->view('approval/devbledjs', array(), true);
        $all['vendor_id'] = $this->session->ID;
        $all['message'] = $this->M_message->get(['module_kode'=>'reject-decline-vendor'])->result();
        $all['addendum'] = $this->db->select('t_addendum.*, m_user.NAME as creator')
        ->join('m_user', 'm_user.ID_USER = t_addendum.created_by')
        ->where('module', 'bled')
        ->where('id_ref', $msr_no)
        ->order_by('created_at', 'desc')
        ->get('t_addendum')
        ->result();
        $this->template->display_vendor('vn/info/greeting_detail', $all);
    }
    public function confirmation()
    {
        $x = $this->input->post();
        $this->db->where(['id'=>$x['id']]);
        $this->db->update('t_bl_detail', array(
            'confirmed' => $x['status'],
            'reason' => @$x['reason']
        ));
        if ($x['status'] == 1) {
            $this->session->set_flashdata('message', array(
                'message' => __('success_accept'),
                'type' => 'success'
            ));
        } else {
            $this->session->set_flashdata('message', array(
                'message' => __('success_decline'),
                'type' => 'success'
            ));
        }


        redirect(base_url('vn/info/greetings/'));
    }
    public function quotation($value='')
    {
        $data = $this->input->post();
        $msr_no = $data['msr_no'];
        $id = $this->session->userdata('ID');
        $bidhead['bled_no'] = $data['bled_no'];
        $bidhead['bid_letter_no'] = $data['bid_letter_no'];
        $bidhead['id_local_content_type'] = $data['id_local_content_type'];
        $bidhead['local_content'] = $data['local_content'];
        $bidhead['bid_validity'] = $data['bid_validity'];
        $bidhead['note'] = $data['note'];
        /*$bidhead['delivery_month'] = $data['delivery_month'];
        $bidhead['delivery_week'] = $data['delivery_week'];*/
        $bidhead['delivery_nilai'] = $data['delivery_nilai'];
        $bidhead['delivery_satuan'] = $data['delivery_satuan'];
        $bidhead['created_by'] = $id;
        /*echo "<pre>";
        print_r($data);
        exit();*/
        if($_FILES['soc']['tmp_name'])
        {
            $bidhead['soc'] = $this->doUpload('soc');
        }
        if($_FILES['soc']['tmp_name'])
        {
            $bidhead['tp'] = $this->doUpload('tp');
        }
        if($_FILES['pb']['tmp_name'])
        {
            $bidhead['pl'] = $this->doUpload('pb');
        }
        if($_FILES['local_content_path']['tmp_name'])
        {
            $bidhead['local_content_path'] = $this->doUpload('local_content_path');
        }
        if($_FILES['bid_letter_path']['tmp_name'])
        {
            $bidhead['bid_letter_path'] = $this->doUpload('bid_letter_path');
        }

        $this->db->trans_begin();
        $t_bid_head = $this->db->where(['bled_no'=>$data['bled_no'], 'created_by'=>$id])->get('t_bid_head');
        if($t_bid_head->num_rows() > 0)
        {
            $row = $t_bid_head->row();
            $this->db->where(['id'=>$row->id]);
            $this->db->update('t_bid_head', $bidhead);
        }
        else
        {
            $bidhead['created_at'] = date("Y-m-d");
            $this->db->insert('t_bid_head', $bidhead);
        }

        $biddetail['msr_no'] = $msr_no;
        $biddetail['created_by'] = $id;
        $biddetail['vendor_id'] = $id;

        foreach ($data['unit_price'] as $key => $value) {
            $value = number_value($value);
            // $t_bid_detail = $this->db->where(['bled_no'=>$data['bled_no'], 'created_by'=>$id, 'msr_detail_id'=>$key])->get('t_bid_detail');
            $t_bid_detail = $this->db->where(['msr_no'=>$msr_no, 'vendor_id'=>$id, 'sop_id'=>$key])->get('t_sop_bid');
            // $biddetail['msr_detail_id'] = $key; old
            $biddetail['sop_id'] = $key; //new
            $biddetail['id_currency'] = $data['id_currency'];
            $biddetail['qty'] = $data['qty_'][$key];
            $biddetail['unit_price'] = $value;
            $biddetail['id_currency_base'] = $data['id_currency_base'];
            $biddetail['unit_price_base'] = exchange_rate_by_id($data['id_currency'], $data['id_currency_base'], $value);
            $biddetail['unit_value'] = $data['unit_value'][$key];
            $biddetail['unit_uom'] = $data['unit_uom'][$key];
            $biddetail['deviation'] = $data['deviation'][$key];
            $biddetail['remark'] = $data['remark'][$key];

            if($t_bid_detail->num_rows() > 0)
            {
                $row = $t_bid_detail->row();
                $this->db->where(['id'=>$row->id]);
                // $this->db->update('t_bid_detail', $biddetail); old
                $this->db->update('t_sop_bid', $biddetail); // new
            }
            else
            {
                $biddetail['created_at'] = date("Y-m-d");
                // $this->db->insert('t_bid_detail', $biddetail); old
                $this->db->insert('t_sop_bid', $biddetail); // new
            }
        }

        $tbd['bled_no'] = $data['bled_no'];
        $tbd['created_by'] = $id;

        $variable = "select msr_item_id, sum(unit_price) unit_price, sum(nego_price), sum(unit_price_base) unit_price_base, sum(nego_price_base), sum(qty) qty, (sum(qty) * sum(unit_price)) total_unit_price, (sum(qty) * sum(nego_price)) total_nego_price, (sum(qty) * sum(unit_price_base)) total_unit_price_base, (sum(qty) * sum(nego_price_base)) total_nego_price_base
            from t_sop_bid
            left join t_sop on t_sop.id = t_sop_bid.sop_id where t_sop_bid.msr_no = '$msr_no' and t_sop_bid.vendor_id = $id
            group by msr_item_id";

        foreach ($this->db->query($variable)->result() as $r) {
            $t_bid_detail = $this->db->where(['bled_no'=>$data['bled_no'], 'created_by'=>$id, 'msr_detail_id'=>$r->msr_item_id])->get('t_bid_detail');
            $tbd['msr_detail_id'] = $r->msr_item_id;
            $tbd['id_currency'] = $data['id_currency'];
            $tbd['unit_price'] = $r->total_unit_price;
            $tbd['id_currency_base'] = $data['id_currency_base'];
            $tbd['unit_price_base'] = $r->total_unit_price_base;

            if($t_bid_detail->num_rows() > 0)
            {
                $row = $t_bid_detail->row();
                $this->db->where(['id'=>$row->id]);
                $this->db->update('t_bid_detail', $tbd);
            }
            else
            {
                $biddetail['created_at'] = date("Y-m-d");
                $this->db->insert('t_bid_detail', $tbd);
            }
        }

        $this->db->where(['vendor_id'=>$id, 'msr_no'=>$msr_no]);
        $this->db->update('t_bl_detail', ['submission_date'=>date("Y-m-d")]);

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            $this->session->set_flashdata('message', array(
                'message' => __('success_submit'),
                'type' => 'success'
            ));
            echo json_encode(['status'=>true,'msg'=>'Bid Submission Done']);
        }
        else
        {
            $this->db->trans_rollback();
            $this->session->set_flashdata('message', array(
                'message' => __('failed_submit'),
                'type' => 'danger'
            ));
            echo json_encode(['status'=>true,'msg'=>'Bid Submission Fail, Try Again']);
        }
    }
    public function doUpload($file_path='')
    {
        $config['upload_path']  = './upload/bid/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
        $config['allowed_types']= '*';
        $config['encrypt_name']= true;
        // $config['max_size']      = '3000';

        // print_r($_FILES['upload']);
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload($file_path))
        {
            echo $this->upload->display_errors('', '');
            return false;
            exit;
        }else
        {
            $user = user();
            $data = $this->upload->data();
            // $field = $this->input->post();
            // $field['file_path'] = $data['file_name'];
            return $data['file_name'];
        }
    }
    public function savebidbond($value='')
    {
        if (!file_exists($_FILES['bid_bond_file']['tmp_name'])) {
            $response = array(
                'error' => 'You have to upload Bid Bond Document'
            );
            echo json_encode($response);
        } else {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('bid_bond_no', 'Bid Bond No', 'required');
            $this->form_validation->set_rules('issuer', 'Issuer', 'required');
            $this->form_validation->set_rules('issued_date', 'Issued Date', 'required');
            $this->form_validation->set_rules('nominal', 'Value', 'required');
            $this->form_validation->set_rules('effective_date', 'Effective Date', 'required');
            $this->form_validation->set_rules('expired_date', 'Expired Date', 'required');
            if (!$this->form_validation->run()) {
                $response = array(
                    'error' => validation_errors('<div>', '</div>')
                );
                echo json_encode($response);
            } else {
                $id = $this->session->userdata('ID');
                $data = $this->input->post();
                $data['nominal'] = number_value($data['nominal']);
                $data['created_by'] = $id;
                $data['bid_bond_file'] = $this->doUpload('bid_bond_file');
                $this->db->insert('t_bid_bond',$data);

                $t_bid_bond = $this->vendor_lib->tBidBond($data['bled_no'], $id)->result();
                $td = "";
                foreach ($t_bid_bond as $key => $value) {
                    $td .= "<tr>
                        <td>$value->bid_bond_no</td>
                        <td>$value->issuer</td>
                        <td>".dateToIndo($value->issued_date)."</td>
                        <td class='text-right'>".numIndo($value->nominal)."</td>
                        <td class='text-center'>$value->currency_name</td>
                        <td>".dateToIndo($value->effective_date)."</td>
                        <td>".dateToIndo($value->expired_date)."</td>
                        <td class='text-center'>".($value->bid_bond_file ? '<a href="'.base_url('upload/bid/'.$value->bid_bond_file).'" class="btn btn-info btn-sm">Download</a>' : '-')."</td>
                        <td>$value->description</td>
                        <td class='text-right'><button type='button' class='btn btn-danger btn-sm' onclick='deleteBidBond(\"".$value->id."\")'>Delete</button></td>
                    </tr>";
                }
                echo json_encode(array('data' => $td));
            }
        }
    }
    public function sendbidproposal()
    {
        $data = $this->input->post();
        $this->db->where(['id'=>$data['id']]);
        $this->db->update('t_bid_head',['status'=>1]);
    }
    public function checkbidbond($value='')
    {
        $id = $this->session->userdata('ID');
        $data = $this->input->get();
        $bled_no = $data['bled_no'];
        $t_bid_bond = $this->vendor_lib->tBidBond($data['bled_no'], $id);
        // echo $this->db->last_query();
        if($t_bid_bond->num_rows() > 0)
        {
            echo json_encode(array('status'=>true));
        }
        else
        {
            echo json_encode(array('status'=>false));
        }
    }
    public function negolist($value='')
    {
        $id = $this->session->ID_VENDOR;
        $cek = $this->M_all_vendor->cek_session();
        $stat=$this->session->status_vendor;

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
        $idVendor = $this->session->userdata('ID');
        $all['idVendor'] = $idVendor;
        $all['lists'] = $this->vendor_lib->getNegoVendorSessionData();
        $all['type'] = 'nego';
        $this->template->display_vendor('vn/info/V_greeting_msr_items', $all);
    }
    public function submit_negotiation($value='')
    {
        $this->db->trans_begin();
        $data = $this->input->post();
        $msr_no = $data['msr_no'];
        $bled_no = $data['bled_no'];

        $id = $this->session->userdata('ID');
        foreach ($data['unit_price'] as $key => $value) {
            $row = $this->db->where(['msr_no'=>$msr_no, 'vendor_id'=>$id, 'sop_id'=>$key])->get('t_sop_bid')->row();

            $field['nego_price'] = $value;
            $field['nego_price_base'] = exchange_rate_by_id($data['id_currency'], $data['id_currency_base'], $value);
            $this->db->where(['id'=>$row->id]);
            $this->db->update('t_sop_bid', $field);
        }

        $variable = "select msr_item_id, sum(unit_price) unit_price, sum(nego_price) nego_price, sum(unit_price_base) unit_price_base, sum(nego_price_base), sum(qty) qty, (sum(qty) * sum(unit_price)) total_unit_price, (sum(qty) * sum(nego_price)) total_nego_price, (sum(qty) * sum(unit_price_base)) total_unit_price_base, (sum(qty) * sum(nego_price_base)) total_nego_price_base
            from t_sop_bid
            left join t_sop on t_sop.id = t_sop_bid.sop_id where t_sop_bid.msr_no = '$msr_no' and t_sop_bid.vendor_id = $id
            group by msr_item_id";

        foreach ($this->db->query($variable)->result() as $r) {
            $t_bid_detail = $this->db->where(['bled_no'=>$data['bled_no'], 'created_by'=>$id, 'msr_detail_id'=>$r->msr_item_id])->get('t_bid_detail');
            $row = $t_bid_detail->row();
            $tbd['nego_price'] = $r->total_nego_price;
            $tbd['nego_price_base'] = $r->total_nego_price_base;

            $this->db->where(['id'=>$row->id]);
            $this->db->update('t_bid_detail', $tbd);
        }

        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            echo 'Success Submited';
        }
        else
        {
            $this->db->trans_rollback();
            echo 'Fail, Try Again';
        }
    }
    public function award($status=1, $msr_no='')
    {
        $this->session->set_userdata('referred_from', current_url());
        if($msr_no)
        {
            $this->session->set_userdata('referred_from', current_url());
            $id = $this->session->ID_VENDOR;
            $cek = $this->M_all_vendor->cek_session();
            $stat=$this->session->status_vendor;

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
            $all['type'] = 1;
            $all['bled_no'] = $msr_no;
            // $all['js']         = $this->load->view('approval/devbledjs', array(), true);
            $all['vendor_id'] = $this->session->ID;
            $all['status'] = $status;
            $this->template->display_vendor('vn/info/award-form', $all);
        }
        else
        {
            $id = $this->session->ID_VENDOR;
            $cek = $this->M_all_vendor->cek_session();
            $stat=$this->session->status_vendor;

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
            $idVendor = $this->session->userdata('ID');
            $all['idVendor'] = $idVendor;
            $all['lists'] = $this->vendor_lib->accept_award_nomination($status);
            $all['type'] = 'award';
            $all['status'] = $status;
            $this->template->display_vendor('vn/info/awardlist', $all);
        }
    }
    public function terima($value='')
    {
        // accept_award
        $data = $this->input->post();

        // Send Email Notification for lose supplier
        $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
        $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";

        $query = $this->db->query("SELECT t.title as TITLEMSR,b.msr_no,v.id_vendor as EMAIL,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE from t_bl_detail b
            join m_vendor v on v.ID=b.vendor_id
            join m_notic n on n.id=41
            join t_msr t on t.msr_no=b.msr_no
            where b.msr_no=(select msr_no from t_bl_detail where id=7) and b.awarder=0");
        $data_role = $query->result();

        $res = $data_role;

        $data2 = array(
            'img1' => $img1,
            'img2' => $img2,
            'title' => $data_role[0]->TITLE,
            'open' => str_replace("_var1_", $data_role[0]->TITLEMSR, $data_role[0]->OPEN_VALUE),
            // 'open2' =>,
            'close' => $data_role[0]->CLOSE_VALUE
        );

        foreach ($res as $k => $v) {
            $data2['dest'][] = $v->EMAIL;
        }

        $flag = $this->sendMail($data2);
        // End Email

        $this->db->where(['id'=>$data['t_bl_detail_id']]);
        $this->db->update('t_bl_detail',['accept_award'=>$data['accept_award'], 'desc_accept_award'=>$data['desc_accept_award'], 'accept_award_date' => date('Y-m-d')]);
        $referred_from = $this->session->userdata('referred_from');
        redirect(base_url('vn/info/greetings/'));
    }

    // --------------------------------------- sendmail  --------------------------------------------
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
    public function withdraw()
    {
        $result = $this->M_bl->withdraw();
        if($result)
        {
            $this->session->set_flashdata('message', array(
                'message' => __('success_withdraw'),
                'type' => 'success'
            ));
            echo 'Success Submited';
        }
        else
        {
            echo 'Fail, Try Again';
        }
    }
    public function vendor_msr_all($value='')
    {

    }

    public function regretLetterList()
    {
        $menu = get_main_vendor_menu();

        $letters = $this->M_regret_letter->vendorInquiry($this->session->userdata('ID'));

        $this->template->display_vendor('procurement/V_regret_letter_vendor_list', compact(
            'menu', 'letters'
        ));
    }

    public function regretLetterShow($id)
    {
        $letter = $this->M_regret_letter->find($id);

        $letter = $this->M_regret_letter->findByBlDetailId($letter->bl_detail_id);

        $this->template->display_vendor('procurement/V_regret_letter', compact(
            'menu', 'letter'
        ));
    }

    public function loi()
    {
        $this->load->model('setting/M_master_company');

        $lois = $this->vendor_lib->getIssuedLoI(['resource' => false, 'orderBy' => "loi_date DESC"]);
        $m_master_company = $this->M_master_company;

        return $this->template->display_vendor('vn/info/V_loi_issued_list', compact(
            'menu', 'lois', 'm_master_company'
        ));

    }

    public function showLoi($id)
    {
        $this->load->model("procurement/M_loi")
            ->model('procurement/M_loi_attachment')
            ->model('setting/M_master_company')
            ->model('setting/M_currency')
            ->model('vendor/M_show_vendor');

        $message = array();
        $vendor_id = $this->session->userdata('ID');

        $menu = get_main_vendor_menu();

        $loi = $this->M_loi->find($id);

        if (!$loi) {
           show_error('Document Letter of Intent not found');
        }

        if ($vendor_id && $loi->awarder_id != $vendor_id) {
            show_error('Not authorized');

            if ($loi->issued != '1') {
               show_error('Document not ready yet');
            }
        }


    	$loi_attachment_type = $this->M_loi_attachment->getTypes();
        $loi_attachment = $this->M_loi_attachment->getByDocument($loi->id);
        $m_loi_attachment = $this->M_loi_attachment;
    	$company = $this->M_master_company->find($loi->id_company);
    	$awarder = $this->M_show_vendor->find($loi->awarder_id);
        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');

        $this->template->display_vendor('procurement/V_loi_show', compact(
            'menu', 'loi', 'message', 'company', 'awarder', 'loi_attachment', 'loi_attachment_type',
            'm_loi_attachment', 'opt_currency'
        ));
    }

    public function loiAcceptance($id)
    {
        $this->load->model("procurement/M_loi")
            ->model('procurement/M_loi_attachment')
            ->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('setting/M_currency')
            ->helper(['form', 'file', 'exchange_rate'])
            ->library(['form_validation', 'upload']);

    	$this->config->load('file_upload', true);

    	$this->uploadConfig = $this->config->item('loi', 'file_upload');

        $message = array();
        $vendor_id = $this->session->userdata('ID');

        $menu = get_main_vendor_menu();
        $message = ['type' => '', 'message' => ''];

        $loi = $this->M_loi->find($id);

        if (!$loi) {
           show_error('Document Letter of Intent not found');
        }

        if ($loi->awarder_id != $this->session->userdata('ID')) {
            show_error('Not authorized');
        }

        if ($vendor_id && $loi->awarder_id != $vendor_id) {
            show_error('Not authorized');

            if ($loi->issued != '1') {
               show_error('Document not ready yet');
            }
        }

        if ($loi->accepted == 1) {
            show_error('Document already accepted');
        }

        // TODO: add validation
        if ($this->input->post()) {
            $hitdb = true;
            $this->upload->initialize($this->uploadConfig);

            $upload_res = $this->upload->do_upload($this->M_loi_attachment::TYPE_SIGNED_LOI);

            if ($upload_res === false || !($signed_loi_file = $this->upload->data())) {
               $hitdb = false;
               $message['type'] = 'danger';
               $message['message'] = $this->upload->display_errors();
            }

            if ($hitdb) {
                $this->db->trans_begin();

                $this->M_loi_attachment->add([
                    'module_kode'   => $this->M_loi::module_kode,
                    'data_id'       => $loi->id,
                    'file_path'     => $this->uploadConfig['upload_path'],
                    'file_name'     => $signed_loi_file['file_name'],
                    'tipe'          => $this->M_loi_attachment::TYPE_SIGNED_LOI,
                    'created_by'    => $this->session->userdata('ID'),
                    'created_at'    => today_sql()
                ]);

                $this->M_loi->accept($loi->id);

                $this->db->trans_complete();

                if ($this->db->trans_status() !== false) {
                    $this->db->trans_commit();

                    log_history($this->M_loi::module_kode, $loi->id, 'Accepted');

	                $this->session->set_flashdata('message', array(
	                    'message' => 'Letter of Intent number '.$loi->company_letter.' accepted',
	                    'type' => 'success'
	                ));

                    return redirect('vn/info/greetings/loi');
                }

                $this->db->trans_rollback();
            }
        }

    	$loi_attachment_type = $this->M_loi_attachment->getTypes();
        $loi_attachment = $this->M_loi_attachment->getByDocument($loi->id);
        $m_loi_attachment = $this->M_loi_attachment;
    	$company = $this->M_master_company->find($loi->id_company);
    	$awarder = $this->M_show_vendor->find($loi->awarder_id);
        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');

        $this->template->display_vendor('procurement/V_loi_to_supplier_accept', compact(
            'menu', 'loi', 'message', 'company', 'awarder', 'loi_attachment', 'loi_attachment_type',
            'm_loi_attachment', 'message', 'opt_currency'
        ));
    }

    public function agreement()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_msr')
            ->model('approval/M_approval')
            ->model('procurement/M_purchase_order');

        $message = array();
        $menu = get_main_vendor_menu();

        $pos = $this->M_purchase_order->getIssuedByVendor($this->session->userdata('ID'));

        if (! $pos) {
            $message['type'] = 'info';
            $message['message'] = 'There is no document to be issued yet';
        }

        $this->template->display_vendor('procurement/V_po_to_agreement_list', compact(
            'menu', 'pos', 'message'
        ));
    }

    public function showAgreement($id)
    {
        $this->load->model('approval/M_bl')
            ->model('procurement/M_purchase_order')
            ->model('procurement/M_purchase_order_type')
            ->model('procurement/M_purchase_order_detail')
            ->model('procurement/M_purchase_order_document')
            ->model('procurement/M_purchase_order_required_doc')
            ->model('procurement/M_purchase_order_attachment')
            ->model('setting/M_tkdn_type')
            ->model('user/M_view_user')
            ->model('setting/M_master_department')
            ->model('setting/M_master_company')
            ->model('setting/m_msr_inventory_type')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_msr')
            ->model('other_master/M_currency')
            ->model('setting/M_material_uom')
            ->model('setting/M_multi_uom_mapping')
            ->model('setting/M_delivery_point')
            ->model('setting/M_importation')
            ->model('setting/M_itemtype')
            ->helper(['array', 'form', 'exchange_rate', 'material']);

        $message = array();
        $menu = get_main_vendor_menu();

        if (!$id) {
            show_error("Invalid request", 400);
        }

        $po = $this->M_purchase_order->find($id);

        if (!$po) {
            show_404('The Purchase Order document is not found');
        }

        $po_attachment_type = $this->M_purchase_order_attachment->getTypes();

        $po = $this->M_purchase_order->find($id);
        $msr = $this->M_msr->find($po->msr_no);
        $po_items = $this->M_purchase_order_detail->findByPOId($po->id);
        $po_attachments = $this->M_purchase_order_attachment->getByDocument($po->id, [
            $this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO,
            $this->M_purchase_order_attachment::TYPE_SIGNED_PO
        ]);
        $po_required_doc = [];
        foreach($this->M_purchase_order_required_doc->getByPOId($po->id) as $reqdoc) {
            $po_required_doc[$reqdoc->doc_type] = $reqdoc;
        }
        $opt_po_required_doc = array_pluck($po_required_doc, 'doc_type');
        $company = $this->M_master_company->find($msr->id_company);
        $vendor = $this->M_show_vendor->find($po->id_vendor);
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

        $requestor = $this->M_view_user->show_user($msr->create_by);
        $requestor_dept = $this->M_master_department->find($msr->id_department);

        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');
        $opt_dpoint = array_pluck($this->M_delivery_point->all(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_importation = array_pluck($this->M_importation->all(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_tkdn_type = array_pluck($this->M_tkdn_type->all(), 'name', 'id');
        $opt_item_type = array_pluck($this->M_itemtype->all(), "ITEMTYPE_DESC", "ID_ITEMTYPE");
        $opt_msr_inventory_type = array_pluck($this->m_msr_inventory_type->all(), "description", "id");

        // $po->tkdn_value_average = tkdn_average($po->tkdn_type, $po->tkdn_value_goods, $po->tkdn_value_service);

        foreach($po as $prop => $val) {
            $_POST[$prop] = $val;
        }

        $this->template->display_vendor('procurement/V_po_show_vendor', compact(
            'menu', 'po', 'po_items', 'message', 'company', 'vendor', 'po_attachments', 'po_attachment_type',
            'approval_list', 'po_required_doc', 'opt_po_required_doc', 'roles',
            'msr', 'opt_currency', 'opt_dpoint', 'opt_importation', 'opt_tkdn_type',
            'opt_item_type', 'requestor', 'requestor_dept', 'opt_msr_inventory_type'
        ));

    }

    function deletebidbond($bled_no, $id) {
        $this->db->where('id', $id)
        ->delete('t_bid_bond');
        $t_bid_bond = $this->vendor_lib->tBidBond($bled_no, $this->session->userdata('ID'))->result();
        $td = "";
        foreach ($t_bid_bond as $key => $value) {
            $td .= "<tr>
                <td>$value->bid_bond_no</td>
                <td>$value->issuer</td>
                <td>".dateToIndo($value->issued_date)."</td>
                <td class='text-right'>".numIndo($value->nominal)."</td>
                <td class='text-center'>$value->currency_name</td>
                <td>".dateToIndo($value->effective_date)."</td>
                <td>".dateToIndo($value->expired_date)."</td>
                <td class='text-center'>".($value->bid_bond_file ? '<a href="'.base_url('upload/bid/'.$value->bid_bond_file).'" class="btn btn-info btn-sm"><i class="fa fa-download"></i> Download</a>' : '-')."</td>
                <td class='text-center'>".statusBid($value->status)."</td>
                <td>$value->description</td>
                <td class='text-right'><button type='button' class='btn btn-danger btn-sm' onclick='deleteBidBond(\"".$value->id."\")'><i class='fa fa-trash'></i></button></td>
            </tr>";
        }
        echo json_encode(array('data' => $td));
    }

    public function negotiation() {
        $this->M_all_vendor->cek_session();
        $this->template->display_vendor('vn/info/V_negotiation');
    }

    public function negotiation_response($id) {
        $negotiation = $this->vendor_lib->find_negotiation($id);
        $items = $this->vendor_lib->get_negotiation_items($id);
        $this->template->display_vendor('vn/info/V_negotiation_response', array(
            'negotiation' => $negotiation,
            'items' => $items
        ));
    }

public function doUpload_bid_letter_file() {
		$response = array();
        $config['upload_path'] = './upload/NEGOTIATION';
        $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx';
        $config['max_size'] = '2048';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
		if ($_FILES['bid_letter_file']['tmp_name']) {
            if (!$this->upload->do_upload('bid_letter_file')) {
                $response = array(
                    'success' => false,
                    'message' => $this->upload->display_errors()
                );
                echo json_encode($response);
                return false;
            }
            $bid_letter_file = $this->upload->data();
			$response = array(
				'success' => true,
				'view' => 'bid_letter_view',
				'message' => $bid_letter_file['file_name']
			);
			echo json_encode($response);
			return false;
        }

	}

    public function doUpload_local_content_file() {
		$response = array();
        $config['upload_path'] = './upload/NEGOTIATION';
        $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx';
        $config['max_size'] = '2048';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
		if ($_FILES['local_content_file']['tmp_name']) {
            if (!$this->upload->do_upload('local_content_file')) {
                $response = array(
                    'success' => false,
                    'message' => $this->upload->display_errors()
                );
                echo json_encode($response);
                return false;
            }
            $local_content_file = $this->upload->data();
			$response = array(
				'success' => true,
				'view' => 'local_content_view',
				'message' => $local_content_file['file_name']
			);
			echo json_encode($response);
			return false;
        }


	}

    public function negotiation_submit($id) {
        $post = $this->input->post();
        $response = array();
        $config['upload_path'] = './upload/NEGOTIATION';
        $config['allowed_types'] = 'pdf|jpg|jpeg|doc|docx';
        $config['max_size'] = '2048';
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload', $config);
        if ($_FILES['bid_letter_file']['tmp_name']) {
            if (!$this->upload->do_upload('bid_letter_file')) {
                $response = array(
                    'success' => false,
                    'message' => $this->upload->display_errors()
                );
                echo json_encode($response);
                return false;
            }
            $bid_letter_file = $this->upload->data();
            $post['bid_letter_file'] = $bid_letter_file['file_name'];
        }

        if ($_FILES['local_content_file']['tmp_name']) {
            if (!$this->upload->do_upload('local_content_file')) {
                $response = array(
                    'success' => false,
                    'message' => $this->upload->display_errors()
                );
                echo json_encode($response);
                return false;
            }
            $local_content_file = $this->upload->data();
            $post['local_content_file'] = $local_content_file['file_name'];
        }
        $this->load->library('form_validation');
        $this->form_validation->set_data($post);
        $this->form_validation->set_rules('bid_letter_no', 'Bid Letter No', 'required');
        $this->form_validation->set_rules('id_local_content_type', 'Local Content Type', 'required');
        $this->form_validation->set_rules('local_content', 'Local Content', 'required');
        $this->form_validation->set_rules('bid_letter_file', 'Bid Letter File', 'required');
        $this->form_validation->set_rules('local_content_file', 'Local Content File', 'required');
        foreach ($this->vendor_lib->get_negotiation_items($id)->result() as $item) {
            $this->form_validation->set_rules('negotiation['.$item->id.'][nego_price]', 'Nego Price '.$item->item, 'required');
        }
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            return false;
        }

        $nego = $this->db->where('id', $id)->get('t_nego')->row();

        $this->db->where('id', $id)
        ->where('vendor_id', $this->session->ID)
        ->update('t_nego', array(
            'bid_letter_no' => $post['bid_letter_no'],
            'bid_letter_file' => $post['bid_letter_file'],
            'id_local_content_type' => $post['id_local_content_type'],
            'local_content' => $post['local_content'],
            'local_content_file' => $post['local_content_file'],
            'bid_note' => $post['bid_note'],
            'status' => 1,
            'responsed_at' => date('Y-m-d H:i:s')
        ));

        foreach ($post['negotiation'] as $sop_id => $negotiation) {
            $nego_price = number_value($negotiation['nego_price']);
            $negotiation_price_base = exchange_rate_by_id($negotiation['id_currency'], $negotiation['id_currency_base'], $nego_price);
            $this->db->where('nego_id', $id)
            ->where('vendor_id', $this->session->ID)
            ->where('sop_id', $sop_id)
            ->update('t_nego_detail', array(
                'negotiated_price' => $nego_price,
                'negotiated_price_base' => $negotiation_price_base,
            ));
            $this->db->where('sop_id', $sop_id)
            ->where('vendor_id', $this->session->ID)
            ->update('t_sop_bid', array(
                'nego_price' => $nego_price,
                'nego_price_base' => $negotiation_price_base,
                'nego' => 1,
                'nego_date' => date('Y-m-d')
            ));
        }

        $unsubmit_nego = $this->db->where('msr_no', $nego->msr_no)
        ->where('company_letter_no', $nego->company_letter_no)
        ->where('status', 0)
        ->get('t_nego')
        ->result();

        if (!$unsubmit_nego) {
            $this->db->where('msr_no', $nego->msr_no)
            ->where('company_letter_no', $nego->company_letter_no)
            ->update('t_nego', array(
                'closed' => 1
            ));
        }

        $response = array(
            'success' => true,
            'message' => 'Your negotiation has been submitted'
        );

        $this->session->set_flashdata('message', array(
            'message' => __('success_submit'),
            'type' => 'success'
        ));

        echo json_encode($response);
    }
}
