<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Validatejde extends CI_Controller {

    public function __construct()
    {
        parent:: __construct();
        $this->db = $this->load->database('oracledev', TRUE);
    }

    public function checkItem()
    {
        $postcc = explode(' - ', $this->input->post("costcenter"));
        $postAcc = explode('-', $this->input->post("account"));
        $postUom = explode(' - ', $this->input->post("uomItem"));
        $invType = $this->input->post("invType");
        $itemType = $this->input->post("itemType");

        if ($invType != 1) {
            $gmobj = $postAcc[0];
            $gmsub = $postAcc[1];
        }
        $costcenter = "   " . $postcc[0];
        $material = $this->input->post("material");
        $uom = $postUom[0];

        $checkCC = $this->checkCostcenter($costcenter, $gmobj, $gmsub);
        $checkMaterial = $this->checkMaterial($material, $uom);
        $matchCheck = false;

        if ($itemType == "GOODS") {
            if ($invType == 1) {
                if ($checkMaterial) {
                    $matchCheck = true;
                }
            } else {
                if ($checkCC && $checkMaterial) {
                    $matchCheck = true;
                }
            }
        } else {
            if ($checkCC) {
                $matchCheck = true;
            }
        }

        if ($matchCheck) {
            $data = array(
                "status" => true,
                "msg" => "Material and Costcenter is Avaible"
            );
        } else {
            if ($checkCC === false) {
                $msg = "Costcenter is not avaible for JDE";
            } else if ($checkMaterial === false) {
                $msg = "Material is not avaible for JDE";
            }
            $data = array(
                "status" => false,
                "msg" => $msg
            );
        }
        echo json_encode($data);
    }

    public function testAlert()
    {
        $data = array(
            "msg" => "Material is not avaible for JDE",
            "status" => true
        );

        echo json_encode($data);
    }

    public function checkCostcenter($costcenter = '', $gmobj = '', $gmsub = '')
    {
//      Format Costcenter = '   101031200' => '<spasi><spasi><spasi>No_Costcenter'
        $query = $this->db->query("select gmaid from CRPDTA.F0901 WHERE gmmcu = '" . $costcenter . "' and gmobj='" . $gmobj . "' and gmsub='" . $gmsub . "' and gmpec=' '");
        if ($query->num_rows() > 0){
            return true;
        } else {
            return false;
        }
    }

    public function checkMaterial($matno, $uom)
    {
        $query = $this->db->query("select imuom3 from f4101 where imuom3 = '" . $uom . "' and imitm = " . $matno);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            $query = $this->db->query("select * from f41002  where umitm = " . $matno . "   and  umum=(select imuom3 from f4101 where imitm= " . $matno . ")  and umrum='" . $uom . "'");
            if ($query->num_rows() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }
}