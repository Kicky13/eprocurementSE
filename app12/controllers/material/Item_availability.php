<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Item_availability extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('vendor/M_vendor')->model('material/M_item_availability');
    }

    public function index() {
        $get_menu = $this->M_vendor->menu();
        $dt = array();
        $m_material = $this->M_item_availability->m_material();
        $m_bplant = $this->M_item_availability->m_bplant();
        foreach ($get_menu as $k => $v) {
            $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
        $data['material'] = $m_material;
        $data['bplant'] = $m_bplant;
        $data['menu'] = $dt;
        $this->template->display('material/V_item_availability', $data);
    }

    public function search_Item_availability(){
      $item = $this->input->post("item");
      $desc = $this->input->post("desc");
      $branch_plant = $this->input->post("branch_plant");
      $item_location = $this->input->post("item_location");

      $data_post = array(
        'MATERIAL_ID' => $item,
        'LOCATION' => $desc,
        'BRANCH_PLANT' => $branch_plant,
        'LOCATION_TYPE' => $item_location,
      );

      $data = $this->M_item_availability->search_Item_availability($data_post);
      $no = 0;
      $total = 0;
      foreach ($data as $key => $value) {
        $no++;
        echo "<tr>";
        echo "<td>".$no."</td>";
        echo "<td>".$value['LOCATION_TYPE']."</td>";
        echo "<td>".$value['LOCATION']."</td>";
        echo "<td>".$value['BRANCH_PLANT']."</td>";
        echo "<td>".$value['QTY']."</td>";
        echo "<td>".$value['QTY']."</td>";
        echo "</tr>";
        $total += $value['QTY'];
      }
      echo '<tr>
            <td colspan="4"><center>TOTAL</center> </td>
            <td colspan="1">'.$total.'</td>
            <td colspan="1">'.$total.'</td>
            </tr>';
      // echo json_encode($data);
    }

}
