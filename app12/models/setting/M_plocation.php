<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_plocation extends MY_Model {
    protected $table = 'm_plocation';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function all() {
        return $this->db->get($this->table)->result();
    }

	public function find($id) {
		return $this->db->where('ID_PGROUP', $id)
			->get($this->table)->result();
	}
    
    public function allActive()
    {
        return $this->db->where('status', '1')->get($this->table)->result();
    }
}
