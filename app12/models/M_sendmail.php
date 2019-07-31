<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_sendmail extends CI_Model {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('exchange_rate_helper')->helper(array('form', 'array', 'url', 'exchange_rate'));
        $this->load->helper(array('string', 'text'));
        $this->db = $this->load->database('default', true);
    }

    public function sendMail($content)
    {
        $ctn = ' <p>' . $content['img1'] . '<p>
                 <br>' . $content['open'] . ' 
                 <br>' . $content['close'] . ' <br> ';
        $data_email['subject'] = $content['title'];
        $data_email['content'] = $ctn;
        $data_email['ismailed'] = 0;

        foreach ($content['dest'] as $i => $item) {
            $data_email['recipient'] = $item;
            $ins = $this->db->insert('i_notification', $data_email);

            if ($ins) {
                $flag = 1;
            } else {
                $flag = 0;
            }
        }
        return $flag;
    }
}