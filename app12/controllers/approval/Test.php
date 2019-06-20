<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Test extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
    }
    public function mail_print($id='')
    {
    	$query = $this->db->query("SELECT distinct u.NAME,d.DEPARTMENT_DESC,u.email as recipient,n.TITLE,n.OPEN_VALUE,n.CLOSE_VALUE FROM m_user u
            join m_notic n on n.ID=$id
            join m_departement d on d.ID_DEPARTMENT=u.ID_DEPARTMENT
            where  u.id_user=168");
        if ($query->num_rows() > 0) {
          $data_role = $query->result();
          $count = 1;
        } else {
          $count = 0;
        }
        $img1 = 'img1';
        $img2 = 'img2';
        $msr_title = 'msr_title';
        if ($count === 1) {

          $res = $data_role;
          $str = $data_role[0]->OPEN_VALUE;
          $str = str_replace('_var1_',$msr_title,$str);
          $str = str_replace('_var2_',$data_role[0]->NAME,$str);
          $str = str_replace('_var3_',$data_role[0]->DEPARTMENT_DESC,$str);
          $str = str_replace('_var4_','MSR_NUMBER_TEST',$str);

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
          echo "<pre>";
          print_r($data);
        }
    }
}