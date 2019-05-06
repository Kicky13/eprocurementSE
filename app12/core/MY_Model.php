<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
    Use https://github.com/bcit-ci/CodeIgniter/wiki/ActiveRecord-Class for better
    or even Doctrine
*/
class MY_Model extends CI_Model
{

    protected $table;
    protected $fields = [];
    protected $primaryKey = 'id';
    protected $statusField = 'status';
    protected $created_at = 'created_at';
    protected $created_by = 'created_by';
    protected $updated_at = 'updated_at';
    protected $updated_by = 'updated_by';

    public function __construct() 
    {
        parent::__construct();
    }

    public function getTable()
    {
        return $this->table;
    }

    public function all()
    {
        return $this->db->get($this->table)->result();
    }

    public function find($id)
    {
        return @$this->db->where($this->primaryKey, $id)->get($this->table)->result()[0];
    }

    public function add($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->update($this->table, $data, [ $this->primaryKey => $id ]);
    }

    public function delete($id)
    {
        return $this->db->where($this->primaryKey, $id)
            ->delete($this->table);
    }

    public function findAll($id)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        return $this->db->where_in($this->primaryKey, $id)->get($this->table)->result();
    }

    public function findAllActive($id)
    {
        $db = $this->prepareFindAll($id)->whereActive();

        return $db->get($this->table)->result();
    }

    public function findAllInActive($id)
    {
        $db = $this->prepareFindAll($id)->whereInactive();

        return $db->get($this->table)->result();
    }

    public function allActive()
    {
        return $this->whereActive()->get($this->table)->result();
    }

    public function allInActive()
    {
        return $this->whereInactive()->get($this->table)->result();
    }

    public function discover($force = false)
    {
        if (!$force && count($this->fields)) {
            return $this->fields;
        }
        
        $this->fields = $this->db->list_fields($this->table);

        return $this->fields;
    }

    protected function prepareFindAll($id)
    {
        if (!is_array($id)) {
            $id = array($id);
        }

        return $this->db->where_in($this->primaryKey, $id);
    }

    protected function whereInactive()
    {
        return $this->db->where($this->statusField, 0);
    }

    protected function whereActive()
    {
        return $this->db->where($this->statusField, 1);
    }
    
    protected function prepareCreate($data)
    {
        $this->discover();
        
        if (in_array($this->created_at, $this->fields)) {
            $data[$this->created_at] = today_sql();
        }

        if (in_array($this->created_by, $this->fields)) {
            $data[$this->created_by] = $this->session->userdata('ID_USER') ?:
                $this->session->userdata('ID');
        }

        return $data;
    }

    protected function prepareUpdate($data)
    {
        $this->discover();

        if (in_array($this->updated_at, $this->fields)) {
            $data[$this->updated_at] = today_sql();
        }

        if (in_array($this->updated_at, $this->fields)) {
            $data[$this->updated_by] = $this->session->userdata('ID_USER') ?:
                $this->session->userdata('ID');
        }

        return $data;
    }
}
