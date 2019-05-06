<?php

function can_create_msr() {
    $CI =& get_instance();
    $user_id = $CI->session->userdata('ID_USER');

    $jabatan = $CI->db->from('t_jabatan')
        ->where('user_id', $user_id)
        ->get()->result();

    $permitted_role = [t_jabatan_user_primary];

    foreach($jabatan as $jab) {
        if (in_array($jab->user_role, $permitted_role)) {
            return true;
        }
    }

    return false; 
}

function can_view_msr() {
    $CI =& get_instance();
    $user_id = $CI->session->userdata('ID_USER');

    $jabatan = $CI->db->from('t_jabatan')
        ->where('user_id', $user_id)
        ->get()->result();

    $permitted_role = [t_jabatan_user_primary];

    foreach($jabatan as $jab) {
        if (in_array($jab->user_role, $permitted_role)) {
            return true;
        }
    }

    return false; 
}

function can_edit_msr() {
    $CI =& get_instance();
    $user_id = $CI->session->userdata('ID_USER');

    $permitted_role = [t_jabatan_user_primary/*, user_secondary */];

    $jabatan = $CI->db->from('t_jabatan')
        ->where('user_id', $user_id)
        ->get()->result();

    foreach($jabatan as $jab) {
        if (in_array($jab->user_role, $permitted_role)) {
            return true;
        }
    }

    return false; 
}

function can_edit_msr_draft() {
    $CI =& get_instance();
    $user_id = $CI->session->userdata('ID_USER');

    $permitted_role = [t_jabatan_user_primary, t_jabatan_user_secondary];

    $jabatan = $CI->db->from('t_jabatan')
        ->where('user_id', $user_id)
        ->get()->result();

    foreach($jabatan as $jab) {
        if (in_array($jab->user_role, $permitted_role)) {
            return true;
        }
    }

    return false; 
}

function can_edit_msr_budget_status() {
    $roles = get_instance()->session->userdata('ROLES');
    $roles = array_values(array_filter(explode(',', $roles)));

    return in_array(vp_bsd, $roles) || in_array(bsd_staff, $roles);
}

function can_create_material_revision() {
    return in_array(user, array_filter(explode(',', get_instance()->session->userdata('ROLES'))));
}

function can_edit_po_document($po) {
    if ($po->accept_completed == 0 && $po->completed == 1 ) {
        return true;
    }

    return false;
}
