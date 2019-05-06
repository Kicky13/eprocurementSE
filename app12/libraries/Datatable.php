<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Datatable {

    protected $CI;

    private $table;

    private $select = '*';

    private $join = array();

    private $where = array();

    private $having = array();

    protected $add_columns = array();

    protected $edit_columns = array();

    protected $group_by;

    public function __construct() {
        $this->CI = &get_instance();
    }

    public function resource($table, $select = '*') {
        $this->table = $table;
        $this->select = $select;
        return $this;
    }

    public function join($table, $cond, $type = '', $escape = null) {
        $this->join[] = array(
            'table' => $table,
            'cond' => $cond,
            'type' => $type,
            'escape' => $escape
        );
        return $this;
    }

    public function where($key, $value = null, $escape = null) {
        $this->where[] = array(
            'type' => 'where',
            'key' => $key,
            'value' => $value,
            'escape' => $escape
        );
        return $this;
    }

    public function where_in($key, $value = null, $escape = null) {
        $this->where[] = array(
            'type' => 'where_in',
            'key' => $key,
            'value' => $value,
            'escape' => $escape
        );
        return $this;
    }

    public function or_where($key, $value = null, $escape = null) {
        $this->where[] = array(
            'type' => 'or_where',
            'key' => $key,
            'value' => $value,
            'escape' => $escape
        );
        return $this;
    }

    public function or_where_in($key, $value = null, $escape = null) {
        $this->where[] = array(
            'type' => 'or_where_in',
            'key' => $key,
            'value' => $value,
            'escape' => $escape
        );
        return $this;
    }

    public function like($key, $value = null, $side = 'both', $escape = null) {
        $this->where[] = array(
            'type' => 'like',
            'key' => $key,
            'value' => $value,
            'side' => $side,
            'escape' => $escape
        );
        return $this;
    }

    public function or_like($key, $value = null, $side = 'both', $escape = null) {
        $this->where[] = array(
            'type' => 'or_like',
            'key' => $key,
            'value' => $value,
            'side' => $side,
            'escape' => $escape
        );
        return $this;
    }

    public function limit($length, $start = 0) {
        $params = $this->CI->input->get();
        if (isset($params['length'])) {
            if ($params['length'] == -1) {
                $this->CI->db->limit($length, $params['start']);
            }
        } else {
            $this->CI->db->limit($length, $start);
        }
        return $this;
    }

    public function group_by($field){
        $this->group_by = $field;
        return $this;
    }

    public function having($key, $value = NULL, $escape = NULL) {
        $this->having[] = array(
            'type' => 'having',
            'key' => $key,
            'value' => $value,
            'escape' => $escape
        );
    }

    public function or_having($key, $value = NULL, $escape = NULL) {
        $this->having[] = array(
            'type' => 'or_having',
            'key' => $key,
            'value' => $value,
            'escape' => $escape
        );
    }

    public function add_column($name, $value) {
        $this->add_columns[$name] = $value;
        return $this;
    }

    public function edit_column($name, $value) {
        $this->edit_columns[$name] = $value;
        return $this;
    }

    public function order_by($field, $direction = null) {
        if (!isset($params['order'])) {
            $this->CI->db->order_by($field, $direction);
        }
        return $this;
    }

    private function build_join() {
        foreach ($this->join as $join) {
            $this->CI->db->join($join['table'], $join['cond'], $join['type'], $join['escape']);
        }
    }

    private function build_where() {
        if (count($this->where) <> 0) {
            $this->CI->db->group_start();
        }
        foreach ($this->where as $where) {
            switch ($where['type']) {
                case 'where':
                    $this->CI->db->where($where['key'], $where['value'], $where['escape']);
                    break;
                case 'where_in':
                    $this->CI->db->where_in($where['key'], $where['value'], $where['escape']);
                    break;
                case 'or_where':
                    $this->CI->db->or_where($where['key'], $where['value'], $where['escape']);
                    break;
                case 'or_where_in':
                    $this->CI->db->or_where_in($where['key'], $where['value'], $where['escape']);
                    break;
                case 'like':
                    $this->CI->db->like($where['key'], $where['value'], $where['side'], $where['escape']);
                    break;
                case 'or_like':
                    $this->CI->db->or_like($where['key'], $where['value'], $where['side'], $where['escape']);
                    break;
            }
        }
        if (count($this->where) <> 0) {
            $this->CI->db->group_end();
        }
    }

    public function build_having() {
        foreach ($this->having as $having) {
            switch ($having['type']) {
                case 'having':
                    $this->CI->db->having($having['key'], $having['value'], $having['escape']);
                    break;
                case 'or_having':
                    $this->CI->db->od_having($having['key'], $having['value'], $having['escape']);
                    break;
            }
        }
    }

    public function filter($filter) {
        $filter($this);
        return $this;
    }

    private function build_search() {
        $params = $this->CI->input->get();
        if (isset($params['search'])) {
            if ($params['search']['value']) {
                foreach ($params['columns'] as $column) {
                    if ($column['searchable'] == 'true') {
                        if ($column['name'] <> '') {
                            $searchable[] = $column['name'];
                        } else {
                            $searchable[] = $column['data'];
                        }
                    }
                }
                if (count($searchable) <> 0) {
                    $this->CI->db->group_start();
                    $this->CI->db->like($searchable[0], $params['search']['value']);
                    unset($searchable[0]);
                    foreach ($searchable as $column) {
                        $this->CI->db->or_like($column, $params['search']['value']);
                    }
                    $this->CI->db->group_end();
                }
            }
        }
    }

    private function build_order() {
        $params = $this->CI->input->get();
        if (isset($params['order'])) {
            foreach ($params['order'] as $order) {
                if ($params['columns'][$order['column']]['name'] <> '') {
                    $column = $params['columns'][$order['column']]['name'];
                } else {
                    $column = $params['columns'][$order['column']]['data'];
                }
                $this->CI->db->order_by($column, $order['dir']);
            }
        }
    }

    public function generate($return = false) {
        $params = $this->CI->input->get();

        $this->CI->db->select($this->select);
        $this->build_join();
        $this->build_where();
        $this->build_search();
        $this->build_order();
        $this->build_having();
        if($this->group_by) {
            $this->CI->db->group_by($this->group_by);
        }
        if (isset($params['length'])) {
            if ($params['length'] <> -1) {
                $this->CI->db->limit($params['length'], $params['start']);
            }
        }
        $result = $this->CI->db->get($this->table)->result();
        $data = $result;
        foreach ($data as $key => $row) {
            if (count($this->add_columns) <> 0) {
                foreach ($this->add_columns as $add_column => $value) {
                    if (is_callable($value)) {
                        $row->$add_column = $value($row);
                    } else {
                        $row->$add_column = $value;
                    }
                }
            }

            if (count($this->edit_columns) <> 0) {
                foreach ($this->edit_columns as $edit_column => $value) {
                    $row->original[$edit_column] = $row->$edit_column;
                    if (is_callable($value)) {
                        $row->$edit_column = $value($row);
                    } else {
                        $row->$edit_column = $value;
                    }
                }
            }
            $data[$key] = $row;
        }

        $this->CI->db->select($this->select);
        $this->build_join();
        $this->build_where();
        $this->build_order();
        $this->build_having();
        if($this->group_by) {
            $this->CI->db->group_by($this->group_by);
        }
        $record_total = $this->CI->db->from($this->table)->count_all_results();
        $this->CI->db->select($this->select);
        $this->build_join();
        $this->build_where();
        $this->build_search();
        $this->build_order();
        $this->build_having();
        if($this->group_by) {
            $this->CI->db->group_by($this->group_by);
        }
        $record_filtered = $this->CI->db->from($this->table)->count_all_results();

        $response = array(
            'draw' => isset($params['draw']) ? $params['draw'] : 1,
            'recordsTotal' => $record_total,
            'recordsFiltered' => $record_filtered,
            'data' => $data
        );

        if ($return) {
            return $response;
        } else {
            $this->CI->output->set_content_type('application/json')->set_output(json_encode($response));
        }
    }
}