<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_pre_bid_location extends CI_Model {
    protected $table = 'm_pre_bid_location';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where("id", $where);
        }
        $data = $this->db->select("*")->from($this->table)->order_by('id desc')->get();
        return $data->result_array();
    }

    public function add($data) {
        $this->db->trans_begin();
        
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

    public function update($id, $data) {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

    public function find($id)
    {
        return @$this->db->where('id', $id)->get($this->table)->result()[0];
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