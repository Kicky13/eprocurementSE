<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_exchange_rate extends CI_Model {
    protected $table = 'm_exchange_rate';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("ID", $where);
        }
        $data = $this->db->select("*")->from($this->table)->order_by('currency_from,currency_to,valid_from asc')->get();
        return $data->result_array();
    }

    public function add($data) {
        $this->db->trans_begin();
        $valid_date = $this->valid_date($data);
        if($valid_date->num_rows() > 0)
        {
            return ['msg'=>'Something wrong, Valid Date Available'];;
        }
        else
        {
            if($data['id'] > 0)
            {
                $this->db->where(['id'=>$data['id']]);
                unset($data['id']);
                $data = $this->db->update($this->table, $data);
            }
            else
            {
                $data = $this->db->insert($this->table, $data);    
            }
            
            if($this->db->trans_status() === true)
            {
                $this->db->trans_commit();
                return ['status'=>true, 'msg'=>'Success'];
            }
            else
            {
                $this->db->trans_rollback();
                return ['msg'=>'Something wrong, Please Call The Admin'];
            }
        }
    }

    public function update($id, $data) {
        return $this->db->where('ID', $id)->update($this->table, $data);
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

    public function find($id)
    {
        return @$this->db->where('id', $id)->get($this->table)->result()[0];
    }
    public function valid_date($data='')
    {
        $where = '';
        if($data['id'] > 0)
        {
            $where = "and id != $data[id]";
        }
        $sql = "select * from $this->table where currency_from = $data[currency_from] and currency_to = $data[currency_to] and '$data[valid_from]' between valid_from and valid_to $where";
        return $this->db->query($sql);
    }
    public function getDefault($value='')
    {
        $sql = "select * from m_currency where CURRENCY_BASE = 1";
        return $this->db->query($sql)->row();
    }
    public function destroy($id='')
    {
        $this->db->trans_begin();
        $this->db->where(['id'=>$id]);
        $data = $this->db->delete($this->table);           
        if($this->db->trans_status() === true)
        {
            $this->db->trans_commit();
            return ['status'=>true, 'msg'=>'Success'];
        }
        else
        {
            $this->db->trans_rollback();
            return ['msg'=>'Something wrong, Please Call The Admin'];
        }
    }
}