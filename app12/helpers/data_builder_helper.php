<?php
function lists($data, $value, $label, $placeholder = null, $placeholder_value = '') {
    $CI = &get_instance();
    $lists = array();
    if ($placeholder) {
        $lists[$placeholder_value] = $placeholder;
    }
    if (is_callable($data)) {
        $data = $data();
    }
    foreach ($data as $row) {
        $row = (Object) $row;
        if (is_callable($value)) {
            $value_data = $value($row);
        } else {            
            $value_data = $row->$value;
        }

        if (is_callable($label)) {
            $label_data = $label($row);
        } else {
            $label_data = $row->$label;
        }
        $lists[$value_data] = $label_data;
    }
    return $lists;
}

function tree_data($data, $id, $parent, $start = '', $text = 'text')   {    
    $tree = array();
    $result = array();
        foreach ($data as $row) {
            $tree[$row->$parent][] = (Object) $row;
        }
        if (isset($tree[$start])) {
        $result = set_tree_data($tree, $tree[$start], $id, $parent, 0, $text);
    }
    return $result;
}


function set_tree_data($data, $parent_data, $id, $parent, $level = 0, $text = 'text') {    
    $result = array();  
    foreach ($parent_data as $key => $row) {
        $row->id = $row->$id;
        $row->text = $row->$text;
        $row->tree_level = $level;        
        if (isset($data[$row->$id])) {              
            $row->items = set_tree_data($data, $data[$row->$id], $id, $parent_data, $level + 1, $text);
            unset($data[$row->$id]);
        }
        $result[] = $row;
    }   
    return $result;    
}

function tree_data_lists($data, $id, $parent, $start = '', $value, $label = array(), $placeholder = null, $placeholder_value = '') {
    $tree = tree_data($data, $id, $parent, $start);        
    $lists = array();
    if ($placeholder) {
        $lists[$placeholder_value] = $placeholder;
    }
    foreach ($tree as $row) {
        $row = (Object) $row;
        $lists[$row->$value] = str_repeat('<span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>', $row->tree_level) . $row->{$label[0]} . ' - ' . $row->{$label[1]};
    }
    return $lists;
}


?>