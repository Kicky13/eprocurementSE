<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_currency extends MY_Model {
    protected $table = 'm_currency';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID", $where);
        }
        $data = $this->db->select("*")->from('m_currency')->order_by('CREATE_TIME DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_currency', $data);
    }

    public function update($id, $data){
      return $this->db->where('ID', $id)->update('m_currency', $data);
    }
    public function find($id)
    {
        return @$this->db->where('id', $id)->get('m_currency')->result()[0];
    }
    public function all($value='')
    {
        return $this->db->where(['status'=>1])->get('m_currency')->result();
    }

    public function getBaseCurrency()
    {
        return @$this->db->where('currency_base', 1)->get($this->table)->result()[0];
    }
    
    public function findAllActive($id)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        return $this->db->where('status', 1)->where_in('id', $id)->get($this->table)->result();
    }
}
