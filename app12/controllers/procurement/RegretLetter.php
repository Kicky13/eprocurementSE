<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class RegretLetter extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('approval/M_bl')
            ->model('procurement/M_regret_letter')
            ->model('vendor/M_vendor');
    }

    public function index()
    {
        echo "halo";
    }

    public function openList()
    {
        $menu = get_main_menu();

        $letters = $this->M_regret_letter->openList();

        $this->template->display('procurement/V_regret_letter_list', compact(
            'menu', 'letters'
        ));
    }

    public function vendorInquiry()
    {
        $menu = get_vendor_main_menu();

        $letters = $this->M_regret_letter->vendorInquiry($this->session->userdata('ID_USER'));

        $this->template->display_vendor('procurement/V_regret_letter_list', compact(
            'menu', 'letters'
        ));
        
    }

    public function send($bl_detail_id)
    {
        $letter = $this->M_regret_letter->findByBlDetailId($bl_detail_id);

        if (!$letter) {
            show_error("Document not found");
        }

        if ($letter->regret_letter_id) {
            show_error("The Regret Letter has already sent before");
        } 

        if ($this->input->post()) {
            if ($this->M_regret_letter->send($bl_detail_id)) {
                $this->session->set_flashdata('message', array(
                    'message' => 'Regret Letter has been sent',
                    'type' => 'success'
                ));

                redirect('procurement/regretLetter/openList');
            }
        }

        $menu = get_main_menu();

        if (!$letter->regret_date) {
            $letter->regret_date = today_sql();
        }

        $this->template->display('procurement/V_regret_letter', compact(
            'menu', 'letter'
        ));
    }

    public function show($id)
    {
        $menu = get_main_menu();

        $letter = $this->M_regret_letter->findByBlDetailId($id);

        if (!$letter->regret_date) {
            $letter->regret_date = today_sql();
        }

        $this->template->display('procurement/V_regret_letter', compact(
            'menu', 'letter'
        ));
    }

    public function createLetter()
    {
        return '';
    }
}
