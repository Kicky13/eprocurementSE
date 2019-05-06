<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_budget_holder extends MY_Model
{
    protected $table = 'm_budget_holder';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($cc = null, $id = 0) {
        $data = $this->db->select('a.id, b.ID_COSTCENTER as cost_center, a.id_user, c.NAME, b.COSTCENTER_ABR, b.COSTCENTER_DESC, a.active as status')
                        ->from('m_costcenter b')
                        ->join('m_budget_holder a', 'a.cost_center = b.ID_COSTCENTER', 'left')
                        ->join('m_user c', 'c.ID_USER = a.id_user', 'left');
        if ($cc != null)
          $data = $data->where('b.ID_COSTCENTER', $cc);
        if ($id != 0)
          $data = $data->where('a.id', $id);
        $data = $data->order_by('b.COSTCENTER_DESC')->get();
        return $data->result_array();
    }

    public function simpan($data){
      $insert = $this->db->insert('m_budget_holder', $data);
    }

    public function update($id, $data){
      return $this->db->where('id', $id)->update('m_budget_holder', $data);
    }

    public function m_costcenter(){
      // $data = $this->db->query("SELECT * FROM m_costcenter WHERE ID_COSTCENTER NOT IN (SELECT cost_center FROM m_budget_holder) ORDER BY COSTCENTER_DESC ASC");
      $data = $this->db->query("SELECT * FROM m_costcenter");
      return $data->result_array();
    }

    public function m_costcenter_exist(){
      $data = $this->db->query("SELECT * FROM m_costcenter WHERE ID_COSTCENTER IN (SELECT cost_center FROM m_budget_holder) ORDER BY COSTCENTER_DESC ASC");
      // $data = $this->db->query("SELECT * FROM m_costcenter");
      return $data->result_array();
    }

    public function m_user(){
      $data = $this->db->query("SELECT * FROM m_user WHERE STATUS = '1' ORDER BY NAME ASC");
      return $data->result_array();
    }

    public function findByCostCenter($costcenter_id) {
        return $this->db->where('cost_center', $costcenter_id)
            ->get($this->table)->first_row();
    }

}
