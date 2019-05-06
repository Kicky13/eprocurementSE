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
}

