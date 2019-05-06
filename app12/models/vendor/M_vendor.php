<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_vendor extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
        $this->tbld     = 't_bl_detail';
        $this->tbv  = 'm_vendor';
        $this->tbl  = 't_bl';
    }

    public function menu() {
        $cek = isset($_SESSION['ACCESS']) ? $_SESSION['ACCESS'] : NULL;
        if ($cek == null) {
            echo "<script>document.location.href='".  base_url('in')."'</script>";
        }
        $menu = null;
        foreach ($_SESSION['ACCESS'] as $k => $v) {//gabungkan menu tiap akses
            $menu_temp = $menu . "," . $v['M'];
            $menu = $menu_temp;
        }

        $menu = explode(",", $menu);
        $menu = array_values(array_filter($menu)); //distroy null value
        $menu = array_unique($menu);
        $data = $this->db->from('m_menu')
                ->where_in('ID_MENU', $menu)
                ->where('STATUS', '1')
                ->order_by("SORT")
                ->get();
        return $data->result();
    }
	
	public function task() {
        $cek = isset($_SESSION['TASK']) ? $_SESSION['TASK'] : NULL;
        if ($cek == null) {
            echo "<script>document.location.href='".  base_url('in')."'</script>";
        }
        $menu = null;
        foreach ($_SESSION['TASK'] as $k => $v) {//gabungkan menu tiap akses
            $menu_temp = $menu . "," . $v['M'];
            $menu = $menu_temp;
        }

        $menu = explode(",", $menu);
        $menu = array_values(array_filter($menu)); //distroy null value
        $menu = array_unique($menu);
        $data = $this->db->from('m_menu_task')
                ->where_in('id', $menu)
                ->order_by("sort")
                ->get();
        return $data->result();
    }
    
    public function getVendorMsrAll()
    {
        $vendorId = $this->session->userdata('ID');
        $this->db->select('*');
        $this->db->where(['vendor_id'=>$vendorId,'confirmed'=>1]);
        $this->db->join($this->tbv, $this->tbv.'.ID = '.$this->tbld.'.vendor_id');
        $this->db->join($this->tbl, $this->tbl.'.msr_no = '.$this->tbld.'.msr_no');
        return $this->db->get($this->tbld);
    }
}

?>
