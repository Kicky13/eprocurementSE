<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_msr_attachment extends MY_Model {
    protected $table = 't_upload';

    const TYPE_SCOPE    = 'SCOPE';
    const TYPE_RA       = 'RA';
    const TYPE_JD       = 'JD';
    const TYPE_OWNEST   = 'OWNEST';
    const TYPE_OTHER    = 'OTHER';
    const TYPE_SCOPEOFSUPPLY = 'SCOPESUPLY';

    protected $types = array(
        self::TYPE_SCOPE   => 'Scope of Work/Supply',
        self::TYPE_RA      => 'Risk Assessment',
        self::TYPE_JD      => 'Justification Document',
        self::TYPE_OWNEST  => "Owners Estimate",
        self::TYPE_SCOPEOFSUPPLY => 'Scope of Supply',
        self::TYPE_OTHER   => 'Other',
    );

    /**
     * File Upload configuration
     * TODO: move this configuration to directory config/file_upload.php
     * 
     * @type array
     */
    protected $uploadConfig = array(
        'upload_path' => './upload/',
        'allowed_types' =>  'doc|docx|xls|xlsx|ppt|pptx|odt|odp|ods|pdf|ps|png|jpg|jpeg'
    );

    public function getUploadConfig()
    {
        return $this->uploadConfig; 
    }
    
    public function getTypes()
    {
        return $this->types;
    }

    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function addBatch($data)
    {
       return $this->db->insert_batch($this->table, $data); 
    }

    public function getByMsrNo($msr_no)
    {
        $this->load->model('procurement/M_msr')
            ->model('user/M_view_user');

        $user_table = $this->M_view_user->getTable();

        $attachments = $this->db->select(["$this->table.*", "$user_table.USERNAME created_by_username", "$user_table.NAME created_by_name"])
            ->from($this->table)
            ->join($user_table, "{$user_table}.ID_USER = {$this->table}.created_by")
            ->where('module_kode', $this->M_msr::module_kode)
            ->where('data_id', $msr_no)
            ->order_by('created_at')
            ->get();

        $_seq = array();
        $result = array();
        foreach($attachments->result() as $att) {
            @$_seq[$att->tipe]++;
            $att->sequence = $_seq[$att->tipe];

            $result[] = $att;
        }

        return $result;

    }    

    public function getByModuleKodeAndDataId($module_kode, $data_id)
    {
        $this->load->model('procurement/M_msr')
            ->model('user/M_view_user');

        $user_table = $this->M_view_user->getTable();

        $attachments = $this->db->select(["$this->table.*", "$user_table.USERNAME created_by_username", "$user_table.NAME created_by_name"])
            ->from($this->table)
            ->join($user_table, "{$user_table}.ID_USER = {$this->table}.created_by")
            ->where('module_kode', $module_kode)
            ->where('data_id', $data_id)
            ->order_by('created_at')
            ->get();

        $_seq = array();
        $result = array();
        foreach($attachments->result() as $att) {
            @$_seq[$att->tipe]++;
            $att->sequence = $_seq[$att->tipe];

            $result[] = $att;
        }

        return $result;
    }

    public function deleteByModuleKodeAndDataId($module_kode, $data_id)
    {
        return $this->db->where('module_kode', $module_kode)
            ->where('data_id', $data_id)
            ->delete($this->table);
    }

}

/* vim: set fen foldmethod=indent ts=4 sw=4 tw=0 et autoindent :*/
