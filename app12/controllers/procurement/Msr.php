<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Msr extends CI_Controller {
    const module_kode = 'msr';

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user/M_user_roles')
            ->model('vendor/M_vendor')
            ->model('material/M_uom')
            ->model('procurement/M_msr', 'msr')
            ->model('procurement/M_msr_item', 'msr_item')
            ->model('procurement/M_msr_attachment', 'msr_attachment')
            ->model('procurement/M_msr_draft')
            ->model('procurement/M_purchase_order_type')
            ->model('procurement/M_msr_item_draft')
            ->model('setting/M_master_company', 'company')
            ->model('setting/M_msrtype', 'msrtype')
            ->model('other_master/M_currency', 'currency')
            ->model('setting/M_pmethod', 'pmethod')
            ->model('setting/M_pgroup', 'plocation')
            ->model('setting/M_master_costcenter', 'cost_center')
            ->model('setting/M_location', 'location')
            ->model('setting/M_delivery_point', 'delivery_point')
            ->model('setting/M_delivery_term', 'delivery_term')
            ->model('setting/M_importation', 'importation')
            ->model('setting/M_requestfor', 'requestfor')
            ->model('setting/M_master_inspection', 'inspection')
            ->model('setting/M_freight', 'freight')
            ->model('setting/M_itemtype', 'itemtype')
            ->model('setting/M_master_acc_sub', 'accsub')
            ->model('procurement/M_msr', 'msr')
            ->model('procurement/M_msr_item', 'msr_item')
            ->model('procurement/M_msr_attachment', 'msr_attachment')
            ->model('setting/M_msr_inventory_type')
            ->model('setting/M_itemtype_category')
            ->model('setting/M_master_department')
            ->model('material/M_uom')
            ->model('approval/M_approval')
            ->model('setting/M_jabatan')
            ->model('setting/M_budget_holder')
            ->helper(array('form', 'array', 'url', 'exchange_rate', 'permission'))
            ->library(['form_validation', 'DocNumber', 'upload', 'form']);
			//machrus library 'form'
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['menu'] = $dt;
        $this->template->display('procurement/V_msr', $data);
    }

    public function show($msr_no)
    {
        $this->load->model('other_master/M_currency', 'currency')
             ->model('approval/M_approval')
             ->model('setting/M_itemtype', 'itemtype')
             ->model('other_master/M_currency', 'currency')
             ->model('setting/M_master_department')
             ->helper(['date', 'array', 'form', 'material', 'exchange_rate']);

        if (! ($msr = $this->msr->find($msr_no))) {
            show_error('Document not found');
        }

        $menu = get_main_menu();

        // $_POST['msr_no'] = $msr->msr_no;
        // $_POST['company'] = $msr->company_desc;
        // $_POST['required_date'] = $msr->req_date;
        // $_POST['msr_type'] = $msr->msr_type_desc;
        // $_POST['lead_time'] = $msr->lead_time;
        // $_POST['title'] = $msr->title;
        // $_POST['plocation'] = $msr->rloc_desc;
        // $_POST['pmethod'] = $msr->pmethod_desc;
        // $_POST['id_currency'] = $msr->id_currency;
        // $_POST['costcenter'] = $msr->costcenter_desc;

        $_POST['msr_no'] = $msr->msr_no;
        $_POST['msr_stts'] = $msr->status;
        $_POST['id_company'] = $msr->id_company;
        $_POST['company_desc'] = $msr->company_desc;
        $_POST['req_date'] = $msr->req_date;
        $_POST['id_msr_type'] = $msr->id_msr_type;
        $_POST['msr_type_desc'] = $msr->msr_type_desc;
        $_POST['lead_time'] = $msr->lead_time;
        $_POST['title'] = $msr->title;
        $_POST['id_ploc'] = $msr->id_ploc;
        $_POST['rloc_desc'] = $msr->rloc_desc;
        $_POST['id_pmethod'] = $msr->id_pmethod;
        $_POST['pmethod_desc'] = $msr->pmethod_desc;
        $_POST['id_currency'] = $msr->id_currency;
        $_POST['currency_desc'] = @$this->currency->find($msr->id_currency)->CURRENCY;
        $_POST['scope_of_work'] = $msr->scope_of_work;
        $_POST['id_dpoint'] = $msr->id_dpoint;
        $_POST['dpoint_desc'] = $msr->dpoint_desc;
        $_POST['id_importation'] = $msr->id_importation;
        $_POST['importation_desc'] = $msr->importation_desc;
        $_POST['id_requestfor'] = $msr->id_requestfor;
        $_POST['requestfor_desc'] = $msr->requestfor_desc;
        $_POST['id_inspection'] = $msr->id_inspection;
        $_POST['inspection_desc'] = $msr->inspection_desc;
        $_POST['id_deliveryterm'] = $msr->id_deliveryterm;
        $_POST['deliveryterm_desc'] = $msr->deliveryterm_desc;
        $_POST['id_freight'] = $msr->id_freight;
        $_POST['freight_desc'] = $msr->freight_desc;
        $_POST['id_costcenter'] = $msr->id_costcenter;
        $_POST['costcenter_desc'] = $msr->costcenter_desc;
        $_POST['total_amount'] = $msr->total_amount;
        $_POST['total_amount_base'] = $msr->total_amount_base;
        $_POST['procure_processing_time'] = $msr->procure_processing_time;
        $_POST['blanket'] = $msr->blanket;
        $_POST['master_list'] = $msr->master_list;
        $_POST['attachment_cancel'] = $msr->attachment_cancel;

        $creator = user($msr->create_by);
        /* $creator_dept = $this->M_master_department->findByDeptAndCompany($creator->ID_DEPARTMENT, $msr->id_company); */
        $_POST['create_by'] = @$msr->create_by;
        $_POST['create_by_name'] = @$creator->NAME;
        $_POST['create_on'] = $msr->create_on;
        $_POST['creator_department_name'] = $msr->department_desc;

        $msr_item = $this->msr_item->getByMsrNo($msr_no);
        $t = $this;
        array_walk($msr_item, function(&$item) use($t){
            $uom = $t->M_uom->findByMaterialUom($item->uom);

            $item->uom_description = @$uom->DESCRIPTION;
            $item->uom_id = @$uom->ID;
        });
        $_POST['items'] = $msr_item;

        $msr_attachment = $this->msr_attachment->getByMsrNo($msr_no);
        $_POST['attachments'] = $msr_attachment;

        $opt_itemtype = array_pluck($this->itemtype->all(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $opt_currency = array_pluck($this->currency->all(), 'DESCRIPTION', 'ID');
        $opt_msr_inventory_type = array_pluck($this->M_msr_inventory_type->all(), 'description', 'id');
        $opt_msr_attachment_type = $this->msr_attachment->getTypes();

        $this->template->display('procurement/V_msr_show', compact(
            'menu', 'opt_itemtype', 'opt_currency', 'opt_msr_attachment_type', 'opt_msr_inventory_type'
        ));
    }

    public function get($id) {
        echo json_encode($this->M_user_roles->show(array("ID_USER_ROLES" => $id)));
    }

    public function change() {
        $menu = null;
        foreach ($_POST['menu'] as $k => $v) {
            $menu_tmp = $menu . "," . $v;
            $menu = $menu_tmp;
        }
        $menu = substr($menu, 1);

        $data = array(
            'DESCRIPTION' => strtoupper(stripslashes($_POST['desc'])),
            'MENU' => $menu,
            'STATUS' => $_POST['status'],
            'UPDATE_BY' => 1,
            'UPDATE_TIME' => date('Y-m-d H:i:s')
        );
        if ($_POST['id'] == null) {//add data
            $data['CREATE_BY'] = 1;
            $cek = $this->M_user_roles->show(array("DESCRIPTION" => strtoupper(stripslashes($_POST['desc']))));
            if (count($cek) == 0) {//cek ketersediaan data
                $q = $this->M_user_roles->add($data);
            } else {
                echo "Tipe Desckripsi Telah Digunakan";exit;
            }
        } else {//update data
            $q = $this->M_user_roles->update($_POST['id'], $data);
        }

        //CEK QUERY BERHASIL DIJALANKAN
        if ($q == 1) {
            echo "sukses";
        } else {
            echo "Gagal Menambah Data!";
        }
    }

    function get_treeview(){
        echo '[{"id":1,"text":"Asia","population":null,"flagUrl":null,"checked":true,"hasChildren":false,"children":[{"id":2,"text":"China","population":1373541278,"flagUrl":"http://code.gijgo.com/flags/24/China.png","checked":false,"hasChildren":false,"children":[]},{"id":3,"text":"Japan","population":126730000,"flagUrl":"http://code.gijgo.com/flags/24/Japan.png","checked":false,"hasChildren":false,"children":[]},{"id":4,"text":"Mongolia","population":3081677,"flagUrl":"http://code.gijgo.com/flags/24/Mongolia.png","checked":false,"hasChildren":false,"children":[]}]},{"id":5,"text":"North America","population":null,"flagUrl":null,"checked":false,"hasChildren":false,"children":[{"id":6,"text":"USA","population":325145963,"flagUrl":"http://code.gijgo.com/flags/24/United%20States%20of%20America(USA).png","checked":false,"hasChildren":false,"children":[{"id":7,"text":"California","population":39144818,"flagUrl":null,"checked":false,"hasChildren":false,"children":[]},{"id":8,"text":"Florida","population":20271272,"flagUrl":null,"checked":false,"hasChildren":false,"children":[]}]},{"id":9,"text":"Canada","population":35151728,"flagUrl":"http://code.gijgo.com/flags/24/canada.png","checked":false,"hasChildren":false,"children":[]},{"id":10,"text":"Mexico","population":119530753,"flagUrl":"http://code.gijgo.com/flags/24/mexico.png","checked":false,"hasChildren":false,"children":[]}]},{"id":11,"text":"South America","population":null,"flagUrl":null,"checked":false,"hasChildren":false,"children":[{"id":12,"text":"Brazil","population":207350000,"flagUrl":"http://code.gijgo.com/flags/24/brazil.png","checked":false,"hasChildren":false,"children":[]},{"id":13,"text":"Argentina","population":43417000,"flagUrl":"http://code.gijgo.com/flags/24/argentina.png","checked":false,"hasChildren":false,"children":[]},{"id":14,"text":"Colombia","population":49819638,"flagUrl":"http://code.gijgo.com/flags/24/colombia.png","checked":false,"hasChildren":false,"children":[]}]},{"id":15,"text":"Europe","population":null,"flagUrl":null,"checked":false,"hasChildren":false,"children":[{"id":16,"text":"England","population":54786300,"flagUrl":"http://code.gijgo.com/flags/24/england.png","checked":false,"hasChildren":false,"children":[]},{"id":17,"text":"Germany","population":82175700,"flagUrl":"http://code.gijgo.com/flags/24/germany.png","checked":false,"hasChildren":false,"children":[]},{"id":18,"text":"Bulgaria","population":7101859,"flagUrl":"http://code.gijgo.com/flags/24/bulgaria.png","checked":false,"hasChildren":false,"children":[]},{"id":19,"text":"Poland","population":38454576,"flagUrl":"http://code.gijgo.com/flags/24/poland.png","checked":false,"hasChildren":false,"children":[]}]}]';
    }

    public function create()
    {
        $this->load->model('setting/M_master_company', 'company')
            ->model('setting/M_msrtype', 'msrtype')
            ->model('other_master/M_currency', 'currency')
            ->model('setting/M_pmethod', 'pmethod')
            ->model('setting/M_pgroup', 'plocation')
            ->model('setting/M_master_costcenter', 'cost_center')
            ->model('setting/M_location', 'location')
            ->model('setting/M_delivery_point', 'delivery_point')
            ->model('setting/M_delivery_term', 'delivery_term')
            ->model('setting/M_importation', 'importation')
            ->model('setting/M_requestfor', 'requestfor')
            ->model('setting/M_master_inspection', 'inspection')
            ->model('setting/M_freight', 'freight')
            ->model('setting/M_itemtype', 'itemtype')
            ->model('setting/M_master_acc_sub', 'accsub')
            ->model('procurement/M_msr', 'msr')
            ->model('procurement/M_msr_item', 'msr_item')
            ->model('procurement/M_msr_attachment', 'msr_attachment')
            ->model('setting/M_itemtype_category')
            ->model('material/M_uom')
            ->helper(array('form', 'array', 'url', 'exchange_rate'))
            ->library(['form_validation', 'DocNumber', 'upload']);

        $message = array('type' => '', 'message' => '');
        $doctype = $this->msr::module_kode;
        $attachment_file = array();

        $post = $this->input->post();
        /*echo "<pre>";
        print_r($post);
        exit();*/

        if ($post && $this->validateCreate($post)) {
            // translate for second AAS approval
            $post['user_id'] = $_GET['user_id'] = $_POST['user_id'] = $_POST['submit-second-aas-approver-id'];

            $hit_db = true;

            if (!$this->check_exchange_rate_setup()) {
                $hit_db = false;
                $message = array(
                    'type' => 'error',
                    'message' => 'Exchange rate for currency must be setup first'
                );
            }
            // Upload attachment files
            /*
            if ($post['msr_type'] == 'MSR02' || (in_array($post['pmethod'], array('DA', 'DS'))) ) {
                if (! $this->handleUpload()) {
                    $message['message'] = $this->upload->display_errors();
                    $message['type'] = 'error';

                    $hit_db = false;
                } else {
                    $attachment_file = $this->upload->get_multi_upload_data();
                }
            }
            */

            $this->handleUpload();

            if ($upload_error_message  = $this->upload->display_errors()) {
                $message['message'] = $upload_error_message;
                $message['type'] = 'error';
                $hit_db = false;
            }

            $attachment_file = $this->upload->get_multi_upload_data();

            $msr_no = trim($this->input->post('msr_no'));
            $mode = !empty($msr_no) ? 'edit': 'new';

            if ($hit_db) {
                if ($mode == 'new') {
                    try {
                        // Get Document (a.k.a MSR) Number
                        $msr_no = DocNumber::generate($doctype, $post['company']);
                    } catch (RuntimeException $e) {
                       show_error($e->getMessage());
                    }
                }

                $input_data['header'] = $this->makeHeaderFromPost($msr_no);
                // map input from user to model
                // $post['scope_of_work'],
                // $post['location']

                // save data
                $this->db->trans_start();
                if ($mode == 'new') {
                    $header_result = $this->msr->add($input_data['header']);
                } else {
                    $input_data['header']['msr_no'] = $msr_no;
                    $header_result = $this->msr->update($msr_no, $input_data['header']);
                }

                if ($msr_no && $header_result) {
                    $input_data['header']['msr_no'] = $msr_no;
                }

                // TODO: use 'sync' method
                $this->msr_item->deleteByMsrNo($msr_no);

                if ($msr_no && $header_result && count($post['items']) > 0) {
                    $msr = $this;

                    $input_data['items'] = array_map(
                        function($item) use($msr, $input_data) {
                            return $msr->makeItem($input_data, $item);
                        },
                        $post['items']
                    );

                    $item_result = $this->msr_item->addBatch($input_data['items']);

                    // add msr budget
                    // if (!empty($post['msr_itemid_val'])) { $msr_item_id_val = $post['msr_itemid_val']; } else { $msr_item_id_val = ""; }
                    // if (!empty($post['status_budget'])) { $msr_item_id_val = $post['status_budget']; } else { $msr_item_id_val = ""; }
                    // if (!empty($post['msr_book_val'])) { $msr_item_id_val = $post['msr_book_val']; } else { $msr_item_id_val = ""; }
                    //
                    $this->msr_item->deleteMsrBudgetByMsrNo($msr_no);
                    if (count($post['items_budget']) > 0) {
                      foreach ($post['items_budget'] as $value) {
                        // echopre($data_msrbudget);
                        // exit;
                        $data_msrbudget = array(
                          'msr_no' => $msr_no,
                          'msr_item_id' => $value['msr_itemid_val'],
                          'costcenter_id' => @$value['costcenter_id'],
                          'accsub_id' => @$value['accsub_id'],
                          'status_budget' => @$value['stat_budget'] ?: '',
                          'msr_booking_amount' => $value['msr_book_val'],
                        );
                        $msrbudget_res = $this->msr_item->addMsrBudget($data_msrbudget);
                      }
                    }
                }

                // Update already uploaded attachment
                $current_attachments = $this->msr_attachment->getByModuleKodeAndDataId(
                    $this->msr::module_kode,
                    $msr_no
                );

                $attachment_file_ids = array_pluck(@$post['attachments'] ?: [], 'attachment_file_id');

                foreach($current_attachments as $i => $cur_att) {
                    // Delete attachment that already exists but deleted by user
                    if (!in_array($cur_att->id, $attachment_file_ids))  {
                        // NOTE: only delete data, NOT file
                        //machrus inactive delete attcment
                        //$this->msr_attachment->delete($cur_att->id);
                    } else {
                        $_attachment = $post['attachments'][$i];
                        $this->msr_attachment->update($cur_att->id, [
                            'tipe' => $_attachment['attachment_type']
                        ]);
                    }
                }

                if ($msr_no && (count($attachment_file) > 0 || count(@$post['attachments']) > 0)) {
                    $pre_attached = [];
                    $upload_config = $this->msr_attachment->getUploadConfig();
                    foreach($post['attachments'] as $attachment) {
                        if (isset($attachment['attachment_file_id'])
                            && !empty($attachment['attachment_file_id'])) {

                            $file = $this->msr_attachment->find($attachment['attachment_file_id']);
                            if (!$file) {
                                continue;
                            }

                            // left it as it
                            if ($file->module_kode == $this->msr::module_kode) {
                                continue;
                            }

                            // only handle attachment 'imported' from other module

                            $pre_attached[] = $this->makeAttachment(
                                $msr_no,
                                $this->msr::module_kode,
                                $attachment,
                                (array) $file,
                                $upload_config
                            );
                        }
                    }

                    $new_attachments = [];
                    if (count($attachment_file) > 0) {
                        $new_attachments = $this->makeAttachmentsFromPost(
                            $msr_no,
                            $this->msr::module_kode,
                            $attachment_file
                        );
                    }


                    $input_data['attachments'] = array_merge($pre_attached, $new_attachments);

                    if (count($input_data['attachments']) > 0) {
                        if($post['draft_id'] > 0)
                        {
                            $attachment_file = $post['attachments'];
                            $t_upload = $this->db->where(['module_kode'=>'msr_draft', 'data_id'=>$post['draft_id']])->get('t_upload')->result();
                            
                            $this->db->where(['module_kode'=>'msr_draft','data_id'=>$post['draft_id']]);
                            $this->db->update('t_upload', ['module_kode'=>'msr', 'data_id' => $msr_no]);
                        }
                        else
                        {
                            $this->saveAttachments($input_data['attachments']);
                        }
                    }
                }

                // if we have draft before, delete it
                $draft_id = $this->input->post('draft_id');
                if ($draft_id) {
                    // TODO: should we delete the draft document ? YES

                    $this->M_msr_draft->delete($draft_id);
                    $this->M_msr_item_draft->deleteAllByDraftId($draft_id);
                }

                $this->db->trans_complete();

                if ($this->db->trans_status() !== FALSE) { // redirect to somewhere
                    // Document approval goes here
                    if ($mode == 'edit') {
                        $this->M_approval->deleteApproval($this->msr::module_kode, $msr_no);
                        $this->M_approval->deleteApproval('msr_spa', $msr_no);
                        generate_msr_approval($msr_no);
                    } elseif ($mode == 'new') {
                        generate_msr_approval($msr_no);
                    }


                    //Send Email
                    ini_set('max_execution_time', 500);
                    $img1 = "<img src='https://4.bp.blogspot.com/-X8zz844yLKg/Wky-66TMqvI/AAAAAAAABkM/kG0k_0kr5OYbrAZqyX31iUgROUcOClTwwCLcBGAs/s1600/logo2.jpg'>";
                    $img2 = "<img src='https://4.bp.blogspot.com/-MrZ1XoToX2s/Wky-9lp42tI/AAAAAAAABkQ/fyL__l-Fkk0h5HnwvGzvCnFasi8a0GjiwCLcBGAs/s1600/foot.jpg'>";


                    $query = $this->db->query("SELECT distinct u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM t_approval t
                        join m_approval m on m.id=t.m_approval_id and m.module_kode='msr'
                        join m_user u on u.roles like CONCAT('%', m.role_id ,'%')
                        join m_notic n on n.ID=35
                        where t.data_id='".$msr_no."' and t.urutan=1");
                    if ($query->num_rows() > 0) {
                      $data_role = $query->result();
                      $count = 1;
                    } else {
                      $count = 0;
                    }

                    if ($count === 1) {

                      $query = $this->db->query("SELECT distinct t.title,u.NAME,d.DEPARTMENT_DESC from t_msr t
                        join m_user u on u.ID_USER=t.create_by
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where msr_no='".$msr_no."' ");

                      $data_replace = $query->result();

                      $res = $data_role;
                      $str = $data_role[0]->OPEN_VALUE;
                      $str = str_replace('_var1_',$data_replace[0]->title,$str);
                      $str = str_replace('_var2_',$data_replace[0]->NAME,$str);
                      $str = str_replace('_var3_',$data_replace[0]->DEPARTMENT_DESC,$str);

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

                    $this->session->set_flashdata('message', array(
                        'message' => __('success_submit_with_number', array('no' => $input_data['header']['msr_no'])),
                        'type' => 'success'
                    ));

                    return redirect('/home');
                }

                $message['type'] = 'error';
                $message['message'] = sprintf('Failed save MSR document (#%s)', $input_data['header']['msr_no']);
                log_message($message['type'], $message['message']);
            }
        }

        $is_writable = !isset($msr_no) || empty($msr_no);
        $user_company = explode(',', $this->session->userdata('COMPANY'));

        $menu =  get_main_menu();

        $opt_company = array_pluck($this->company->findAllActive($user_company), "DESCRIPTION", "ID_COMPANY");

        $opt_msr_type = array_pluck($this->msrtype->allActive(), 'MSR_DESC', 'ID_MSR');
        $opt_msr_type = array_filter($opt_msr_type, function($id_msr) {
            return in_array($id_msr, array('MSR01', 'MSR02'));
        }, ARRAY_FILTER_USE_KEY);

        $pmethods = $this->pmethod->allActive();
        $opt_pmethod = array_pluck($pmethods, 'PMETHOD_DESC', 'ID_PMETHOD');
        $opt_plocation = array_pluck($this->plocation->allActive(), 'PGROUP_DESC', 'ID_PGROUP');
        $currency = $this->currency->allActive();
        $opt_currency = array_pluck($currency, 'CURRENCY', 'ID');
        $opt_currency_abbr = array_pluck($currency, 'CURRENCY', 'ID');
        $opt_cost_center = array_pluck($this->cost_center->all(), 'COSTCENTER_DESC', 'ID_COSTCENTER');
        $opt_location = array_pluck($this->location->allActive(), 'LOCATION_DESC', 'ID_LOCATION');
        $opt_delivery_point = array_pluck($this->delivery_point->allActive(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_delivery_term = array_pluck($this->delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');
        $opt_importation = array_pluck($this->importation->allActive(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_requestfor = array_pluck($this->requestfor->allActive(), 'REQUESTFOR_DESC', 'ID_REQUESTFOR');
        $opt_inspection = array_pluck($this->inspection->allActive(), 'INSPECTION_DESC', 'ID_INSPECTION');
        $opt_freight = array_pluck($this->freight->allActive(), 'FREIGHT_DESC', 'ID_FREIGHT');
        $opt_itemtype = array_pluck($this->itemtype->allActive(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $opt_account_subsidiary = array_pluck($this->accsub->allActive(), 'ACCSUB_DESC', 'ID_ACCSUB');
        $opt_msr_inventory_type = array_pluck($this->msr->m_msr_inventory_type(), 'description', 'id');
        $opt_msr_attachment_type = $this->msr_attachment->getTypes();
        $mapMsrTypeItemType = $this->msrtype->getMapItemType();
        $data_user = $this->session->all_userdata();

        $user_costcenter = @user($this->session->userdata('ID_USER'))->COST_CENTER;

        $itemtype_category = $this->M_itemtype_category->byParentCategory();
        $opt_itemtype_category_by_parent = array_map(function($category) {
            return array_pluck($category, 'description', 'id');
        }, $itemtype_category);
        $opt_itemtype_category = array_pluck($this->M_itemtype_category->allActive(), 'description', 'id');

        $attachments = [];
        if (@$msr_no) {
            $this->msr_attachment->getByModuleKodeAndDataId($this->msr::module_kode, $msr_no);
        }

        $uoms = array();
        foreach($this->M_uom->allActive() as $uom) {
            $uoms[$uom->UOM_TYPE][$uom->ID] = $uom;
        }
        $query = $this->db->query("SELECT distinct d.DEPARTMENT_DESC from
                         m_user u
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where u.id_user='".$data_user["ID_USER"]."' ");

        $data_department = @$query->result();

//machrus
        $this->template->display('procurement/V_msr_create_v1',
//        $this->template->display('procurement/V_msr_create',
        compact(
            'menu', 'opt_company', 'opt_msr_type', 'opt_pmethod', 'opt_plocation', 'opt_currency',
            'opt_cost_center', 'opt_location', 'opt_delivery_point', 'opt_importation', 'opt_delivery_term',
            'opt_requestfor', 'opt_inspection', 'opt_freight', 'opt_itemtype', 'opt_account_subsidiary', 'opt_msr_inventory_type',
            'opt_msr_attachment_type', 'message', 'mapMsrTypeItemType', 'is_writable' ,'data_user','data_department',
            'opt_currency_abbr', 'pmethods', 'user_costcenter', 'opt_itemtype_category', 'opt_itemtype_category_by_parent',
            'uoms', 'attachments'
        ));
    }


    public function list()
    {
        $this->load->model('material/M_group');

        print_r($this->M_group->db->get('m_material_group')->result());
    }

    public function findItem()
    {
        $this->load->model('material/M_show_material', 'material');
        // $type = $this->input->get('type');
        $itemtype_category = trim($this->input->get('itemtype_category'));
        $query = $this->input->get('query');
        $company = $this->input->get('id_company');

        switch(strtoupper($itemtype_category)) {
            case 'SEMIC':
                $type = 'GOODS';
                break;
            case 'WORKS':
                $type = 'SERVICE';
                break;
            case 'CONSULTATION':
                $type = 'CONSULTATION';
                break;
            case 'MATGROUP':
                $type = 'BLANKET';
                break;
        }

        $output = @json_encode($this->material->findByTypeAndQuery($type, $query, $company));

        $this->output->set_content_type('application/json')
            ->set_output($output);
    }

    public function findItemAttributes()
    {
        $this->load->model('material/M_group', 'material_group');
        $result = array();
        $material_id = $this->input->get('material_id');
        $type = trim($this->input->get('type'));
        $itemtype_category = $this->input->get('itemtype_category');

        switch(strtoupper($itemtype_category)) {
            case 'SEMIC':
                $type = 'GOODS';
                break;
            case 'WORKS':
                $type = 'SERVICE';
                break;
            case 'CONSULTATION':
                $type = 'CONSULTATION';
                break;
            case 'MATGROUP':
                $type = 'BLANKET';
                break;
        }

        if ($material_id && $type) {
            if ($result = $this->material_group->findByMaterialAndType($material_id, $type)) {
                $result = $result[0];
            }
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($result));
    }

    /**
     * Calculate and find curret status of budget
     *
     * @return array
        [
            'costcenter' => ''
            'costcenter_description' => '',
            'account_subsidiary' => '',
            'account_subsidairy_description' => '',
            'msr_booking_amount' => '',
            'msr_budget_status' => '',
            'available_budget' => '',
            'status_budget' => '',
        ]
     */
    public function calculateBudget()
    {
      function hidden_input($name, $value) {
        return "<input type=\"hidden\" name=\"" . htmlspecialchars($name) ."\" value=\"" . htmlspecialchars($value) . "\">";
      }

        $this->load->model('procurement/M_msr_budget_status', 'msr_budget_status')
                   ->model('procurement/M_msr', 'msr')
                   ->model('other_master/M_budget')
                   ->helper(['array', 'exchange_rate']);

        $data = $this->input->post('items');
        $msr_no = $this->input->post('msr_no');
        $msr_no_val = $this->input->post('msr_no_val');
        $result = $_result = array();
        $user_roles = array_values(array_filter(explode(',', $this->session->userdata('ROLES'))));
        $base_currency_id = base_currency();
        $base_currency_code = base_currency_code();
        $msr_currency_id = '';
        $msr_currency_name = '';

        if (isset($data[0]['msr_no'])) {
            $msr = $this->msr->find($data[0]['msr_no']);
            $include_vat = $msr->master_list == 1 ? false : true;
        } else {
            // get from client. TODO: client-editable input should use this
            $include_vat = $this->input->post('master_list') ? false : true; // TODO: check on master_list value
        }
        // $last['costcenter'] = '';
        // $last['account_subsidiary'] = '';
        if (is_array($data) && count($data) > 0) {
            foreach($data as $d) {
                $_key = implode('-', [@$d['cost_center_value'], @$d['account_subsidiary_value']]);

                $_result[$_key]['cost_center_value'] = $d['cost_center_value'];
                $_result[$_key]['cost_center_name'] = $d['cost_center_name'];
                $_result[$_key]['account_subsidiary_value'] = @$d['account_subsidiary_value'];
                $_result[$_key]['account_subsidiary_name'] = @$d['account_subsidiary_name'];
                $_result[$_key]['currency_value'] = $d['currency_value'];
                $_result[$_key]['currency_name'] = $d['currency_name'];
                $_result[$_key]['currency_base_value'] = $base_currency_id;
                $_result[$_key]['currency_base_name'] = $base_currency_code;
                $_result[$_key]['msr_booking_amount'] = @$_result[$_key]['msr_booking_amount'] + $d['total_value']; // SUM of ($d['unit_price_value'] * $_d['qty_required_value'])
                $_result[$_key]['msr_booking_amount_base'] = 0; // SUM of ($d['unit_price_value'] * $_d['qty_required_value']) in base currency
                $_result[$_key]['msr_budget_status'] = '';
                $_result[$_key]['available_budget'] = '';
                $_result[$_key]['status_budget'] = '';
                $_result[$_key]['material_id'] = $d['material_id'];
                $_result[$_key]['msr_no'] = (isset($d['msr_no']) ? $d['msr_no'] : '');

                // $last['costcenter'] = $d['costcenter'];
                // $last['account_subsidiary'] = $d['account_subsidiary'];
            }

            $msr_budget_status = array_pluck($this->msr_budget_status->all(), 'description', 'id');
            $list_costcenter_available_budget = [];
            foreach($_result as $i => $r) {
                $item_namespace = "items_budget[$i]";
                $msr_currency_id = $r['currency_value'];
                $msr_currency_name = $r['currency_name'];

                // Get MSR Budget Status (Planned, Booked, Dummy Booked)
                // 1. per Cost Center and Acc Subsidiary
                $plan_budget = @$this->M_budget->getPlanBudget($r['cost_center_value'], $r['account_subsidiary_value']);
                $booking_budget = $this->M_budget->getBookingBudget($r['cost_center_value'], $r['account_subsidiary_value']);
                $booking_budget = calculate_amount_with_vat($booking_budget, $include_vat);
                $commit_budget = $this->M_budget->getCommitBudget($r['cost_center_value'], $r['account_subsidiary_value']);
                $commit_budget = calculate_amount_with_vat($commit_budget, $include_vat);
                $actual_budget = $this->M_budget->getActualBudget($r['cost_center_value'], $r['account_subsidiary_value']);


                $r['msr_budget_status'] = $msr_budget_status[$this->msr->getMsrBudgetStatus(@$msr_no)];

                $r['available_budget_account_subsidiary'] = $this->M_budget->calculateAvailableBudget(
                    $plan_budget,
                    $booking_budget,
                    $commit_budget,
                    $actual_budget
                );

                // 2. per Cost Center
                if (in_array($r['cost_center_value'], $list_costcenter_available_budget)) {
                    $available_budget_cost_center = $list_costcenter_available_budget[$r['cost_center_value']];
                } else {
                    // cc stands for cost center
                    $cc_plan_budget = @$this->M_budget->getPlanBudget($r['cost_center_value'], '');
                    $cc_booking_budget = $this->M_budget->getBookingBudget($r['cost_center_value'], '');
                    $cc_booking_budget = calculate_amount_with_vat($cc_booking_budget, $include_vat);
                    $cc_commit_budget = $this->M_budget->getCommitBudget($r['cost_center_value'], '');
                    $cc_commit_budget = calculate_amount_with_vat($cc_commit_budget, $include_vat);
                    $cc_actual_budget = $this->M_budget->getActualBudget($r['cost_center_value'], '');

                    $available_budget_cost_center = $this->M_budget->calculateAvailableBudget(
                        $cc_plan_budget,
                        $cc_booking_budget,
                        $cc_commit_budget,
                        $cc_actual_budget
                    );
                    $list_costcenter_available_budget[$r['cost_center_value']] = $available_budget_cost_center;
                }

                $r['available_budget_cost_center'] =  $available_budget_cost_center;

                // convert to base currency
                $r['msr_booking_amount_base'] = exchange_rate_by_id($r['currency_value'], $r['currency_base_value'], $r['msr_booking_amount']);

                $r['msr_booking_amount'] = calculate_amount_with_vat($r['msr_booking_amount'], $include_vat);
                $r['msr_booking_amount_base'] = calculate_amount_with_vat($r['msr_booking_amount_base'], $include_vat);

                // Check Status Budget
                $status_budget = $this->M_budget->statusBudget($r['available_budget'], $r['msr_booking_amount']);

                if (!empty($r['msr_no'])) {
                  $qq = $this->db->where('msr_no', $r['msr_no'])->where('msr_item_id', $r['material_id'])->get('t_msr_budget');
                  $sts_bdg = '';
                  foreach($qq->result_array() as $arr){
                    $t_msr_budget = $arr;
                    $sts_bdg = $arr['status_budget'];
                  }
                  $sts_bdg;

                  // Todo: use role/permission based framework
                  if (in_array(bsd_staff, $user_roles) || in_array(vp_bsd, $user_roles)) {
                      $_sts_bdg = '<select class="form-control status-budget required" '
                            .'name="'.$item_namespace.'[stat_budget]" '
                            .'id="items-budget-'.$i.'-stat_budget"'
                            .'data-msr_no="'.@$t_msr_budget['msr_no'].'" '
                            .'data-costcenter_id="'.@$t_msr_budget['costcenter_id'].'" '
                            .'data-accsub_id="'.@$t_msr_budget['accsub_id'].'" '
                            .'data-msr_item_id="'.@$t_msr_budget['msr_item_id'].'">';
                      foreach(array(
                          '' => 'Not determined yet',
                          'Sufficient' => 'Sufficient',
                          'Insufficient' => 'Insufficient'
                      ) as $k => $v) {
                          $_selected = $sts_bdg == $k ? 'selected' : '';
                          $_sts_bdg .= '<option value="'.$k.'" '.$_selected.'>'.$v.'</option>';
                      }
                     $_sts_bdg .= '</select>';

                     $sts_bdg = $_sts_bdg;
                  }
                } else {
                /*
                  $sts_bdg = '<select class="form-control" name="'.$item_namespace.'[stat_budget]">
                    <option value="">Not determined yet</option>
                    <option value="Sufficient">Sufficient</option>
                    <option value="Insufficient">Insufficient</option>
                  </select>';
                */
                    $sts_bdg = '';
                }

                $r['status_budget'] = $sts_bdg;
                // $r['status_budget'] = self::statusBudgetText($r['msr_no']);
                // if (!empty($r['msr_no'])) {
                //   $qq = $this->msr_item->showMsrBudget($r['msr_no']);
                //   foreach ($qq->result() as $value) {
                //     $r['status_budget'] = $value->status_budget;
                //   }
                // } else {
                //   $r['status_budget'] = '<select class="" name="stat_budget[]">
                //             <option value="Sufficient">Sufficient</option>
                //             <option value="Insufficient">Insufficient</option>
                //           </select>';
                // }

                $r['hidden_input'] = hidden_input($item_namespace.'[msr_val]', $i)
                                    .hidden_input($item_namespace.'[msr_itemid_val]', $r['material_id'])
                                    .hidden_input($item_namespace.'[costcenter_id]', $r['cost_center_value'])
                                    .hidden_input($item_namespace.'[accsub_id]', $r['account_subsidiary_value'])
                                    .hidden_input($item_namespace.'[msr_book_val]', $r['msr_booking_amount']);

                // format to display
                $r['msr_booking_amount'] = numEng($r['msr_booking_amount']);
                $r['msr_booking_amount_base'] = numEng($r['msr_booking_amount_base']);
                // $r['available_budget'] = numEng($r['available_budget']);
                $r['available_budget_cost_center'] = numEng($r['available_budget_cost_center']);
                $r['available_budget_account_subsidiary'] = numEng($r['available_budget_account_subsidiary']);

                $result[] = $r;
            }

            $exchange_rate = get_exchange_rate_by_currency_id($msr_currency_id, $base_currency_id);

            $status = 'success';
            $message = 'Ok';
        } else {
            $status = 'error';
            $message = 'No/invalid input data provided';
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode([
                'status' => $status,
                'message' => $message,
                'data' => $result,
                'msr_currency_id' => $msr_currency_id,
                'msr_currency_name' => $msr_currency_name,
                'base_currency_id' => $base_currency_id,
                'base_currency_name' => $base_currency_code,
                'exchange_rate_from' => @$exchange_rate->amount_from,
                'exchange_rate_to'  => @$exchange_rate->amount_to,
                ]
            ));
    }

    public function inquiry()
    {
        $msrs = $this->msr->alldept($this->session->userdata('DEPARTMENT'));
        $menu = get_main_menu();

        $msr_status = $this->msr->inquiry($this->session->userdata('DEPARTMENT'));

        $msr_status_search = [];
        foreach($msr_status as $msr) {
            if (!array_key_exists($msr->msr_no, $msr_status_search)) {
                $msr_status_search[$msr->msr_no] = $msr;
            }
        }

        $msr_assignment = $this->msr->getAssignment(array_keys($msr_status_search));
        $msr_assignment_search = [];
        foreach($msr_assignment as $assignment) {
            if (!array_key_exists($assignment->msr_no, $msr_assignment_search)) {
                $msr_assignment_search[$assignment->msr_no] = $assignment;
            }
        }
        unset($msr_assignment);

        foreach($msrs as &$msr) {
            $_msr = @$msr_status_search[$msr->msr_no];
            $_msr_assignment = @$msr_assignment_search[$msr->msr_no];

            $msr->status_code = @$_msr->status_code ?: 'UNKNOWN';
            $msr->action_to_role_description = @$_msr->action_to_role_description ?: '';
            $msr->procurement_specialist_name = @$_msr_assignment->name;

            switch ($msr->status_code) {
                case 'REJECT':
                    $msr->action_to_role_description = 'Rejected by ' . $msr->action_to_role_description;
                    break;
                case 'COMPLETE':
                    $msr->action_to_role_description = 'Completed';
                    break;
                case 'VERIFIED':
                    $msr->action_to_role_description = 'Verified';
                    break;
                case 'ASSIGNED':
                    $msr->action_to_role_description = 'Assigned';
                    break;
            }
        }


        $this->template->display('procurement/V_msr_inquiry', compact(
            'msrs', 'menu'
        ));
    }

    public function draftInquiry()
    {
        $menu = get_main_menu();

        $msrs = $this->M_msr_draft->getPrimarySecondaryByUserId($this->session->userdata('ID_USER'));

        $this->template->display('procurement/V_msr_draft_inquiry', compact(
            'msrs', 'menu'
        ));
    }

    public function edit($msr_no)
    {
        $this->load->model('setting/M_master_company', 'company')
            ->model('setting/M_msrtype', 'msrtype')
            ->model('other_master/M_currency', 'currency')
            ->model('setting/M_pmethod', 'pmethod')
            ->model('setting/M_pgroup', 'plocation')
            ->model('setting/M_master_costcenter', 'cost_center')
            ->model('setting/M_location', 'location')
            ->model('setting/M_delivery_point', 'delivery_point')
            ->model('setting/M_delivery_term', 'delivery_term')
            ->model('setting/M_importation', 'importation')
            ->model('setting/M_requestfor', 'requestfor')
            ->model('setting/M_master_inspection', 'inspection')
            ->model('setting/M_freight', 'freight')
            ->model('setting/M_itemtype', 'itemtype')
            ->model('setting/M_master_acc_sub', 'accsub')
            ->model('procurement/M_msr', 'msr')
            ->model('procurement/M_msr_item', 'msr_item')
            ->model('procurement/M_msr_attachment', 'msr_attachment')
            ->model('setting/M_itemtype_category')
            ->model('material/M_uom')
            ->helper(array('form', 'array', 'url', 'exchange_rate'))
            ->library(['form_validation', 'DocNumber', 'upload']);

        $message = array('type' => '', 'message' => '');
        $doctype = $this->msr::module_kode;
        $attachment_file = array();

        if ($this->input->post()) {
            return $this->create();
        }

        if (! ($msr = $this->msr->find($msr_no))) {
            show_error('Document not found');
        }

        $_POST['msr_no'] = $msr->msr_no;
        $_POST['company'] = $msr->id_company;
        $_POST['required_date'] = $msr->req_date;
        $_POST['msr_type'] = $msr->id_msr_type;
        $_POST['lead_time'] = $msr->lead_time;
        $_POST['title'] = $msr->title;
        $_POST['plocation'] = $msr->id_ploc;
        $_POST['pmethod'] = $msr->id_pmethod;
        $_POST['currency'] = $msr->id_currency;
        $_POST['scope_of_work'] = $msr->scope_of_work;
        $_POST['importation'] = $msr->id_importation;
        $_POST['requestfor'] = $msr->id_requestfor;
        $_POST['inspection'] = $msr->id_inspection;
        if ($msr->id_msr_type == 'MSR01') {
            $_POST['delivery_point'] = $msr->id_dpoint;
        } else if ($msr->id_msr_type == 'MSR02') {
            $_POST['location'] =  $msr->id_dpoint;
        }
        $_POST['delivery_term'] = $msr->id_deliveryterm;
        $_POST['freight'] = $msr->id_freight;
        $_POST['cost_center'] = $msr->id_costcenter;
        $_POST['total_amount'] = $msr->total_amount;
        $_POST['procure_processing_time'] = $msr->procure_processing_time;
        $_POST['blanket'] = $msr->blanket;

        $opt_itemtype = array_pluck($this->itemtype->all(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $opt_currency = array_pluck($this->currency->all(), 'DESCRIPTION', 'ID');
        $opt_msr_attachment_type = $this->msr_attachment->getTypes();

        $is_writable = true;
        $user_company = explode(',', $this->session->userdata('COMPANY'));

        $menu =  get_main_menu();

        $opt_company = array_pluck($this->company->findAllActive($user_company), "DESCRIPTION", "ID_COMPANY");

        $opt_msr_type = array_pluck($this->msrtype->allActive(), 'MSR_DESC', 'ID_MSR');
        $opt_msr_type = array_filter($opt_msr_type, function($id_msr) {
            return in_array($id_msr, array('MSR01', 'MSR02'));
        }, ARRAY_FILTER_USE_KEY);

        $pmethods = $this->pmethod->allActive();
        $opt_pmethod = array_pluck($pmethods, 'PMETHOD_DESC', 'ID_PMETHOD');
        $opt_plocation = array_pluck($this->plocation->allActive(), 'PGROUP_DESC', 'ID_PGROUP');
        $currency = $this->currency->allActive();
        $opt_currency = array_pluck($currency, 'CURRENCY', 'ID');
        $opt_currency_abbr = array_pluck($currency, 'CURRENCY', 'ID');
        $opt_cost_center = array_pluck($this->cost_center->all(), 'COSTCENTER_DESC', 'ID_COSTCENTER');
        $opt_location = array_pluck($this->location->allActive(), 'LOCATION_DESC', 'ID_LOCATION');
        $opt_delivery_point = array_pluck($this->delivery_point->allActive(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_delivery_term = array_pluck($this->delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');
        $opt_importation = array_pluck($this->importation->allActive(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_requestfor = array_pluck($this->requestfor->allActive(), 'REQUESTFOR_DESC', 'ID_REQUESTFOR');
        $opt_inspection = array_pluck($this->inspection->allActive(), 'INSPECTION_DESC', 'ID_INSPECTION');
        $opt_freight = array_pluck($this->freight->allActive(), 'FREIGHT_DESC', 'ID_FREIGHT');
        $opt_itemtype = array_pluck($this->itemtype->allActive(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $opt_account_subsidiary = array_pluck($this->accsub->allActive(), 'ACCSUB_DESC', 'ID_ACCSUB');
        $opt_msr_inventory_type = array_pluck($this->msr->m_msr_inventory_type(), 'description', 'id');
        $opt_msr_attachment_type = $this->msr_attachment->getTypes();
        $mapMsrTypeItemType = $this->msrtype->getMapItemType();
        $data_user = $this->session->all_userdata();
        $user_costcenter = @user($this->session->userdata('ID_USER'))->COST_CENTER;

        $itemtype_category = $this->M_itemtype_category->byParentCategory();
        $opt_itemtype_category_by_parent = array_map(function($category) {
            return array_pluck($category, 'description', 'id');
        }, $itemtype_category);
        $opt_itemtype_category = array_pluck($this->M_itemtype_category->allActive(), 'description', 'id');

        $uoms = array();
        $master_uom = $this->M_uom->allActive();
        foreach($master_uom as $uom) {
            $uoms[$uom->UOM_TYPE][$uom->ID] = $uom;
        }

        $all_uom = $this->M_uom->all();
        $searchable_uom = array();
        foreach($all_uom as $uom) {
            $searchable_uom[$uom->ID] = $uom;
        }

        // MSR Item
        $msr_item = $this->msr_item->getByMsrNo($msr->msr_no);
        $t = $this;
        $msr_item = array_map(function($item) use(
            $t,
            $msr,
            $opt_itemtype,
            $opt_itemtype_category,
            $opt_currency,
            $searchable_uom
        ){
//            $uom = $t->M_uom->findByMaterialUom($item->uom);

            $uom = @$searchable_uom[$item->uom_id];
            $copy_item = array();

            $copy_item['line_item'] = @$item->line_item;
            $copy_item['item_type_value'] = $item->id_itemtype;
            $copy_item['item_type_name'] = @$opt_itemtype[$item->id_itemtype];
            $copy_item['itemtype_category_value'] = $item->id_itemtype_category;
            $copy_item['itemtype_category_name'] = @$opt_itemtype_category[$item->id_itemtype_category];
            $copy_item['material_id'] = $item->material_id;
            $copy_item['semic_no_value'] = $item->semic_no;
            $copy_item['semic_no_name'] = $item->description;
            $copy_item['group_value'] = $item->groupcat;
            $copy_item['group_name'] = $item->groupcat_desc;
            $copy_item['subgroup_value'] = $item->sub_groupcat;
            $copy_item['subgroup_name'] = $item->sub_groupcat_desc;
            $copy_item['qty_required_value'] = $item->qty;
            $copy_item['qty_onhand_value'] = 0;
            $copy_item['qty_ordered_value'] = 0;
            $copy_item['uom_name'] = @$uom->MATERIAL_UOM;
            $copy_item['uom_description'] = @$uom->DESCRIPTION;
            $copy_item['uom_value'] = @$uom->ID;
            $copy_item['unit_price_value'] = $item->priceunit;
            $copy_item['total_value'] = $item->amount;
            $copy_item['currency_value'] = $msr->id_currency;
            $copy_item['currency_name'] = @$opt_currency[$msr->id_currency];
            $copy_item['importation_value'] = $item->id_importation;
            $copy_item['importation_name'] = $item->importation_desc;
            $copy_item['delivery_point_value'] = $item->id_dpoint;
            $copy_item['delivery_point_name'] = $item->dpoint_desc;
            $copy_item['cost_center_value'] = $item->id_costcenter;
            $copy_item['cost_center_name'] = $item->costcenter_desc;
            $copy_item['account_subsidiary_value'] = $item->id_accsub;
            $copy_item['account_subsidiary_name'] = $item->accsub_desc;
            $copy_item['is_asset'] = $item->is_asset;
            $copy_item['inv_type_value'] = $item->inv_type;
            $copy_item['inv_type_name'] = @$opt_msr_inventory_type[$item->inv_type];
            $copy_item['item_modification'] = $item->item_modification;

            return $copy_item;
        }, $msr_item);

        $_POST['items'] = $msr_item;

        $attachments = $this->msr_attachment->getByModuleKodeAndDataId($this->msr::module_kode, $msr_no);

        $query = $this->db->query("SELECT distinct d.DEPARTMENT_DESC from
                         m_user u
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where u.id_user='".$data_user["ID_USER"]."' ");

        $data_department = @$query->result();

        $this->template->display('procurement/V_msr_create_v1',
 //       $this->template->display('procurement/V_msr_create',
        compact(
            'menu', 'opt_company', 'opt_msr_type', 'opt_pmethod', 'opt_plocation', 'opt_currency',
            'opt_cost_center', 'opt_location', 'opt_delivery_point', 'opt_importation', 'opt_delivery_term',
            'opt_requestfor', 'opt_inspection', 'opt_freight', 'opt_itemtype', 'opt_account_subsidiary',
            'opt_msr_attachment_type', 'message', 'mapMsrTypeItemType', 'is_writable' ,'data_user','data_department',
            'opt_currency_abbr', 'pmethods', 'user_costcenter', 'opt_itemtype_category', 'opt_itemtype_category_by_parent',
            'opt_msr_inventory_type', 'uoms', 'attachments'
        ));
    }

    public function createFromDraft($id)
    {
        $this->load->model('setting/M_master_company', 'company')
            ->model('setting/M_msrtype', 'msrtype')
            ->model('other_master/M_currency', 'currency')
            ->model('setting/M_pmethod', 'pmethod')
            ->model('setting/M_pgroup', 'plocation')
            ->model('setting/M_master_costcenter', 'cost_center')
            ->model('setting/M_location', 'location')
            ->model('setting/M_delivery_point', 'delivery_point')
            ->model('setting/M_delivery_term', 'delivery_term')
            ->model('setting/M_importation', 'importation')
            ->model('setting/M_requestfor', 'requestfor')
            ->model('setting/M_master_inspection', 'inspection')
            ->model('setting/M_freight', 'freight')
            ->model('setting/M_itemtype', 'itemtype')
            ->model('setting/M_master_acc_sub', 'accsub')
            ->model('procurement/M_msr', 'msr')
            ->model('procurement/M_msr_item', 'msr_item')
            ->model('procurement/M_msr_attachment', 'msr_attachment')
            ->model('setting/M_itemtype_category')
            ->model('material/M_uom')
            ->helper(array('form', 'array', 'url', 'exchange_rate'))
            ->library(['form_validation', 'DocNumber', 'upload']);

        $message = array('type' => '', 'message' => '');
        $doctype = $this->M_msr_draft::module_kode;
        $attachment_file = array();

        if ($this->input->post()) {
            return $this->create();
        }

        if (! ($msr = $this->M_msr_draft->find($id))) {
            show_error('Document not found');
        }

        if ($msr->msr_no) {
            show_error('The document has been processed');
        }

        $_POST['draft_id'] = $id;
        $_POST['company'] = $msr->id_company;
        $_POST['required_date'] = $msr->req_date;
        $_POST['msr_type'] = $msr->id_msr_type;
        $_POST['lead_time'] = $msr->lead_time;
        $_POST['title'] = $msr->title;
        $_POST['plocation'] = $msr->id_ploc;
        $_POST['pmethod'] = $msr->id_pmethod;
        $_POST['currency'] = $msr->id_currency;
        $_POST['scope_of_work'] = $msr->scope_of_work;
        $_POST['importation'] = $msr->id_importation;
        $_POST['requestfor'] = $msr->id_requestfor;
        $_POST['inspection'] = $msr->id_inspection;
        if ($msr->id_msr_type == 'MSR01') {
            $_POST['delivery_point'] = $msr->id_dpoint;
        } else if ($msr->id_msr_type == 'MSR02') {
            $_POST['location'] =  $msr->id_dpoint;
        }
        $_POST['delivery_term'] = $msr->id_deliveryterm;
        $_POST['freight'] = $msr->id_freight;
        $_POST['cost_center'] = $msr->id_costcenter;
        $_POST['total_amount'] = $msr->total_amount;
        $_POST['procure_processing_time'] = $msr->procure_processing_time;
        $_POST['blanket'] = $msr->blanket;
        $_POST['master_list'] = $msr->master_list;
        

        $opt_itemtype = array_pluck($this->itemtype->all(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $opt_currency = array_pluck($this->currency->all(), 'DESCRIPTION', 'ID');
        $opt_msr_attachment_type = $this->msr_attachment->getTypes();

        $is_writable = true;
        $user_company = explode(',', $this->session->userdata('COMPANY'));

        $menu =  get_main_menu();

        $opt_company = array_pluck($this->company->findAllActive($user_company), "DESCRIPTION", "ID_COMPANY");

        $opt_msr_type = array_pluck($this->msrtype->allActive(), 'MSR_DESC', 'ID_MSR');
        $opt_msr_type = array_filter($opt_msr_type, function($id_msr) {
            return in_array($id_msr, array('MSR01', 'MSR02'));
        }, ARRAY_FILTER_USE_KEY);

        $pmethods = $this->pmethod->allActive();
        $opt_pmethod = array_pluck($pmethods, 'PMETHOD_DESC', 'ID_PMETHOD');
        $opt_plocation = array_pluck($this->plocation->allActive(), 'PGROUP_DESC', 'ID_PGROUP');
        $currency = $this->currency->allActive();
        $opt_currency = array_pluck($currency, 'CURRENCY', 'ID');
        $opt_currency_abbr = array_pluck($currency, 'CURRENCY', 'ID');
        $opt_cost_center = array_pluck($this->cost_center->all(), 'COSTCENTER_DESC', 'ID_COSTCENTER');
        $opt_location = array_pluck($this->location->allActive(), 'LOCATION_DESC', 'ID_LOCATION');
        $opt_delivery_point = array_pluck($this->delivery_point->allActive(), 'DPOINT_DESC', 'ID_DPOINT');
        $opt_delivery_term = array_pluck($this->delivery_term->allActive(), 'DELIVERYTERM_DESC', 'ID_DELIVERYTERM');
        $opt_importation = array_pluck($this->importation->allActive(), 'IMPORTATION_DESC', 'ID_IMPORTATION');
        $opt_requestfor = array_pluck($this->requestfor->allActive(), 'REQUESTFOR_DESC', 'ID_REQUESTFOR');
        $opt_inspection = array_pluck($this->inspection->allActive(), 'INSPECTION_DESC', 'ID_INSPECTION');
        $opt_freight = array_pluck($this->freight->allActive(), 'FREIGHT_DESC', 'ID_FREIGHT');
        $opt_itemtype = array_pluck($this->itemtype->allActive(), 'ITEMTYPE_DESC', 'ID_ITEMTYPE');
        $opt_account_subsidiary = array_pluck($this->accsub->allActive(), 'ACCSUB_DESC', 'ID_ACCSUB');
        $opt_msr_inventory_type = array_pluck($this->msr->m_msr_inventory_type(), 'description', 'id');
        $opt_msr_attachment_type = $this->msr_attachment->getTypes();
        $mapMsrTypeItemType = $this->msrtype->getMapItemType();
        $data_user = $this->session->all_userdata();
        $user_costcenter = @user($this->session->userdata('ID_USER'))->COST_CENTER;

        $itemtype_category = $this->M_itemtype_category->byParentCategory();
        $opt_itemtype_category_by_parent = array_map(function($category) {
            return array_pluck($category, 'description', 'id');
        }, $itemtype_category);
        $opt_itemtype_category = array_pluck($this->M_itemtype_category->allActive(), 'description', 'id');

        $uoms = array();
        $master_uom = $this->M_uom->allActive();
        foreach($master_uom as $uom) {
            $uoms[$uom->UOM_TYPE][$uom->ID] = $uom;
        }

        $searchable_uom = array();
        $all_uom = $this->M_uom->all();
        foreach($master_uom as $uom) {
            $searchable_uom[$uom->ID] = $uom;
        }

        // MSR Item
        $msr_item = $this->M_msr_item_draft->getByDraftId($msr->id);
        $t = $this;
        $msr_item = array_map(function($item) use(
            $t,
            $msr,
            $opt_itemtype,
            $opt_itemtype_category,
            $opt_currency,
            $opt_msr_inventory_type,
            $searchable_uom
        ){
//            $uom = $t->M_uom->findByMaterialUom($item->uom);

            $uom = @$searchable_uom[$item->uom_id];
            $copy_item = array();

            $copy_item['line_item'] = $item->line_item;
            $copy_item['item_type_value'] = $item->id_itemtype;
            $copy_item['item_type_name'] = @$opt_itemtype[$item->id_itemtype];
            $copy_item['itemtype_category_value'] = $item->id_itemtype_category;
            $copy_item['itemtype_category_name'] = @$opt_itemtype_category[$item->id_itemtype_category];
            $copy_item['material_id'] = $item->material_id;
            $copy_item['semic_no_value'] = $item->semic_no;
            $copy_item['semic_no_name'] = $item->description;
            $copy_item['group_value'] = $item->groupcat;
            $copy_item['group_name'] = $item->groupcat_desc;
            $copy_item['subgroup_value'] = $item->sub_groupcat;
            $copy_item['subgroup_name'] = $item->sub_groupcat_desc;
            $copy_item['qty_required_value'] = $item->qty;
            $copy_item['qty_onhand_value'] = $item->qty_onhand_value;
            $copy_item['qty_ordered_value'] = $item->qty_ordered_value;
            $copy_item['uom_name'] = @$uom->MATERIAL_UOM;
            $copy_item['uom_description'] = @$uom->DESCRIPTION;
            $copy_item['uom_value'] = @$uom->ID;
            $copy_item['unit_price_value'] = $item->priceunit;
            $copy_item['total_value'] = $item->amount;
            $copy_item['currency_value'] = $msr->id_currency;
            $copy_item['currency_name'] = @$opt_currency[$msr->id_currency];
            $copy_item['importation_value'] = $item->id_importation;
            $copy_item['importation_name'] = $item->importation_desc;
            $copy_item['delivery_point_value'] = $item->id_dpoint;
            $copy_item['delivery_point_name'] = $item->dpoint_desc;
            $copy_item['cost_center_value'] = $item->id_costcenter;
            $copy_item['cost_center_name'] = $item->costcenter_desc;
            $copy_item['account_subsidiary_value'] = $item->id_accsub;
            $copy_item['account_subsidiary_name'] = $item->accsub_desc;
            $copy_item['is_asset'] = $item->is_asset;
            $copy_item['inv_type_value'] = $item->inv_type;
            $copy_item['inv_type_name'] = @$opt_msr_inventory_type[$item->inv_type];
            $copy_item['item_modification'] = $item->item_modification;

            return $copy_item;
        }, $msr_item);

        $_POST['items'] = $msr_item;

        $attachments = $this->msr_attachment->getByModuleKodeAndDataId($this->M_msr_draft::module_kode, $id);

        $query = $this->db->query("SELECT distinct d.DEPARTMENT_DESC from
                         m_user u
                        join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
                        where u.id_user='".$data_user["ID_USER"]."' ");

        $data_department = @$query->result();
//machrus
        $this->template->display('procurement/V_msr_create_v1',
//        $this->template->display('procurement/V_msr_create',
        compact(
            'menu', 'opt_company', 'opt_msr_type', 'opt_pmethod', 'opt_plocation', 'opt_currency',
            'opt_cost_center', 'opt_location', 'opt_delivery_point', 'opt_importation', 'opt_delivery_term',
            'opt_requestfor', 'opt_inspection', 'opt_freight', 'opt_itemtype', 'opt_account_subsidiary', 'opt_msr_inventory_type',
            'opt_msr_attachment_type', 'message', 'mapMsrTypeItemType', 'is_writable' ,'data_user','data_department',
            'opt_currency_abbr', 'pmethods', 'user_costcenter', 'opt_itemtype_category', 'opt_itemtype_category_by_parent',
            'uoms', 'attachments'
        ));
    }

	//machrus
	public function saveDraftV1(){
        $post = $this->input->post();
        $draft_id = trim($post['draft_id']);
        $msr_no = @$post['msr_no'] ?: NULL;

        $input_data['header'] = $this->makeHeaderFromPost($msr_no);
        $details = array();

        $draft = $this->M_msr_draft->find($draft_id);

        if ($draft_id != '') {
            $input_data['header']['id'] = $draft_id;
        }

        $this->db->trans_start();

        if ($draft) {
            $this->M_msr_draft->update($draft_id, $input_data['header']);
        } else {
            $this->M_msr_draft->add($input_data['header']);
            $draft_id = $input_data['header']['id'] = $this->db->insert_id();
        }

        $this->M_msr_item_draft->deleteAllByDraftId($input_data['header']['id']);

        if (isset($post['items']) && count($post['items']) > 0) {
            $msr = $this;

            $input_data['items'] = array_map(
                function($item) use($msr, $input_data) {
                    $_item = $msr->makeItem($input_data, $item);
                    $_item->t_msr_draft_id = $input_data['header']['id'];

                    return $_item;
                },
                $post['items']
            );

            $details_result = $this->M_msr_item_draft->addBatch($input_data['items']);
        }

        // Update already uploaded attachment
        $current_attachments = $this->msr_attachment->getByModuleKodeAndDataId(
            $this->M_msr_draft::module_kode,
            $draft_id
        );
		
		$this->msr_attachment->deleteByModuleKodeAndDataId(
			$this->M_msr_draft::module_kode,
			$draft_id
		);
		
		if(isset($post['attachment'])){
			foreach ($post['attachment'] as $key => $row){
				$input_data['attachments'][] = array (
					"module_kode" => "msr_draft",
					"data_id" => $draft_id,
					"file_path" => "./upload/MSR/",
					"file_name" => $row['file'],
					"tipe" => $row['type'],
					"created_by" => $this->session->userdata('ID_USER'),
					"created_at" => date("Y-m-d H:i:s"),
				);
			}
			$this->saveAttachments($input_data['attachments']);
		}
		
		if ($this->db->trans_status() !== false) {
          // success

            $this->db->trans_commit();

            $message['status'] = 'OK';
            $message['text'] = 'Saved as draft';
        } else {
            $this->db->trans_rollback();

            $message['status'] = 'ERROR';
            $message['text'] = 'Error saving as draft';
        }

 			$doctype = $this->msr::module_kode;
			$msr_no = DocNumber::generate($doctype, $post['company']);

        $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'message' => [
                    'status' => $message['status'],
                    'text'   => $message['text']
                ],
                'draft_id' => $draft_id,
                'msr_no' => $msr_no,
                'data' => @$post['items'],
                'data2' => @$input_data['items'],
                // 'data3' => $this,

            ])
        );

    }
	
    public function saveDraft()
    {
        /*$post = $this->input->post();
        $attachment_file = $post['attachments'];
        print_r($attachment_file);
        exit();*/
        $post = $this->input->post();
        $draft_id = trim($post['draft_id']);
        $msr_no = @$post['msr_no'] ?: NULL;

        $input_data['header'] = $this->makeHeaderFromPost($msr_no);
        $details = array();

        $draft = $this->M_msr_draft->find($draft_id);

        if ($draft_id != '') {
            $input_data['header']['id'] = $draft_id;
        }

        $this->db->trans_start();

        if ($draft) {
            $this->M_msr_draft->update($draft_id, $input_data['header']);
        } else {
            $this->M_msr_draft->add($input_data['header']);
            $draft_id = $input_data['header']['id'] = $this->db->insert_id();
        }

        $this->M_msr_item_draft->deleteAllByDraftId($input_data['header']['id']);

        if (isset($post['items']) && count($post['items']) > 0) {
            $msr = $this;

            $input_data['items'] = array_map(
                function($item) use($msr, $input_data) {
                    $_item = $msr->makeItem($input_data, $item);
                    $_item->t_msr_draft_id = $input_data['header']['id'];

                    return $_item;
                },
                $post['items']
            );

            $details_result = $this->M_msr_item_draft->addBatch($input_data['items']);
        }

        // Update already uploaded attachment
        $current_attachments = $this->msr_attachment->getByModuleKodeAndDataId(
            $this->M_msr_draft::module_kode,
            $draft_id
        );

        $attachment_file_ids = array_pluck(@$post['attachments'] ?: [], 'attachment_file_id');

        foreach($current_attachments as $i => $cur_att) {
            // Delete attachment that already exists but deleted by user
            if (!in_array($cur_att->id, $attachment_file_ids))  {
                // NOTE: only delete data, NOT file
                $this->msr_attachment->delete($cur_att->id);
            } else {
                $_attachment = $post['attachments'][$i];
                $this->msr_attachment->update($cur_att->id, [
                    'tipe' => $_attachment['attachment_type']
                ]);
            }
        }

        // any file uploaded
        if (isset($_FILES)) {
            $this->handleUpload();

            if ($upload_error_message  = $this->upload->display_errors()) {
                $message['text'] = $upload_error_message;
                $message['status'] = 'ERROR';
            }

            /*
            $this->msr_attachment->deleteByModuleKodeAndDataId(
                $this->M_msr_draft::module_kode,
                $draft_id
            );
            */

            $attachment_file = $this->upload->get_multi_upload_data();

            if ($draft_id && ($attachment_file || @$post['attachments'])) {

                $pre_attached = [];
                $upload_config = $this->msr_attachment->getUploadConfig();
                foreach($post['attachments'] as $attachment) {
                    if (isset($attachment['attachment_file_id'])
                        && !empty($attachment['attachment_file_id'])) {

                        $file = $this->msr_attachment->find($attachment['attachment_file_id']);
                        if (!$file) {
                            continue;
                        }

                        // left it as it
                        if ($file->module_kode == $this->M_msr_draft::module_kode) {
                            continue;
                        }

                        // only handle attachment 'imported' from other module

                        $pre_attached[] = $this->makeAttachment(
                            $msr_no,
                            $this->M_msr_draft::module_kode,
                            $attachment,
                            (array) $file,
                            $upload_config
                        );
                    }
                    else {

                    }
                }

                $input_data['attachments'] = [];
                if (count($attachment_file) > 0) {
                    $input_data['attachments'] = $this->makeAttachmentsFromPost(
                                                    $draft_id,
                                                    $this->M_msr_draft::module_kode,
                                                    $attachment_file
                                                );
                }

                if (count($input_data['attachments']) > 0) {
                    $this->saveAttachments($input_data['attachments']);
                }
            }
        }

        if ($this->db->trans_status() !== false) {
          // success

            $this->db->trans_commit();

            $message['status'] = 'OK';
            $message['text'] = 'Saved as draft';
        } else {
            $this->db->trans_rollback();

            $message['status'] = 'ERROR';
            $message['text'] = 'Error saving as draft';
        }



        $this->output->set_content_type('application/json')
            ->set_output(json_encode([
                'message' => [
                    'status' => $message['status'],
                    'text'   => $message['text']
                ],
                'draft_id' => $draft_id,
                'data' => @$post['items'],
                'data2' => @$input_data['items'],
                // 'data3' => $this,

            ])
        );

    }

	//update attechment msr draf to msr machrus
    public function updateAtt(){
		$post = $this->input->post();
		return $this->msr_attachment->updateAtt($post);
	}
	
	
    public function getCostCenters()
    {
        $this->load->model('setting/M_master_costcenter');

        $data = array();

        $company = $this->input->get('company');

        if ($company) {
            $cost_centers = $this->M_master_costcenter->find_by_company($company);
            $data = array_map(function($costcenter) {
                return array(
                    'id_company' => $costcenter->ID_COMPANY,
                    'id_costcenter' => $costcenter->ID_COSTCENTER,
                    'costcenter_desc' => $costcenter->COSTCENTER_DESC,
                    'costcenter_abr' => $costcenter->COSTCENTER_ABR,
                    'id' => $costcenter->ID_COSTCENTER,
                    'text' => $costcenter->ID_COSTCENTER .' - '.$costcenter->COSTCENTER_DESC,
                );
            }, $cost_centers);
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($data));
    }

    public function getAccountSubsidiaries()
    {
        $this->load->model('setting/M_master_acc_sub');

        $company_id = $this->input->get('company_id');
        $costcenter_id = $this->input->get('costcenter_id');

        $data = array();

        if ($company_id && $costcenter_id) {
            $account_subsidiaries = $this->M_master_acc_sub->find_by_company_and_costcenter(
                $company_id,
                $costcenter_id,
                ['L', 'S', '']
                );
            $data = array_map(function($accsub) {
                return array(
                    'id_company' => $accsub->COMPANY,
                    'id_costcenter' => $accsub->COSTCENTER,
                    'id_account_subsidiary' => $accsub->ID_ACCSUB,
                    'account_subsidiary_desc' => $accsub->ACCSUB_DESC,
                );
            }, $account_subsidiaries);
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($data));

    }

    public function getAasApprover()
    {
        $this->load->model('approval/M_approval')
            ->model('setting/M_currency')
            ->model('user/M_view_user')
            ->helper('exchange_rate');

        $base_currency_id = base_currency();
        $base_currency = base_currency_code();
        $company_id = $this->input->get('company_id');
        $currency_id = $this->input->get('currency_id');
        $amount = $this->input->get('amount');
        $user_id = $this->session->userdata('ID_USER');

        // convert amount to USD based on MSR currency
        $from = @$this->M_currency->find($currency_id);
        $amount_base = exchange_rate(@$from->CURRENCY, $base_currency, $amount);

        // first AAS
        $first_aas = $this->M_approval->firstAas($amount_base, $user_id, $company_id);
        if (!$first_aas) {
            $first_aas = new stdClass;
        }

        $user_first_aas = @$this->M_view_user->show_user(@$first_aas->user_id);

        $first_aas->NAME = @$user_first_aas->NAME;

        // second AAS
        $second_aas_list = [];
        if (@$first_aas->user_id != 1 || @$first_aas->parent_id == 0) {
            $second_aas_list = $this->M_approval->getSecondAas($user_id, $amount_base, $company_id);
            $second_aas_list = array_values(
                array_filter($second_aas_list, function($val) use($first_aas) {
                   return $val->id != @$first_aas->id;
                })
            );
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode([
                'first_aas' => $first_aas,
                'second_aas' =>  $second_aas_list,
                'base_currency' => $base_currency,
                'base_currency_id' => $base_currency_id,
                'msr_currency_id' => $currency_id,
                'msr_currency_name' => @$from->CURRENCY,
                'amount' => $amount_base,
                'msr_amount' => $amount,
            ]));
    }

    public function checkExchangeRate()
    {
        $this->load->model('setting/M_currency', 'currency')
            ->helper(['exchange_rate']);

        $currency = $this->input->get('currency');
        $_POST['currency'] = $currency;

        $base_currency = base_currency_code();
        $from_currency = @$this->M_currency->find($currency)->CURRENCY;

        $result = $this->check_exchange_rate_setup();

        if ($result) {
            // TODO: fix double db hit (already hit by check_exchange_rate_setup())
            $message = find_exchange_rate_base($from_currency, $base_currency);
        } else {
            $message = "Exchange rate from {$from_currency} to {$base_currency} is not setup yet";
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode([
                'exchange_rate_status' => (boolean) $result,
                'message' => $message,
                'from_currency_code' => $from_currency,
                'base_currency_code' => $base_currency,
            ]));

    }

    public function logHistory($msr_no)
    {
        $log = $this->approval_lib->getLog([
            'data_id' => $msr_no,
            'module_kode'=> $this->msr::module_kode,
            'description != ' => 'Submitted BLED'
        ])->result();


        // $log_spa = @$this->approval_lib->getLog([
        //     'data_id' => $msr_no,
        //     'module_kode'=>'msr_spa'
        // ])->result();

        // krsort($log_spa);

        // $new_log_spa = [];
        // foreach($log_spa as $row) {
        //     // first found 'Submitted BLED'
        //     if (trim($row->description) == 'Submitted BLED')  {
        //         break;
        //     }

        //     $new_log_spa[] = $row;
        // }
        // unset($log_spa);

        // if ($new_log_spa) {
        //     $log = array_merge($log, $new_log_spa);
        // }

        $approve_string = 'Approved';
        $reject_string = 'Reject';

        // usort($log, function($a, $b) {
        //     $time_a = strtotime($a->created_at);
        //     $time_b = strtotime($b->created_at);

        //     if ($time_a == $time_b) {
        //         return $a->id < $b->id ? 1 : -1;
        //     }

        //     return $time_a < $time_b ? 1 : -1;
        // });

        foreach($log as &$l) {
            $creator = user($l->created_by);
            $comment  = $l->keterangan;

            if (substr($l->description, 0, strlen($approve_string)) == $approve_string) {
                $activity_string = $approve_string;
            }
            else if (substr($l->description, 0, strlen($reject_string)) == $reject_string) {
                $activity_string = $reject_string;
            } else {
                $activity_string = $l->description;
            }

            if (empty($comment)) {
                $actv_str_len = strlen($activity_string);
                $desc_len = strlen($l->description);

                if ($desc_len >= $actv_str_len) {
                    $comment = substr(
                        $l->description,
                        $actv_str_len,
                        $desc_len
                    );
                }
            }

            $l->created_by_name = @$creator->NAME;
            $l->activity_string = $activity_string;
            $l->activity = $activity_string . ' by ' . $l->created_by_name;
            $l->comment = $comment;
        }

        $message['text'] = 'Success';
        $message['status'] = 'OK';

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode([
                'data' => $log,
                'message' => $message,
            ]));
    }

    protected function statusBudgetText($msrno)
    {
        // TODO: use more precise comparation
        // return $budget < 0 ? 'Insufficient' : 'Sufficient';

        if (!empty($msrno)) {
          $qq = $this->db->where('msr_no', $msrno)->get('t_msr_budget');
          $var = '';
          foreach($qq->result_array() as $arr){
            $var = $arr['status_budget'];
          }
          return $var;
        } else {
          return '<select class="" name="stat_budget[]">
                    <option value=""></option>
                    <option value="Sufficient">Sufficient</option>
                    <option value="Insufficient">Insufficient</option>
                  </select>';
        }
    }


    /*
     * TODO: move/use M_exchange_rate to check
     */
    protected function check_exchange_rate_setup()
    {
        $currency = $this->input->post('currency');

        // in case we load M_currency as currency
        if ($this->currency != null)  {
            $from = @$this->currency->find($currency)->CURRENCY;
        }
        // in case we load M_currency as M_currency
        else if ($this->M_currency != null) {
            $from = @$this->M_currency->find($currency)->CURRENCY;
        }
        else {
            $from = '';
        }

        $to = base_currency_code();

        if ($to != '' && $from == $to) {
            return true;
        }

        return find_exchange_rate_base($from, $to) != 0;

    }

    protected function validateCreate($input)
    {
        $this->form_validation->set_message('required', 'This field is required.');

        $config = array(
            array('field' => 'company', 'rules' => 'trim|required'),
            array('field' => 'required_date', 'rules' => 'trim|required',),
            array('field' => 'msr_type', 'rules' => 'trim|required'),
            array('field' => 'lead_time', 'rules' => 'trim|required|greater_than[0]'),
            array('field' => 'title', 'rules' => 'trim|required'),
            array('field' => 'plocation', 'rules' => 'trim|required'),
            array('field' => 'pmethod', 'rules' => 'trim|required'),
            array('field' => 'currency', 'rules' => 'trim|required'),
        );

        switch(@$input['msr_type']) {
            case 'MSR01': // material/goods
                // put conditions here
                break;
            case 'MSR02': // service
                $config[] = array('field' => 'scope_of_work', 'rules' => 'required');
                break;
            default:
        }

        $config[] = array('field' => 'items[]', 'rules' => 'required|callback_validate_items');

        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    protected function validate_items($items)
    {
        if (empty($input['items'])) {
            $this->form_validation->set_message('items', 'Please select at least an Item');
            return false;
        }

        // try decode json
        // if (TRUE !== json_decode($items)) {
        //     $this->form_validation->set_message('validate_items', 'Unable read Items data');
        //     return false;
        // }


        // TODO: Check and validate each item record

        return true;
    }

    protected function makeItem($input_data, $item)
    {
        $amount = @$item['qty_required_value'] * @$item['unit_price_value'];
        $priceunit_base = @exchange_rate_by_id($input_data['header']['id_currency'], $input_data['header']['id_currency_base'], $item['unit_price_value']);
        $amount_base = @exchange_rate_by_id($input_data['header']['id_currency'], $input_data['header']['id_currency_base'], $amount);

        return (object) array(
            'msr_no' => @$input_data['header']['msr_no'] ?: NULL,
            'id_itemtype' => @$item['item_type_value'] ?: NULL,
            'id_itemtype_category' => @$item['itemtype_category_value'],
            'material_id' => @$item['material_id'] ?: NULL,
            'semic_no' => @$item['semic_no_value'],
            'description' => trim(@$item['semic_no_name']),
            'groupcat' => @$item['group_value'] ?: NULL,
            'groupcat_desc' => @$item['group_name'],
            'sub_groupcat' => @$item['subgroup_value'] ?: NULL,
            'sub_groupcat_desc' => @$item['subgroup_name'],
            'qty' => @$item['qty_required_value'] ?: 0,
            'qty_onhand_value' => @$item['qty_onhand_value'] ?: 0,
            'qty_ordered_value' => @$item['qty_ordered_value'] ?: 0,
            'uom_id' => @$item['uom_value'] ?: NULL,
            'uom' => @$item['uom_name'],
            'priceunit' => @$item['unit_price_value'] ?: 0,
            'amount' => $amount ?: 0,
            'id_importation' => @$item['importation_value'] ?: NULL,
            'importation_desc' => @$item['importation_name'],
            'id_dpoint' => @$item['delivery_point_value'] ?: NULL,
            'dpoint_desc' => @$item['delivery_point_name'],
            'id_bplant' => @$input_data['header']['id_company'],
            'id_costcenter' => @$item['cost_center_value'] ?: NULL,
            'costcenter_desc' => @$item['cost_center_name'],
            'id_accsub' => @$item['account_subsidiary_value'] ?: NULL,
            'accsub_desc'  => @$item['account_subsidiary_name'],
            'is_asset' => @$item['is_asset'] ?: 0,
            'inv_type' => @$item['inv_type_value'] ?: 0,
            'item_modification' => @$item['item_modification_value'] ?: 0,
            'priceunit_base' => @$priceunit_base ?: 0,
            'amount_base' => @$amount_base ?: 0,
        );
    }

    protected function makeHeaderFromPost($msr_no)
    {
        $this->load->model('setting/M_msrtype', 'msrtype');

        $post = $this->input->post();
        $itemtype = $this->msrtype->itemType($post['msr_type']);
        $items = $this->input->post('items');

        if (is_array($items) && count($items) > 0) {
            $total_amount = array_sum(array_map(function($item) {
                return @$item['qty_required_value'] * $item['unit_price_value'];
            }, $items));
        } else {
            $total_amount = 0;
        }

        $id_currency_base = base_currency();
        $total_amount_base = exchange_rate_by_id($post['currency'], $id_currency_base, $total_amount);

        /* Prevent error if variables aren't available at $_POST
           because empty string cannot be inserted to integer field
        */
        $post['location'] = @$post['location'] ?: NULL;
        $post['delivery_point'] = @$post['delivery_point'] ?: NULL;
        $post['importation'] = @$post['importation'] ?: NULL;
        $post['inspection'] = @$post['inspection'] ?: NULL;
        $post['delivery_term'] = @$post['delivery_term'] ?: NULL;
        $post['master_list'] = !isset($post['master_list']) ? 0 : ($post['master_list'] ? 1 : 0);

        $id_department = $this->session->userdata('DEPARTMENT');
        $department_desc = @$this->M_master_department->find($id_department)->DEPARTMENT_DESC;

        return array(
            'msr_no' => $msr_no, // e.g Doc::generateNumber($doc_type)
            'id_company' => @$post['company'],
            'company_desc' => @$this->company->find(@$post['company'])->DESCRIPTION,
            'req_date' => @$post['required_date'] ?: NULL,
            'id_msr_type' => @$post['msr_type'],
            'msr_type_desc' => @$this->msrtype->find(@$post['msr_type'])[0]->MSR_DESC,
            'lead_time' => @$post['lead_time'] ?: 0,
            'title' => @$post['title'],
            'id_ploc' => @$post['plocation'],
            'rloc_desc' => @$this->plocation->find(@$post['plocation'])[0]->PGROUP_DESC,
            'id_pmethod' => @$post['pmethod'],
            'pmethod_desc' => @$this->pmethod->find(@$post['pmethod'])[0]->PMETHOD_DESC,
            'id_currency' => @$post['currency'],
            'id_currency_base' => $id_currency_base,
            'scope_of_work' => $itemtype == 'GOODS' ? '' : @$post['scope_of_work'],
            'id_dpoint' => $itemtype == 'SERVICE' ? @$post['location'] : @$post['delivery_point'],
            'dpoint_desc' => $itemtype == 'SERVICE' ?
                @$this->location->find(@$post['location'])->LOCATION_DESC :
                @$this->delivery_point->find(@$post['delivery_point'])->DPOINT_DESC,
            'id_importation' => @$post['importation'],
            'importation_desc' => @$this->importation->find(@$post['importation'])->IMPORTATION_DESC,
            'id_requestfor' => @$post['requestfor'],
            'requestfor_desc' => @$this->requestfor->find(@$post['requestfor'])->REQUESTFOR_DESC,
            'id_inspection' => @$post['inspection'],
            'inspection_desc' => @$this->inspection->find(@$post['inspection'])->INSPECTION_DESC,
            'id_deliveryterm' => @$post['delivery_term'],
            'deliveryterm_desc' => @$this->delivery_term->find(@$post['delivery_term'])->DELIVERYTERM_DESC,
            'id_freight' =>  @$post['freight'],
            'freight_desc' => @$this->freight->find(@$post['freight'])->FREIGHT_DESC,
            //'id_costcenter' => @$post['cost_center'],
            'id_costcenter' => @$post['cost_center_slc2'],
            'costcenter_desc' => @$this->cost_center->find(@$post['cost_center'])->COSTCENTER_DESC,
            'total_amount' => $total_amount,
            'total_amount_base' => $total_amount_base,
            'procure_processing_time' => @$post['procure_processing_time'] ?: 0,
            'blanket' => isset($post['blanket']) && @$post['blanket'] == 1 ? 1 : 0,
            'id_department' => $id_department,
            'department_desc' => $department_desc,
            'master_list' => $post['master_list'],
            );
    }

    protected function handleUpload()
    {
        if (!isset($_FILES)) {
            return true;
        }

        $this->upload->initialize($this->msr_attachment->getUploadConfig());

        $this->normalizeAttachmentFile('attachments', 'attachment_file');

        return $this->upload->do_multi_upload('attachments');
    }

    protected function saveAttachments($attachments)
    {
        $CI = $this;
        return array_map(function($attachment) use ($CI) {
            $CI->msr_attachment->add($attachment);
            $attachment['upload_id'] = @$CI->db->insert_id();

            return $attachment;
        }, $attachments);
    }

    protected function normalizeAttachmentFile($name, $subname)
    {
        if (isset($_FILES[$name]['name'])) {
            if (is_array(current($_FILES[$name]['name']))) {
                $index = array_keys($_FILES[$name]['name']);
                $files = array();

                foreach($index as $i)  {
                    $files['name'][$i] = $_FILES[$name]['name'][$i][$subname];
                    $files['type'][$i] = $_FILES[$name]['type'][$i][$subname];
                    $files['tmp_name'][$i] = $_FILES[$name]['tmp_name'][$i][$subname];
                    $files['error'][$i] = $_FILES[$name]['error'][$i][$subname];
                    $files['size'][$i] = $_FILES[$name]['size'][$i][$subname];
                }

                $_FILES[$name] = $files;
            }
        }

        return $_FILES;
    }

    protected function makeAttachmentsFromPost($data_id, $module_kode, $files)
    {
        $attachments = $this->input->post('attachments');
        $out = array();
        $upload_config = $this->msr_attachment->getUploadConfig();

        // this helper in unstable, may break due to UI change
        $index_offset = count(array_filter($attachments, function($data) {
            return isset($data['attachment_file_id']) && $data['attachment_file_id'];
        }));

        // compile attachment input with it's file
        $index = array_keys($attachments);
        foreach($attachments as $i => $attachment) {
            if ($attachments[$i]['attachment_type'] && !@$attachment['attachment_file_id']) {
                $out[] = $this->makeAttachment(
                    $data_id,
                    $module_kode,
                    $attachments[$i],
                    $files[$i - $index_offset],
                    $upload_config
                );
            }
        }

        return $out;
    }

    protected function makeAttachment($data_id, $module_kode, $attachment, $file, $upload_config)
    {
        /*
        if (!isset($upload_config)) {
            static $upload_config;
            $upload_config = $this->msr_attachment->getUploadConfig();
        }
        */

        return array(
            'module_kode'   => $module_kode,
            'data_id'       => $data_id,
            'file_path'     => $upload_config['upload_path'],
            'file_name'     => $file['file_name'],
            'tipe'          => $attachment['attachment_type'],
            'created_by'    => $this->session->userdata('ID_USER'),
            'created_at'    => today_sql()
        );
    }

    public function a() {
        $this->load->model('setting/M_msrtype', 'msrtype')
            ->model('setting/M_itemtype', 'itemtype');

        array_map(function($msrtype) {
            $itemtype = $this->msrtype->itemType($msrtype->ID_MSR);
            printf("%s --> %s\n", $msrtype->ID_MSR, $itemtype);
            if ($itemtype !== NULL) {
                $m_itemtype = (object) $this->itemtype->show($itemtype)[0];
                $itemtype_desc = property_exists($m_itemtype, 'ITEMTYPE_DESC') ? $m_itemtype->ITEMTYPE_DESC : '-';

                printf("MSR %s has Item Type %s\n", $msrtype->ID_MSR, $itemtype_desc);
            }
        }, $this->msrtype->all());
    }

    public function requestJDEQtyonHand()
    {
        $wh = $_GET['wh'];
        $semic_no = $_GET['semic_no'];

        $this->load->model('material/M_show_material', 'material');

        $id_item = $this->material->showItem($semic_no);


        //$ch = curl_init('https://10.1.1.94:91/PD910/InventoryManager');
        $ch = curl_init('https://10.1.1.94:91/PD910/V41021A_SelectMgr');
        /**$xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP410000/">
<soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <orac:getCalculatedAvailability>
         <branchPlantList>'.$wh.'</branchPlantList>
         <itemPrimary>'.$semic_no.'</itemPrimary>
      </orac:getCalculatedAvailability>
   </soapenv:Body>
</soapenv:Envelope>';**/
        $xml_post_string = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:orac="http://oracle.e1.bssv.JP574102/">
  <soapenv:Header>
   <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
     xmlns:env="http://schemas.xmlsoap.org/soap/envelope/"
     soapenv:mustUnderstand="1">
     <wsse:UsernameToken xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd"
       xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
       <wsse:Username>SCM</wsse:Username>
       <wsse:Password Type="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-username-token-profile-1.0#PasswordText">password</wsse:Password>
     </wsse:UsernameToken>
   </wsse:Security>
 </soapenv:Header>

   <soapenv:Body>
      <orac:V41021A_SelectMgr>
         <!--Optional:-->

         <!--Optional:-->
         <costCenter>'.$wh.'</costCenter>
         <!--Optional:-->
         <identifierShortItem>
            <!--Optional:-->
            <!--<currencyCode>?</currencyCode>
-->
            <!--<currencyDecimals>?</currencyDecimals>-->
            <!--Optional:-->
            <value>'.$id_item.'</value>
         </identifierShortItem>
         <!--Optional:-->
         <!--<location>?</location>
-->
      </orac:V41021A_SelectMgr>
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
        curl_setopt($ch, CURLOPT_SSLVERSION, 'all');

        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string);

        $data_curl = curl_exec($ch);
        curl_close($ch);

        if (strpos($data_curl, 'HTTP/1.1 200 OK') !== false) {
          //return true;
            $itemNumber = "0";
            $itemOrder = "0";
            /**if (strpos($data_curl,'<totalQtyAvailable>') !== false) {
                $itemNumber = substr($data_curl,strpos($data_curl,'<totalQtyAvailable>')+19,((strpos($data_curl,'</totalQtyAvailable>'))-(strpos($data_curl,'<totalQtyAvailable>')+19)));
            }**/

            if (strpos($data_curl,'<qtyOnHandPrimaryUn>') !== false) {
                $data_onhand = substr($data_curl,strpos($data_curl,'<qtyOnHandPrimaryUn>')+20,((strpos($data_curl,'</qtyOnHandPrimaryUn>'))-(strpos($data_curl,'<qtyOnHandPrimaryUn>')+20)));
                if (strpos($data_onhand,'<value>') !== false) {
                    $itemNumber = substr($data_onhand,strpos($data_onhand,'<value>')+7,((strpos($data_onhand,'</value>'))-(strpos($data_onhand,'<value>')+7)));
                }
            }

            if (strpos($data_curl,'<qtyOnPurchaseOrderPr>') !== false) {
                $data_onorder = substr($data_curl,strpos($data_curl,'<qtyOnPurchaseOrderPr>')+22,((strpos($data_curl,'</qtyOnPurchaseOrderPr>'))-(strpos($data_curl,'<qtyOnPurchaseOrderPr>')+22)));
                if (strpos($data_onorder,'<value>') !== false) {
                    $itemOrder = substr($data_onorder,strpos($data_onorder,'<value>')+7,((strpos($data_onorder,'</value>'))-(strpos($data_onorder,'<value>')+7)));
                }
            }

            $result = array("qty_onhand"=>$itemNumber,"qty_onorder"=>$itemOrder);
        }else{
            $result = array("qty_onhand"=>"0","qty_onorder"=>"0");
          //return false;
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($result));
    }

    public function updateBudget()
    {
        $post = $this->input->post();

        // TODO: check permission

        if ($post['msr_no'] && $post['msr_item_id']) {
            // TODO: move to relevant model
            $result = $this->db->set('status_budget', @$post['status_budget'] ?: '')
                ->where('msr_no', $post['msr_no'])
                ->where('msr_item_id', $post['msr_item_id'])
                ->update('t_msr_budget');

            $message = $result ? 'Ok' : 'Error';
        } else {
            $message = 'Invalid';
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode(compact('message')));

    }

    public function insufficientList()
    {
        if (!can_edit_msr_budget_status()) {
            show_error('Invalid authorization');
        }

        $menu = get_main_menu();

        $msrs = $this->msr->getInsufficients();
        $page_title['IND'] = "Insufficient MSR";
        $page_title['ENG'] = "Insufficient MSR";

        $this->template->display('procurement/V_msr_inquiry', compact(
            'msrs', 'menu', 'page_title'
        ));
    }

    public function checkBudgetHolder()
    {
        $response = [];
        $items = $this->input->post_get('items');
        $that = $this;

        $user = user($this->session->userdata('ID_USER'));

        if ($items) {
            $items_wo_budget_holder = array_filter($items, function($item) use($that, $user) {
                if ($item['cost_center_value'] != $user->COST_CENTER) {
                    $budget_holder = $that->M_budget_holder->findByCostCenter($item['cost_center_value']);
                    return !$budget_holder || !$budget_holder->id_user;
                }
            });

            $no_budget_holder = count($items_wo_budget_holder) > 0;

            if ($no_budget_holder) {
                $response['type'] = 'error';
                $costcenters = array_pluck($items_wo_budget_holder, 'id_costcenter');
                $response['message'] = 'Budget holder are not set yet';
            }
            else {
                $response['type'] = 'success';
                $response['message'] = 'Budget holder Ok';
            }

            $response['status'] = !$no_budget_holder;
            $response['data'] = $items_wo_budget_holder;
        }
        else {
            $response['type'] = 'error';
            $response['message'] = 'Invalid given items';
            $response['status'] = false;
        }

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));
    }


    public function wh_code(){
      $idnya = $_GET['company'];
      $respon = array();
      $data = $this->msr->getWHCode($idnya);
      echo json_encode($data, JSON_PRETTY_PRINT);
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
	
	//machrus
	public function attachment_upload() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('file_name', 'File Name', 'required');
        $this->form_validation->set_rules('type', 'Type', 'required');
		
        if (!$this->form_validation->run()) {
            $response = array(
                'success' => false,
                'message' => validation_errors('<div>', '</div>')
            );
            echo json_encode($response);
            exit;
        }
        $config['upload_path'] = './upload/MSR/';
        $config['upload_path'] = './upload/MSR/';
		if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'],0755,TRUE);
        }
		$config['allowed_types'] = 'jpg|jpeg|pdf|doc|docx';
        //$config['allowed_types'] = 'jpg|jpeg|pdf';
        $config['max_size'] = '2048';
        //$config['encrypt_name'] = true;
        $config['file_name'] = $this->input->post('file_name');
		$this->load->library('upload', $config);
		$this->upload->initialize($config); 
        $response = array();
        if ($this->upload->do_upload('file')) {
            $response = array(
                'success' => true,
                'message' => 'Successfully uploded document',
                'data' => $this->upload->data()
            );
        } else {
            $response = array(
                'success' => false,
                'message' => $this->upload->display_errors()
            );
        }
        echo json_encode($response);
    }
	
	public function action_cancel_msr($msr_no='')
    {
      $this->db->trans_begin();
      $config['upload_path']  = './upload/cancel_msr/';
      
      $config['allowed_types']= '*';
      // print_r($_FILES);
      $this->upload->initialize($config);
      if ( ! $this->upload->do_upload('file_cancel_msr'))
      {
        echo json_encode(['msg'=>$this->upload->display_errors('', '')]);
        exit();
      }else{
        $data = $this->upload->data();
        // $field['attachment'] = $data['file_name'];
        $this->db->where('msr_no', $msr_no)->update('t_msr', [
          'status' => 2, 
          'attachment_cancel' => $data['file_name']
        ]);
      }
      if($this->db->trans_status() === TRUE)
      {
        $this->db->trans_commit();
        echo json_encode(['status'=>true, 'msg'=>'MSR Canceled']);
      }
      else
      {
        $this->db->trans_rollback();
        echo json_encode(['msg'=>'Fail, Please Try Again']);
      }
    }

}
