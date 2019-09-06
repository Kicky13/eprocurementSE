<?php

/**
 * Letter of Intent
 *
 * @class Loi
 *
 */
class Loi extends CI_Controller
{
	protected $uploadConfig;

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model('approval/M_bl')
            ->model('procurement/M_loi')
            ->model('procurement/M_loi_attachment')
            ->model('procurement/M_purchase_order')
            ->model('procurement/M_service_order')
            ->model('procurement/M_purchase_order_type')
            ->model('approval/M_approval')
            ->model('other_master/M_currency')
            ->model('M_sendmail')
            ->helper(['exchange_rate', 'form', 'array'])
            ->library(['upload', 'DocNumber']);

    	$this->config->load('file_upload', true);

    	$this->uploadConfig = $this->config->item('loi', 'file_upload');
    }

    public function index()
    {
    }

    public function create($bl_detail_id)
    {
    	$this->load->helper(['form'])
    		->model('setting/M_master_company')
    		->model('approval/M_bl')
    		->library('form_validation');

        $bl = @$this->M_bl->awarders($bl_detail_id)[0];

        if (!$bl) {
            show_error('Invalid source document');
        }

        if ($bl->po_id) {
            show_error('LOI document creation is disabled if Agreement Document already found');
        }

        if ($this->M_loi->findByBlDetailId($bl_detail_id)) {
            show_error('LOI document is already created or under development');
        }

    	if ($this->input->post() && $this->validateLoiCreate()) {
    		$hit_db = true;

    		if (!$this->input->post('bl_detail_id')) {
    			show_error("Invalid document", 404);
    		}

            if(false === ($attachment_files = $this->handleUploadAttachment(['draft_of_loi'])))
            {
                $hit_db = false;

                $message['message'] = $this->upload->display_errors();
                $message['type'] = 'danger';
                log_message('error', $message['message'].' draft_of_loi ');
            }
            
            /*if(@$_FILES['itp_form']['tmp_name'])
            {
                if(false === ($attachment_files = $this->handleUploadAttachment(['itp_form'])))
                {
                    $hit_db = false;

                    $message['message'] = $this->upload->display_errors();
                    $message['type'] = 'danger';
                    log_message('error', $message['message'].' itp_form ');
                }
            }

            if(@$_FILES['performance_bond']['tmp_name'])
            {
                if(false === ($attachment_files = $this->handleUploadAttachment(['performance_bond'])))
                {
                    $hit_db = false;

                    $message['message'] = $this->upload->display_errors();
                    $message['type'] = 'danger';
                    log_message('error', $message['message'].' performance_bond ');
                }
            }*/
            

    		/*if (false === ($attachment_files = $this->handleUploadAttachment([
	        	'draft_of_loi',
	        	'itp_form',
	        	'performance_bond',
	        //	'statement_of_authenticity'
    		]))) {
    			$hit_db = false;

    			$message['message'] = $this->upload->display_errors();
                $message['type'] = 'danger';
	            log_message('error', $message['message']);
    		}*/

            $po = $this->M_purchase_order->findByBlDetailId($bl_detail_id);

            $po_type = $this->M_purchase_order_type->getFromMsrType($bl->id_msr_type ?: '');

            if ($po && !empty($po->po_no)) {
                $_POST['po_no'] = $po->po_no;
            }
            elseif (!$this->M_purchase_order->isMSRHasPO($bl->msr_no)) {
                $bidder = $this->db->where(['awarder'=>1, 'msr_no'=>$bl->msr_no])->get('t_bl_detail');
                if($bidder->num_rows() > 1)
                {
                    $po  = $this->db->where('msr_no', $bl->msr_no)->get('t_purchase_order')->result();
                    $loi = $this->db->where('msr_no', $bl->msr_no)->get('t_letter_of_intent')->result();
                    $arrPoNo = [];
                    foreach ($po as $v) {
                        $arrPoNo[] = $v->po_no;
                    }
                    foreach ($loi as $v) {
                        $arrPoNo[] = $v->po_no;
                    }
                    if(count($arrPoNo) > 0)
                    {
                        $sorting = arsort($arrPoNo);
                        $last = $arrPoNo[0];
                        $msrNo = $last; //po_no not msrNo
                        $substr = substr($msrNo, 2, 1);
                        $seq = $substr+1;
                        $substr = substr($msrNo,0,2);
                        $substrLast = substr($msrNo,3,14);
                        $newNumber = $substr.$seq.$substrLast;
                        $_POST['po_no'] = $newNumber;
                    }
                    else
                    {
                        // $msrNo = '19143002-OR-10103';
                        $msrNo = $bl->msr_no;
                        // echo "msrNo = $msrNo <br>";
                        $substr = substr($msrNo, 2, 1);
                        // echo "substr = $substr <br>";
                        $seq = $substr+1;
                        // echo "seq = $seq <br>";
                        $substr = substr($msrNo,0,2);
                        $substrLast = substr($msrNo,3,14);
                        $newNumber = $substr.$seq.$substrLast;
                        // echo "substr = $substr <br>";
                        // echo "substrLast = $substrLast <br>";
                        // echo "new number = $newNumber <br>";
                        $po_code = $po_type == $this->M_purchase_order_type::TYPE_GOODS ? $this->M_purchase_order::module_kode : $this->M_service_order::module_kode;
                        $doc_no = new DocNumber();
                        $po_code = $doc_no->getDocTypeCode($po_code);
                        $_POST['po_no'] = str_replace('OR', $po_code, $newNumber);
                    }
                }
                else
                {
                    $_POST['po_no'] = DocNumber::createFrom($bl->msr_no,
                        $po_type == $this->M_purchase_order_type::TYPE_GOODS ?
                            $this->M_purchase_order::module_kode :
                            $this->M_service_order::module_kode
                    );
                }
            }
            else {
                $bidder = $this->db->where(['awarder'=>1, 'msr_no'=>$bl->msr_no])->get('t_bl_detail');
                $poFindByDetailId = $this->M_purchase_order->findByBlDetailId($bl_detail_id);
                if($poFindByDetailId)
                {
                    $po_no = $poFindByDetailId->po_no;
                }
                else
                {
                    if($bidder->num_rows() > 1)
                    {
                        $po  = $this->db->where('msr_no', $bl->msr_no)->get('t_purchase_order')->result();
                        $loi = $this->db->where('msr_no', $bl->msr_no)->get('t_letter_of_intent')->result();
                        $arrPoNo = [];
                        foreach ($po as $v) {
                            $arrPoNo[] = $v->po_no;
                        }
                        foreach ($loi as $v) {
                            $arrPoNo[] = $v->po_no;
                        }
                        if(count($arrPoNo) > 0)
                        {
                            $sorting = arsort($arrPoNo);
                            $last = $arrPoNo[0];
                            $msrNo = $last; //po_no not msrNo
                            $substr = substr($msrNo, 2, 1);
                            $seq = $substr+1;
                            $substr = substr($msrNo,0,2);
                            $substrLast = substr($msrNo,3,14);
                            $newNumber = $substr.$seq.$substrLast;
                            $_POST['po_no'] = $newNumber;
                        }
                        else
                        {
                            // $msrNo = '19143002-OR-10103';
                            $msrNo = $bl->msr_no;
                            // echo "msrNo = $msrNo <br>";
                            $substr = substr($msrNo, 2, 1);
                            // echo "substr = $substr <br>";
                            $seq = $substr+1;
                            // echo "seq = $seq <br>";
                            $substr = substr($msrNo,0,2);
                            $substrLast = substr($msrNo,3,14);
                            $newNumber = $substr.$seq.$substrLast;
                            // echo "substr = $substr <br>";
                            // echo "substrLast = $substrLast <br>";
                            // echo "new number = $newNumber <br>";
                            $po_code = $po_type == $this->M_purchase_order_type::TYPE_GOODS ? $this->M_purchase_order::module_kode : $this->M_service_order::module_kode;
                            $doc_no = new DocNumber();
                            $po_code = $doc_no->getDocTypeCode($po_code);
                            $_POST['po_no'] = str_replace('OR', $po_code, $newNumber);
                        }
                    }
                    else
                    {
                        $module_kode = $po_type == $this->M_purchase_order_type::TYPE_GOODS ?
                            $this->M_purchase_order::module_kode :
                            $this->M_service_order::module_kode;

                        $_POST['po_no'] = DocNumber::generate($module_kode, $bl->id_company);
                    }
                }
            }

    		if ($hit_db) {
	    		$loi = $this->makeLoiFromPost();
	    		$attachments = $this->makeLoiAttachmentsFromPost(null, $attachment_files, [
		        	'draft_of_loi' => $this->M_loi_attachment::TYPE_DRAFT_LOI,
		        	/*'itp_form' => $this->M_loi_attachment::TYPE_ITP_FORM,
		        	'performance_bond' => $this->M_loi_attachment::TYPE_PBOND,*/
		        //	'statement_of_authenticity' => $this->M_loi_attachment::TYPE_STMT_AUTH
	    		]);

	    		$this->db->trans_start();

	    		$this->M_loi->add($loi);
	    		$loi_id = $this->db->insert_id();

	    		foreach($attachments as $att) {
	    			$att['data_id'] = $loi_id;
	    			$att['module_kode'] = $this->M_loi::module_kode;

		    		$this->M_loi_attachment->add($att);
	    		}

	    		$this->db->trans_complete();

	    		if ($this->db->trans_status() !== FALSE) {

	    			// generate approval flow!!!
                    // try {
                    //    $this->M_approval->generateDocumentFlow($this->M_loi::module_kode, $loi_id);
                    //    log_message('info', 'Document approval #'.$loi_id.' flow has already generated');
                    // } catch (RuntimeException $e) {
                    //   log_message('error', $e->getMessage());
                    // }

                    log_history($this->M_loi::module_kode, $loi_id, 'Created');

                    $this->M_loi->issue($loi_id);

                    log_history($this->M_loi::module_kode, $loi_id, 'Issued');

                    $img1 = "";
                    $img2 = "";
                    $edid = $this->input->post('ed_id');
                    $query = $this->db->query('SELECT ed.subject, bl.msr_no AS msr_no, vendor.ID_VENDOR AS email, vendor.NAMA AS nama, notif.TITLE AS title, notif.OPEN_VALUE AS open, notif.CLOSE_VALUE AS close FROM t_bl_detail bl
                    JOIN m_vendor vendor ON bl.vendor_id = vendor.ID
                    JOIN t_eq_data ed ON ed.msr_no = bl.msr_no
                    JOIN m_notic notif ON notif.ID = 84
                    WHERE bl.id = ' . $bl_detail_id);

                    $data_replace = $query->result();

                    $str = $data_replace[0]->open;
                    $edno = str_replace('R', 'Q', $data_replace[0]->msr_no);
                    $str = str_replace('_var1', $data_replace[0]->nama, $str);
                    $str = str_replace('_var2_', $data_replace[0]->subject, $str);
                    $str = str_replace('_var3_', $edno, $str);

                    $data = array(
                        'img1' => $img1,
                        'img2' => $img2,
                        'title' => $data_replace[0]->title,
                        'open' => $str,
                        'close' => $data_replace[0]->close
                    );
                    foreach ($data_replace as $item) {
                        $data['dest'][] = $item->email;
                    }
                    $flag = $this->M_sendmail->sendMail($data);

	                $this->session->set_flashdata('message', array(
	                    'message' => __('success_submit_with_no', array('no' => $loi_id)),
	                    'type' => 'success'
	                ));

		    		return redirect('home');
	            }

	            $message['type'] = 'error';
	            $message['message'] = sprintf('Failed save Letter of Intent document');
	            log_message($message['type'], $message['message']);
	    	}
    	}

    	$menu = get_main_menu();

    	$bl = $this->M_bl->getBlByBlDetailId($bl_detail_id);

    	if (!$bl) {
    		show_error("Document not found", 404);
    	}

    	$awarder = $this->M_bl->getAwarderById($bl_detail_id);
    	$loi_attachment_type = $this->M_loi_attachment->getTypes();
    	// $company = $this->M_master_company->find($bl->id_company);
    	// $vendor = $this->M_show_vendor->find($awarder->vendor_id);
        $currency = $this->M_currency->find($bl->id_currency);
        $base_currency = get_base_currency();
        // update exchange rate
        $value_award = $this->M_purchase_order->value_award($bl->msr_no, $bl->vendor_id);
        $bl->total_amount = $value_award->amount;
        // exit();
        $bl->total_amount_base = exchange_rate_by_id(
            $bl->id_currency, $base_currency->ID, $bl->total_amount
        );
    	$this->template->display('procurement/V_loi_create', compact(
            'menu', 'bl_detail_id', 'bl', 'awarder', 'message', 'currency',
            'base_currency', 'total_amount_base'
    	));
    }

    public function show($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor');

    	$message = array();
    	$menu = get_main_menu();

    	if (!$id) {
    		show_error("Invalid request", 400);
    	}

    	$loi = $this->M_loi->find($id);

    	if (!$loi) {
    		show_404('The Letter of Intent document is not found');
    	}

    	$loi_attachment_type = $this->M_loi_attachment->getTypes();
        $loi = $this->M_loi->find($id);
        $this->M_loi->update($id, ['is_show'=>1]);
        $loi_attachment = $this->M_loi_attachment->getByDocument($loi->id);
    	$company = $this->M_master_company->find($loi->id_company);
    	$awarder = $this->M_show_vendor->find($loi->awarder_id);
        $opt_currency = array_pluck($this->M_currency->all(), 'CURRENCY', 'ID');

        $this->template->display('procurement/V_loi_show', compact(
            'menu', 'loi', 'message', 'company', 'awarder', 'loi_attachment', 'loi_attachment_type', 'opt_currency'
        ));
    }

    public function approvalList()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval');

	    $message = array();
	    $menu = get_main_menu();

	    $lois = $this->M_loi->toApprove();

	    if (! $lois) {
	    	$message['type'] = 'info';
	    	$message['message'] = 'There is no document to be approved yet';
	    }

    	$this->template->display('procurement/V_loi_to_approve_list', compact('menu', 'lois', 'message'));
    }

    public function toApprove($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval');

    	$message = array();
    	$menu = get_main_menu();

    	if (!$id) {
    		show_404();
    	}

    	$loi = $this->M_loi->find($id);

    	if (!$loi) {
    		show_404('The Letter of Intent document is not found');
    	}

    	if ($this->input->post()) {
    		$post = $this->input->post();
    		$action = $post['status']; // 1: approve; 2: reject

            $loi = $this->M_loi->find($post['id']);
            $data = $this->makeLoiUpdateFromPost();
            $this->M_loi->update($loi->id, $data);

    		if ($action == 1) {
	    		$this->M_loi->approve($post['id'], $post['data_id'], $post['deskripsi']);
    		} elseif ($action == 2) {
	    		$this->M_loi->reject($post['id'], $post['data_id'], $post['deskripsi']);
    		} else {
    			show_error('Unknown action', 400);
    		}

    		return redirect('procurement/loi/approvalList');
    	}

    	$loi_attachment_type = $this->M_loi_attachment->getTypes();
        $loi = $this->M_loi->find($id);
        $loi_attachment = $this->M_loi_attachment->getByDocument($loi->id);
    	$company = $this->M_master_company->find($loi->id_company);
    	$awarder = $this->M_show_vendor->find($loi->awarder_id);
        $approval_list = $this->M_approval->list($this->M_loi::module_kode, $loi->id)->result();
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

    	$this->template->display('procurement/V_loi_to_approve', compact(
            'menu', 'loi', 'message', 'company', 'awarder', 'loi_attachment', 'loi_attachment_type',
            'approval_list', 'roles'
    	));
    }

    public function approve()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval');

        $post = $this->input->post();
        $action = $post['status']; // 1: approve; 2: reject
        $hit_db = true;

        // TODO: input validation

        $loi = $this->M_loi->find($post['data_id']);
        if (!$loi) {
            $type = 'error';
            $message = 'Document LOI not found';

            $hit_db = false;
        }

        if ($hit_db) {
            $data = $this->makeLoiUpdateFromPost();
            $this->M_loi->update($loi->id, $data);

            if ($action == 1) {
                if ($this->M_loi->approve($post['id'], $post['data_id'], $post['deskripsi'])) {
                    $type = 'success';
                    $message = 'Data berhasil di approve';
                } else {
                    $type = 'error';
                    $message = 'Terjadi kesalahan. Silakan ulangi kembali';
                }
            } elseif ($action == 2) {
                if ($this->M_loi->reject($post['id'], $post['data_id'], $post['deskripsi'])) {
                    $type = 'success';
                    $message = 'Data berhasil di approve';
                } else {
                    $type = 'error';
                    $message = 'Terjadi kesalahan. Silakan ulangi kembali';
                }
            } else {
                $type = 'error';
                $message = 'Unknown action';
                //show_error('Unknown action', 400);
            }
        }

        $response['type'] = $type;
        $response['message'] = $message;

        return $this->output->set_content_type('application/json')
            ->set_output(@json_encode($response));
    }

    public function issueList()
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('approval/M_approval');

    	$message = array();
    	$menu = get_main_menu();

    	$lois = $this->M_loi->toIssue();

    	if (! $lois) {
    		$message['type'] = 'info';
	    	$message['message'] = 'There is no document to be issued yet';
    	}

    	$this->template->display('procurement/V_loi_to_issue_list', compact('menu', 'lois', 'message'));
    }

    public function toIssue($id)
    {
        $this->load->model('setting/M_master_company')
            ->model('vendor/M_show_vendor')
            ->model('procurement/M_msr')
            ->model('approval/M_approval');

		$message = array();
    	$menu = get_main_menu();

    	if (!$id) {
    		show_404();
    	}

    	$loi = $this->M_loi->find($id);

    	if (!$loi) {
    		show_404('The Letter of Intent document is not found');
    	}

    	if ($this->input->post()) {
    		$hit_db = true;

    		if (false === ($attachment_files = $this->handleUploadAttachment([
	        	'signed_loi'
    		]))) {
    			$hit_db = false;

    			$message['message'] = $this->upload->display_errors();
                $message['type'] = 'error';
	            log_message($message['type'], $message['message']);
    		}

    		if ($hit_db) {
	   			$attachments = $this->makeLoiAttachmentsFromPost($loi->id, $attachment_files, [
			        	'signed_loi' => $this->M_loi_attachment::TYPE_SIGNED_LOI,
		    		]);

	    		$this->M_loi->issue($loi_id);

	   			foreach($attachments as $att) {
	    			$att['data_id'] = $loi->id;
	    			$att['module_kode'] = $this->M_loi::module_kode;

		    		$this->M_loi_attachment->add($att);
	    		}

                $this->session->set_flashdata('message', array(
                    'message' => 'Letter of Intent #'.$loi->id.' issued',
                    'type' => 'success'
                ));

	    		return redirect('procurement/loi/issueList');
	    	}
    	}


    	$company = $this->M_master_company->find($loi->id_company);
    	$vendor = $this->M_show_vendor->find($loi->awarder_id);
        $requestor = $this->M_msr->find($loi->msr_no);
        $loi_attachments = $this->M_loi_attachment->getByDocument($loi->id);
    	$loi_attachment_type = $this->M_loi_attachment->getTypes();
        $approval_list = $this->M_approval->list($this->M_loi::module_kode, $loi->id)->result();
        $roles = array_filter(explode(',', $this->session->userdata('ROLES')));

        $this->template->display('procurement/V_loi_to_issue', compact(
            'menu', 'loi', 'message', 'company', 'vendor', 'loi_attachments',
            'loi_attachment_type', 'requestor', 'approval_list', 'roles'
        ));
    }

    public function inquiry()
    {
        $params = [];
        $menu = get_main_menu();

        $lois = $this->M_loi->inquiry($params);

        $this->template->display('procurement/V_loi_inquiry', compact(
            'menu', 'lois'
        ));
    }

    public function loiList()
    {
        $params = [];
        $menu = get_main_menu();

        $lois = $this->M_loi->loiList($params);

        $this->template->display('procurement/V_loi_list', compact(
            'menu', 'lois'
        ));
    }

    public function acceptedList()
    {
        $params = [];
        $menu = get_main_menu();

        $lois = $this->M_loi->accepted($params);

        $this->template->display('procurement/V_loi_accepted_list', compact(
            'menu', 'lois'
        ));
    }

    public function logHistory($id)
    {
        $logs = $this->approval_lib->getLog([
            'module_kode' => $this->M_loi::module_kode,
            'data_id' => $id
        ])->result();

        foreach($logs as &$l) {
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
                'data' => $logs,
                'message' => $message,
            ]));
    }

    protected function validateLoiCreate()
    {
        $this->form_validation->set_message('required', 'This field is required.');

        $config = array(
            array('field' 	=> 'title',
            	'rules' 	=> 'trim|required',
            	'message'	=> 'Title is required'),
            array('field' 	=> 'company_letter',
            	'rules'	 	=> 'trim|required',
            	'message' 	=> 'Company letter is required'),
             array('field' 	=> 'loi_date_submit',
                 'rules'		=> 'trim|required|date',
                 'message' 	=> 'Company letter is required'),
            //array('field' 	=> 'draft_of_loi',
                //'rules' 	=> 'required',
                //'message' 	=> 'Draft of LOI file is required'),
            //array('field' 	=> 'itp_form',
                //'rules' 	=> 'required',
                //'message'	=> 'ITP form file is required'),
            //array('field' 	=> 'performance_bond',
                //'rules' 	=> 'required',
                //'message' 	=> 'Performance bond file is required'),
            //array('field' 	=> 'statement_of_authenticity',
                //'rules' 	=> 'required',
                //'message' 	=> 'Statement authenticity file is required'),
        );

        $this->form_validation->set_rules($config);
        return $this->form_validation->run();
    }

    protected function makeLoiFromPost()
    {
    	$post = $this->input->post();

    	$bl_detail_id = $this->input->post('bl_detail_id');
		$bl = $this->M_bl->getBlByBlDetailId($bl_detail_id);
    	$awarder = $this->M_bl->getAwarderById($bl_detail_id);
        $id_currency_base = base_currency();
        $value_award = $this->M_purchase_order->value_award($bl->msr_no, $bl->vendor_id);
        $bl->total_amount = $value_award->amount;
        $total_amount_base = exchange_rate_by_id($bl->id_currency, $id_currency_base, $bl->total_amount);

    	return [
    		'bl_id' => $bl->id,
    		'bl_detail_id' => $bl_detail_id,
    		'id_company' => $bl->id_company,
    		'awarder_id' => $awarder->vendor_id,
    		'msr_no' => $bl->msr_no,
    		'rfq_no' => $bl->bled_no,
            'po_no'  => @$post['po_no'],
    		'title' => trim($post['title']),
    		'company_letter' => trim($post['company_letter']),
    		'loi_date' => $post['loi_date_submit'],
            'id_currency' => $bl->id_currency,
            'id_currency_base' => $id_currency_base,
    		'total_amount' => $bl->total_amount,
            'total_amount_base' => $total_amount_base,
    		'create_by' => $this->session->userdata('ID_USER'),
    		'create_on' => today_sql(),
    	];
    }

    protected function makeLoiUpdateFromPost()
    {
    	$post = $this->input->post();

    	return [
    		'title' => trim($post['title']),
    		'company_letter' => trim($post['company_letter']),
    		'loi_date' => $post['loi_date_submit'],
    		'update_by' => $this->session->userdata('ID_USER'),
    		'update_on' => today_sql(),
    	];
    }

    protected function makeLoiAttachmentsFromPost($loi_id, $files, $attachments_type)
    {
    	// $attachment_type = array(
     //    	'draft_of_loi' => $this->M_loi_attachment::TYPE_DRAFT_LOI,
     //    	'itp_form' => $this->M_loi_attachment::TYPE_ITP_FORM,
     //    	'performance_bond' => $this->M_loi_attachment::TYPE_PBOND,
     //    	'statement_of_authenticity' => $this->M_loi_attachment::TYPE_STMT_AUTH
     //    );

    	$attachments = array();

    	foreach($attachments_type as $name => $type) {
			if (isset($files[$name])) {
	    		$attachments[] = $this->makeAttachment($loi_id, $type, $files[$name]);
	    	}
    	}

    	return $attachments;
    }

    protected function makeAttachment($data_id, $tipe, $file)
    {
        return array(
            'module_kode'   => $this->M_loi::module_kode,
            'data_id'       => $data_id,
            'file_path'     => $this->uploadConfig['upload_path'],
            'file_name'     => $file['file_name'],
            'tipe'          => $tipe,
            'created_by'    => $this->session->userdata('ID_USER'),
            'created_at'    => today_sql()
        );
    }

    protected function handleUploadAttachment($names)
    {
        if (!isset($_FILES) || !$_FILES) {
            return true;
        }

        $data = array();

        $this->upload->initialize($this->uploadConfig);

        foreach($names as $name) {
	        if (false === $this->upload->do_upload($name)) {
	        	return false;
	        }

	        $data[$name] = $this->upload->data();
        }

        return $data;
    }
}
