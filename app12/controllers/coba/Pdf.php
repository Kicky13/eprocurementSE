<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pdf extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Pdf');
    }

    function index() {
      $this->load->view('coba/V_priviewpdf');  
    }

    function generate_to_pdf() {
        $this->pdf->load_view('coba/V_cetakpdf');

        $paper_size = 'A4'; //paper size
        $orientation = 'landscape'; //tipe format kertas

        $html = $this->output->get_output();

        $this->pdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->pdf->render();
        //utk menampilkan preview pdf

        $this->pdf->stream("name-file.pdf", array('Attachment' => 0));
        //atau jika tidak ingin menampilkan (tanpa) preview di halaman browser
        //$this->dompdf->stream("nama-file.pdf");
    }

}
