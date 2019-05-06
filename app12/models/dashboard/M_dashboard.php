<?php

class M_dashboard extends CI_Model {

    public function get_company() {
        $user = $this->auth();
        $company = explode(',', $user->COMPANY);
        $this->db->where_in('ID_COMPANY', $company);
        return $this->db->get('m_company')
        ->result();
    }

    public function get_department($company = null) {
        if (!$company) {
            $user = $this->auth();
            $company = explode(',', $user->COMPANY);
            $this->db->where_in('ID_COMPANY', $company);
        }
        if (is_array($company)) {
            if (count($company) > 0) {
                $this->db->where_in('ID_COMPANY', $company);
            }
        } else {
            $this->db->where('ID_COMPANY', $company);
        }
        return $this->db->get('m_departement')
        ->result();
    }

    public function get_users($company = null, $department = null) {
        if (!$company) {
            $user = $this->auth();
            $company = explode(',', $user->COMPANY);
        }
        if (is_array($company)) {
            if (count($company) > 0) {
                $this->db->group_start();
                    $this->db->like('COMPANY', $company[0]);
                    unset($company[0]);
                    foreach ($company as $id_company) {
                        $this->db->or_like('COMPANY', $id_company);
                    }
                $this->db->group_end();
            }
        } else {
            $this->db->where('COMPANY', $company);
        }
        if ($department) {
            $this->db->where_in('ID_DEPARTMENT', $department);
        }
        return $this->db->get('m_user')
        ->result();
    }

    public function get_procurement_method() {
        return $this->db->get('m_pmethod')
        ->result();
    }

