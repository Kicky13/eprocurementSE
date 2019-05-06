<?php
$row = $this->vendor_lib->greeting_list($type,$bled_no)->row();
if ($row->confirmed == 1 || $row->confirmed == 2 || $row->confirmed == 3) {
  $this->load->view('vn/info/greeting_detail_1');
} else {
  $this->load->view('vn/info/greeting_detail_0');
}