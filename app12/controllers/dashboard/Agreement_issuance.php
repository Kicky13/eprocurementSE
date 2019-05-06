<?php
class Agreement_issuance extends CI_Controller
{
    protected $menu;
    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('dashboard', TRUE);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('dashboard/M_home', 'mhm');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('dashboard/m_dashboard');
        $this->load->model('dashboard/m_agreement_issuance');

        $cek = $this->mai->cek_session();
        $get_menu = $this->mhm->menu();
        foreach($get_menu as $k => $v)
        {
            $this->menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_IND']=$v->DESCRIPTION_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESCRIPTION_ENG']=$v->DESCRIPTION_ENG;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL']=$v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON']=$v->ICON;
        }
    }

    public function index() {
        $data = $this->config->item('dashboard')['scm'];
        $data['filters'] = array(
            'company',
            'department',
            'po_status',
            'po_type',
            'method',
            'specialist',
            'years',
            'months'
        );
        $this->template->display_dash('dashboard/V_agreement_issuance', $data);
    }

    public function get_total_po_type(){
        $filter = $this->input->get('filter');

        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->get_total_po_type($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_top_procurement_specialists() {
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'u.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        //if ($condition_query) {
        //    $this->datatable->where($condition_query, null, false);
        //}
        $this->datatable->resource(" (select u.NAME,count(m.po_no) agreement_number,
            SUM(CASE WHEN m.id_currency=3 THEN m.total_amount_base WHEN m.id_currency=1 THEN m.total_amount/r.amount_from ELSE 0 END) as agreement_value
            from t_purchase_order m
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_user u on u.ID_USER=n.user_id
            join m_currency c on c.id=m.id_currency
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1
            left join m_exchange_rate r on r.id=a.id
            where m.issued = 1 and
             ".$condition_query." group by u.NAME) a ")
        ->limit(5)
        ->generate();
    }

    public function get_top_departments() {
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'u.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        //if ($condition_query) {
        //    $this->datatable->where($condition_query, null, false);
        //}
        $this->datatable->resource(" (select x.DEPARTMENT_DESC,count(m.po_no) agreement_number,
            SUM(CASE WHEN m.id_currency=3 THEN m.total_amount_base WHEN m.id_currency=1 THEN m.total_amount/r.amount_from ELSE 0 END) as agreement_value
            from t_purchase_order m
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_user u on u.ID_USER=n.user_id
            join m_currency c on c.id=m.id_currency
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1
            left join m_exchange_rate r on r.id=a.id
            where m.issued = 1 and
             ".$condition_query." group by x.DEPARTMENT_DESC) a ")
        ->limit(5)
        ->generate();
    }

    public function get_top_suppliers() {
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'u.ID_DEPARTMENT IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '';
        }
        $this->load->library('datatable');
        $this->datatable->resource(" (select v.NAMA,count(m.po_no) agreement_number,
            SUM(CASE WHEN m.id_currency=3 THEN m.total_amount_base WHEN m.id_currency=1 THEN m.total_amount/r.amount_from ELSE 0 END) as agreement_value
            from t_purchase_order m
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_user u on u.ID_USER=n.user_id
            join m_currency c on c.id=m.id_currency
            join m_vendor v on v.id=m.id_vendor
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1
            left join m_exchange_rate r on r.id=a.id
            where m.issued = 1 and
             ".$condition_query." group by v.NAMA) a ")
        ->limit(5)
        ->generate();
    }

    public function get_issuance_agreement_type(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->issuance_agreement_type($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);

    }

    public function get_issuance_agreement_company(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }

        $result = $this->m_agreement_issuance->issuance_agreement_company($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_issuance_agreement_method(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->issuance_agreement_procurement_method($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_issuance_agreement_risk(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->issuance_agreement_risk($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_issuance_agreement_status(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->issuance_agreement_status($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_issuance_agreement_type_value(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->issuance_agreement_type_value($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_issuance_agreement_procspe(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $result = $this->m_agreement_issuance->issuance_agreement_procurement_specialist($condition_query);
        if(empty($result)){
            $result = array(
                'name'=>'-',
                'value'=>'0',
                'number'=>'0'
            );
        }
        echo json_encode($result);
    }

    public function get_issuance_agreement_detail(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        $this->load->library('datatable');
        $this->datatable->resource(" (select m.po_no as agreement_no,CASE WHEN (m.po_type='10' and m.blanket=0) THEN 'Goods' WHEN (m.po_type='20' and m.blanket=0) THEN 'Services' ELSE 'Blanket' END as type,m.total_amount_base as value,c.CURRENCY as currency,v.NAMA as supplier,m.delivery_date as promise_date
            from t_purchase_order m
            join t_msr x on x.msr_no=m.msr_no
            join t_assignment n on n.msr_no=m.msr_no
            join m_currency c on c.id=m.id_currency
            join m_vendor v on v.ID=m.id_vendor
            join (select max(id) as id,1 as a from m_exchange_rate where currency_from=1 and currency_to=3 ) a on a=1
            join m_exchange_rate r on r.id=a.id where ".$condition_query." order by m.po_no ) g ")
        ->limit(5)
        ->generate();
    }

    public function get_issuance_agreement_type_trend(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        echo json_encode(array('data'=>$this->m_agreement_issuance->issuance_agreement_type_trend($condition_query),'periode'=>$periode));
    }

    public function get_issuance_agreement_type_trend_value(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        echo json_encode(array('data'=>$this->m_agreement_issuance->issuance_agreement_type_trend_value($condition_query),'periode'=>$periode));
    }

    public function get_issuance_agreement_company_trend(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        echo json_encode(array('data'=>$this->m_agreement_issuance->issuance_agreement_company_trend($condition_query),'periode'=>$periode));
    }


    public function get_issuance_agreement_method_trend(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        echo json_encode(array('data'=>$this->m_agreement_issuance->issuance_agreement_method_trend($condition_query),'periode'=>$periode));
    }

    public function get_issuance_agreement_procurement_specialist_trend(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        echo json_encode(array('data'=>$this->m_agreement_issuance->issuance_agreement_procurement_specialist_trend($condition_query),'periode'=>$periode));
    }

    public function get_issuance_agreement_risk_trend(){
        $filter = $this->input->get('filter');
        if (!isset($filter['years'])) {
            $filter['years'][] = date('Y');
        }
        $periode = array();
        if (isset($filter['months'])) {
            foreach ($filter['years'] as $y) {
                foreach ($filter['months'] as $month) {
                    $periode[] = $y.'-'.$month;
                }
            }
            $filter['periode'] = $periode;
        }
        $condition = array();
        if (isset($filter['periode'])) {
            $condition[] = 'LEFT(m.po_date, 7) IN (\''.implode('\',\'', $filter['periode']).'\')';
        }
        if (isset($filter['company'])) {
            $condition[] = 'x.id_company IN (\''.implode('\',\'', $filter['company']).'\')';
        }
        if (isset($filter['department'])) {
            $condition[] = 'x.id_department IN (\''.implode('\',\'', $filter['department']).'\')';
        }
        if (isset($filter['method'])) {
            $condition[] = 'x.id_pmethod IN (\''.implode('\',\'', $filter['method']).'\')';
        }
        if (isset($filter['specialist'])) {
            $condition[] = 'n.user_id IN (\''.implode('\',\'', $filter['specialist']).'\')';
        }
        if (isset($filter['type'])) {
            $condition[] = 'm.po_type IN (\''.implode('\',\'', $filter['type']).'\')';
        }
        if (isset($filter['status'])) {
            if ((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)&&(strpos(implode('\',\'', $filter['status']),'Issued') !== false)) {
                $condition[] = 'm.issued IN (1,0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Preparation') !== false)){
                $condition[] = 'm.issued IN (0) ';
            }else if((strpos(implode('\',\'', $filter['status']),'Issued') !== false)){
               $condition[] = 'm.issued IN (1) ';
            }

        }
        if (count($condition) <> 0) {
            $condition_query = implode(' AND ', $condition);
        } else {
            $condition_query = '1=1';
        }
        echo json_encode(array('data'=>$this->m_agreement_issuance->issuance_agreement_risk_trend($condition_query),'periode'=>$periode));
    }

}