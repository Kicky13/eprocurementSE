<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class T_upload extends CI_Model {

	protected $table = 't_upload';

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }
	public function hapus($value='')
	{
		$this->db->where('id',$value);
        $upload = $this->db->get('t_upload')->row();
        $data_id = $upload->data_id;
        @unlink('upload/cancel_msr/'.$upload->file_path);

        $this->db->where('id',$value);
        $this->db->delete('t_upload');
        return $data_id;
	}
	public function get()
	{
		return $this->db->select('*')->from($table);
	}
	public function getByKey($array=[])
	{
		return $this->db->where($array)->get($this->table);
	}
}