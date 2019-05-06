<?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_Currency extends MY_Model {
    protected $table = 'm_currency';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_currency')->order_by('CREATE_TIME DESC')->get();

        return $data->result();
    }

    public function add($data) {
        $data = $this->db->insert('m_currency', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update('m_currency', $data);
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

    public function find($id)
    {
        return @$this->db->where('id', $id)->get($this->table)->result()[0];
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
?>