    public function get_all_company() {
        return $this->db->query("SELECT '10101,10102,10103' as ID_COMPANY, 'Supreme Energy' as DESCRIPTION, 'ALL' as ABBREVIATION FROM m_company
        WHERE STATUS = 1 UNION select ID_COMPANY, DESCRIPTION, ABBREVIATION FROM m_company")->result();
    }

    public function get_procurement_specialist($company = null, $department = null) {
        if (!$company) {
            $user = $this->auth();
            $company = explode(',', $user->COMPANY);
        }
        if (is_array($company)) {
            if (count($company) > 0) {
                $this->db->group_start();
                    $this->db->like('COMPANY', $company[0]);
                    unset($company[0]);
                    foreach ($company as $id_company) {
                        $this->db->or_like('COMPANY', $id_company);
                    }
                $this->db->group_end();
            }
        } else {
            $this->db->where('COMPANY', $company);
        }
        if ($department) {
            $this->db->where_in('ID_DEPARTMENT', $department);
        }
        $id_role = 28;
        return $this->db->like('ROLES', ','.$id_role)
        ->get('m_user')
        ->result();
    }

    public function get_material_group($type = null) {
        if ($type) {
            $this->db->where('TYPE', $type);
        }
        return $this->db->get('m_material_group')
        ->result();
    }

    public function get_msr_status() {
        $data = array(
            'Preparation' => (Object) array(
                'id' => 'Preparation',
                'description' => 'Preparation'
            ),
            'Selection' => (Object) array(
                'id' => 'Selection',
                'description' => 'Selection'
            ),
            'Completed' => (Object) array(
                'id' => 'Completed',
                'description' => 'Completed'
            ),
            'Signed' => (Object) array(
                'id' => 'Signed',
                'description' => 'Signed'
            ),
            'Canceled' => (Object) array(
                'id' => 'Canceled',
                'description' => 'Canceled'
            )
        );
        return $data;
    }

    public function get_po_status() {
        $data = array(
            0 => (Object) array(
                'id' => 'Preparation',
                'description' => 'Preparation'
            ),
            1 => (Object) array(
                'id' => 'Issued',
                'description' => 'Issued'
            )
        );
        return $data;
    }

    public function get_po_type() {
        $data = array(
            '10' => (Object) array(
                'id' => '10',
                'description' => 'Purchase Order'
            ),
            '20' => (Object) array(
                'id' => '20',
                'description' => 'Service Order'
            ),
            '30' => (Object) array(
                'id' => '30',
                'description' => 'Blanket Purchase Order'
            ),
            /*'40' => (Object) array(
                'id' => '40',
                'description' => 'Contract'
            ),*/
            // '50' => (Object) array(
            //     'id' => '50',
            //     'description' => 'Amendment'
            // )

        );
        return $data;
    }

    public function get_po_item_type() {
        $data = array(
            '10' => (Object) array(
                'id' => '10',
                'description' => 'Goods'
            ),
            '20' => (Object) array(
                'id' => '20',
                'description' => 'Service'
            )

        );
        return $data;
    }

    public function get_msr_type() {
        return $this->db->where('STATUS', 1)
        ->get('m_msrtype')
        ->result();
        /*$data = array(
            (Object) array(
                'id' => 'GOODS',
                'description' => 'GOODS'
            ),
            (Object) array(
                'id' => 'SERVICE',
                'description' => 'SERVICE'
            ),
            (Object) array(
                'id' => 'BLANKET',
                'description' => 'BLANKET'
            )
        );
        return $data;*/
    }

    public function get_supplier_rating() {
        $data = array(
            'Excellent' => (Object) array(
                'id' => 'Excellent',
                'description' => 'Excellent',
                'score_bawah' => '80',
            ),
            'Good' => (Object) array(
                'id' => 'Good',
                'description' => 'Good',
                'score_atas' => '79',
                'score_bawah' => '70'
            ),
            'Fair' => (Object) array(
                'id' => 'Fair',
                'description' => 'Fair',
                'score_atas' => '69',
                'score_bawah' => '60'
            ),
            'Poor' => (Object) array(
                'id' => 'Poor',
                'description' => 'Poor',
                'score_atas' => '59'
            )
        );
        return $data;
    }

    public function get_supplier_classification() {
        return $this->db->get('m_vendor_classification')
        ->result();
    }

    public function get_supplier() {
        return $this->db->get('m_vendor')
        ->result();
    }

    public function auth() {
        $id_user = $this->session->userdata['ID_USER'];
        $user = $this->db->where('ID_USER', $id_user)
        ->get('m_user')
        ->row();
        return $user;
    }

    public function get_movement_types() {
        /*$data = array(
            'IB' => (Object) array(
                'id' => 'IB',
                'description' => 'IB'
            ),
            'IA' => (Object) array(
                'id' => 'IA',
                'description' => 'IA'
            ),
            'IT' => (Object) array(
                'id' => 'IT',
                'description' => 'IT'
            ),
            'OV' => (Object) array(
                'id' => 'OV',
                'description' => 'OV'
            ),
            'II' => (Object) array(
                'id' => 'II',
                'description' => 'II'
            ),
            'CN' => (Object) array(
                'id' => 'CN',
                'description' => 'CN'
            ),
            'IE' => (Object) array(
                'id' => 'IE',
                'description' => 'IE'
            ),
            'CR' => (Object) array(
                'id' => 'CR',
                'description' => 'CR'
            ),
            'CI' => (Object) array(
                'id' => 'CI',
                'description' => 'CI'
            ),
            'PI' => (Object) array(
                'id' => 'PI',
                'description' => 'PI'
            ),
            'CA' => (Object) array(
                'id' => 'CA',
                'description' => 'CA'
            ),
            'IK' => (Object) array(
                'id' => 'IK',
                'description' => 'IK'
            )
        );*/
        $data = $this->db->get('m_mutasi_doc_type')
        ->result();
        return $data;
    }

      public function get_arf_status() {
          $data = array(
              0 => (Object) array(
                  'id' => 'Preparation',
                  'description' => 'Preparation'
              ),
              1 => (Object) array(
                  'id' => 'Completed',
                  'description' => 'Completed'
              ),
              2 => (Object) array(
                  'id' => 'Signed',
                  'description' => 'Signed'
              ),
              3 => (Object) array(
                  'id' => 'Canceled',
                  'description' => 'Canceled'
              ),
          );
          return $data;
      }

      public function get_arf_type() {
          $data = array(
              '10' => (Object) array(
                  'id' => 'Goods',
                  'description' => 'Goods'
              ),
              '20' => (Object) array(
                  'id' => 'Services',
                  'description' => 'Services'
              ),

          );
          return $data;
      }

      public function get_costcenter($dept = null) {
        if (!$dept) {
            $user = $this->auth();
            $dept = $user->ID_DEPARTMENT;
            $this->db->where_in('ID_COSTCENTER', $dept);
        }
        if (is_array($dept)) {
            if (count($dept) > 0) {
                $this->db->where_in('ID_COSTCENTER', $dept);
            }
        } else {
            $this->db->where('ID_COSTCENTER', $dept);
        }
        return $this->db->get('m_costcenter')
        ->result();
      }

      public function get_accsub($costcenter = null) {
        if (!$costcenter) {
            $user = $this->auth();
            $costcenter = $user->ID_DEPARTMENT;
            $this->db->where_in('COSTCENTER', $costcenter);
        }
        if (is_array($costcenter)) {
            if (count($costcenter) > 0) {
                $this->db->where_in('COSTCENTER', $costcenter);
            }
        } else {
            $this->db->where('COSTCENTER', $costcenter);
        }
        return $this->db->get('m_accsub')
        ->result();
      }
}
