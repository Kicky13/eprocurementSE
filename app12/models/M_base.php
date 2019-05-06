<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_base extends CI_Model {

    protected $table = '';
    protected $primary_key = 'id';
    protected $timestamps = false;
    protected $authors = false;

    public function __call($method, $params) {
        call_user_func_array(array($this->db, $method), $params);
        return $this;
    }

    public function primary_key() {
        return $this->primary_key;
    }

    public function view($view, $params = array()) {
        call_user_func_array(array($this, 'view_'.$view), $params);
        return $this;
    }

    public function scope($scope) {
        if (is_array($scope)) {
            foreach ($scope as $method) {
                $this->{'scope_'.$method}();
            }
        } else {
            $this->{'scope_'.$scope}();
        }
        return $this;
    }

    public function get() {
        return $this->db->get($this->table)->result();
    }

    public function find($id) {
        return $this->db->where($this->table.'.'.$this->primary_key, $id)
            ->get($this->table)
            ->row();
    }

    public function find_or_fail($id) {
        $result = $this->find($id);
        if (!$result) {
            if ($this->input->is_ajax_request()) {
                $response = array(
                    'success' => false,
                    'message' => 'Data not found'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response))->_display();
                exit();
            } else {
                $this->redirect->with('error_message', 'Data not found')->back();
            }
        } else {
            return $result;
        }
    }

    public function first() {
        return $this->db->limit(1)
            ->get($this->table)
            ->row();
    }

    public function first_or_fail() {
        $result = $this->first();
        if (!$result) {
            if ($this->input->is_ajax_request()) {
                $response = array(
                    'success' => false,
                    'message' => 'Data not found'
                );
                $this->output->set_content_type('application/json')->set_output(json_encode($response))->_display();
                exit();
            } else {
                $this->redirect->with('error_message', 'Data not found')->back();
            }
        } else {
            return $result;
        }
    }

    public function count_all_results() {
        return $this->db->count_all_results($this->table);
    }

    public function insert($record) {
        $record = $this->fill($record);
        if ($this->authors) {
            $record['created_by'] = $this->session->userdata('ID_USER');
        }
        if ($this->timestamps) {
            $record['created_at'] = date('Y-m-d H:i:s');
        }
        $model = $this->db->insert($this->table, $record);
        if ($model) {
            return $this->find_insert_id();
        }
        return $model;
    }

    public function insert_id() {
        return $this->db->insert_id();
    }

    public function find_insert_id() {
        return $this->find($this->insert_id());
    }

    public function insert_batch($records) {
        foreach ($records as $key => $record) {
            $records[$key] = $this->fill($record);
            if ($this->authors) {
                $records[$key]['created_by'] = $this->session->userdata('ID_USER');
            }
            if ($this->timestamps) {
                $records[$key]['created_at'] = date('Y-m-d H:i:s');
            }
        }
        return $this->db->insert_batch($this->table, $records);
    }

    public function update($id, $record = null) {
        if ($record) {
            $result = $this->find_or_fail($id);
            $this->db->where($this->table.'.'.$this->primary_key, $result->{$this->primary_key});
        } else {
            $record = $id;
        }
        $record = $this->fill($record);
        if ($this->authors) {
            $record['updated_by'] = $this->session->userdata('ID_USER');
        }
        if ($this->timestamps) {
            $record['updated_at'] = date('Y-m-d H:i:s');
        }
        return $this->db->update($this->table, $record);
    }

    public function delete($id = null) {
        if ($id) {
            $result = $this->find_or_fail($id);
            $this->db->where($this->table.'.'.$this->primary_key, $result->{$this->primary_key});
        }
        return $this->db->delete($this->table);
    }

    public function enum($name, $value = null) {
        $enum = $this->{'enum_'.$name}();
        if ($value) {
            if (isset($enum[$value])) {
                return $enum[$value];
            } else {
                return null;
            }
        }
        return $enum;
    }

    protected function fill($record = array()) {
        $data = array();
        foreach ($this->fillable as $field) {
            if (isset($record[$field])) {
                $data[$field] = $this->set_record($field, $record[$field]);
            }
        }
        return $data;
    }

    public function set_record($field, $value) {
        if (method_exists($this, 'set_'.$field)) {
            return $this->{'set_'.$field}($value);
        } else {
            return $value;
        }
    }
}