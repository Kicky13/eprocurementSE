<?php
class Filter extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('dashboard', TRUE);
        $this->load->model('dashboard/m_dashboard');
    }

    public function department_json() {
        $filter = $this->input->get('filter');
        $company = isset($filter['company']) ? $filter['company'] : null;
        $result = $this->m_dashboard->get_department($company);
        echo json_encode(array(
            'data' => $result
        ));
    }

    public function costcenter_json() {
        $filter = $this->input->get('filter');
        $department = isset($filter['department']) ? $filter['department'] : null;
        $result = $this->m_dashboard->get_costcenter($department);
        echo json_encode(array(
            'data' => $result
        ));
    }

    public function accsub_json() {
        $filter = $this->input->get('filter');
        $costcenter = isset($filter['costcenter']) ? $filter['costcenter'] : null;
        $result = $this->m_dashboard->get_accsub($costcenter);
        echo json_encode(array(
            'data' => $result
        ));
    }

}
