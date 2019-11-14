<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}

    public function set_prebiddate() {
        $this->db->query('update t_eq_data set prebiddate = \'0000-00-00 00:00:00\' where prebiddate = \'1970-01-01 00:00:00\'');
    }

    public function set_bod_date() {
        $this->db->query('update t_eq_data set bod_date = (SELECT po_date - INTERVAL 7 DAY FROM t_purchase_order where t_purchase_order.msr_no = t_eq_data.msr_no)
            WHERE t_eq_data.id IN (
                select a.id from (select * from t_eq_data) a
            join t_msr ON t_msr.msr_no = a.msr_no
            WHERE t_msr.total_amount > CASE
                WHEN t_msr.id_currency = 1 THEN 1000000000
                ELSE 100000
            END
            )');
    }

    public function set_boc_date() {
        $this->db->query('update t_eq_data set boc_date = (SELECT po_date - INTERVAL 7 DAY FROM t_purchase_order where t_purchase_order.msr_no = t_eq_data.msr_no)
            WHERE t_eq_data.id IN (
                select a.id from (select * from t_eq_data) a
            join t_msr ON t_msr.msr_no = a.msr_no
            WHERE t_msr.total_amount > CASE
                WHEN t_msr.id_currency = 1 THEN 50000000000
                ELSE 5000000
            END
            )');
    }
    public function create_po_no_from_po($bl_detail_id='')
    {
        $this->load->model('procurement/M_loi')->model('approval/M_bl')->model('procurement/M_purchase_order')->model('procurement/M_purchase_order_type')->model('procurement/M_service_order');
        $this->load->library(['upload', 'DocNumber']);
        $loi = $this->M_loi->findByBlDetailId($bl_detail_id);
        $bl = $this->M_bl->getBlByBlDetailId($bl_detail_id);
        $po_type = $this->M_purchase_order_type->getFromMsrType($bl->id_msr_type ?: '');
        if ($loi && !empty($loi->po_no)) {
            $po_no = $loi->po_no;
            // $po_no = DocNumber::generate($module_kode, $bl->id_company);
        }
        elseif (!$this->M_purchase_order->isMSRHasPO($bl->msr_no)) {
            #cek berapa pemenang
            #lebih dari 1 pemenang pakai code baru, kalo 1 pemenang pakai code lama
            #cek di po dan loi msr tersebut ada gak, kalo ada cari angka maksimalnya 190 atau 191 atau 192
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
                    $po_no = $newNumber;
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
                    $po_no = str_replace('OR', $po_code, $newNumber);
                }
            }
            else
            {
                #oldCode
                $po_no = DocNumber::createFrom($bl->msr_no,
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
                        $po_no = $newNumber;
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
                        $po_no = str_replace('OR', $po_code, $newNumber);
                    }
                }
                else
                {
                    #oldCode
                    $po_no = DocNumber::generate($module_kode, $bl->id_company);
                }
            }
        }
        echo strtoupper($po_no);
    }
    public function value_award($msr_no='', $vendor_id='')
    {
        $q = "select vendor_id, sum(new_price * qty) amount, sum(new_price_base * qty) amount_base from
        (select sop_id, vendor_id, (case 
            when nego_price > 0 then nego_price
            else unit_price
        end) new_price,  (case 
            when nego_price_base > 0 then nego_price_base
            else unit_price_base
        end) new_price_base, (case when t_sop.qty2 > 0 then t_sop.qty1 * t_sop.qty2 else t_sop.qty1 end) qty 
                from t_sop_bid 
                left join t_sop on t_sop.id = t_sop_bid.sop_id
                where t_sop_bid.msr_no = '$msr_no' and award = 1) a where vendor_id = '$vendor_id' group by vendor_id";
        $return = $this->db->query($q)->row();
        print_r($return);
    }
    public function testing_send_email_cmms($wr_no='19000048')
    {
        $this->load->model('cmms/M_work_request', 'mwr');
        $email = $this->mwr->findSupervisor()->EMAIL;
        if($this->mwr->sendEmail($email,$wr_no))
        {
            echo "Store";
        }
        else
        {
            echo "Fail";
        }
    }
    public function test_attachment($value='')
    {
        $sql = "select replace(replace(testing,'{".'\r'."tf1\ansi\ansicpg1252\deff0\deflang1057'),'\par') as aye from (
        select UTL_RAW.CAST_TO_VARCHAR2(DBMS_LOB.SUBSTR(GDTXFT, 8000,1)) testing from f00165 where gdtxky like '%19000199%' and GDGTITNM = 'Text1')";
        $this->db = $this->load->database('oracle', true);
        $rs = $this->db->query($sql)->row();
        $data['attachment'] = $rs->AYE;
        $this->load->view('coba/V_attachment_jde',$data);
    }
}

