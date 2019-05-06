<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Coba extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('Pdf', 'encryption', 'email'));
    }

// cobaboaboaboabaobo
//    public function __construct() {
//        parent::__construct();
//        $this->load->library(array('encryption', 'email'));
//        //$this->load->library('M_pdf');
//        $this->load->library('pdf');
//    }

    public function index() {
        echo md5(md5(596182));exit;
        echo "<a href='iwan.php'>Link<a>";exit;
        $string = "Faber Nainggolan";
        $key = "code_add";
        $ciphertext = $this->encryption->encrypt($string);
        echo $this->encryption->decrypt($ciphertext);exit;
        $encript = $this->encryption->encrypt($string);
        $decrypt = $this->encryption->decrypt($encript);

        echo $encript . "<br>" . $decrypt;
    }

    function print_pdf() {
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

    function email() {
        $htmlContent = '<h1>Mengirim email HTML dengan Codeigniter</h1>';
        $htmlContent .= '<div>Contoh pengiriman email yang memiliki tag HTML dengan menggunakan Codeigniter</div>';

        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;

        $this->email->initialize($config);
        $this->email->to('miwan.purwanto@gmail.com');
        $this->email->from('for.want.to@gmail.com', 'iwan');
        $this->email->subject('Coba email');
        $this->email->message($htmlContent);
        
    }

    function treeview() {
        $this->load->view("coba/V_treeview");
    }

    function get_treeview() {
        echo '[{"id":1,"text":"Asia","population":null,"flagUrl":null,"checked":true,"hasChildren":false,"children":[{"id":2,"text":"China","population":1373541278,"flagUrl":"http://code.gijgo.com/flags/24/China.png","checked":false,"hasChildren":false,"children":[]},{"id":3,"text":"Japan","population":126730000,"flagUrl":"http://code.gijgo.com/flags/24/Japan.png","checked":false,"hasChildren":false,"children":[]},{"id":4,"text":"Mongolia","population":3081677,"flagUrl":"http://code.gijgo.com/flags/24/Mongolia.png","checked":false,"hasChildren":false,"children":[]}]},{"id":5,"text":"North America","population":null,"flagUrl":null,"checked":false,"hasChildren":false,"children":[{"id":6,"text":"USA","population":325145963,"flagUrl":"http://code.gijgo.com/flags/24/United%20States%20of%20America(USA).png","checked":false,"hasChildren":false,"children":[{"id":7,"text":"California","population":39144818,"flagUrl":null,"checked":false,"hasChildren":false,"children":[]},{"id":8,"text":"Florida","population":20271272,"flagUrl":null,"checked":false,"hasChildren":false,"children":[]}]},{"id":9,"text":"Canada","population":35151728,"flagUrl":"http://code.gijgo.com/flags/24/canada.png","checked":false,"hasChildren":false,"children":[]},{"id":10,"text":"Mexico","population":119530753,"flagUrl":"http://code.gijgo.com/flags/24/mexico.png","checked":false,"hasChildren":false,"children":[]}]},{"id":11,"text":"South America","population":null,"flagUrl":null,"checked":false,"hasChildren":false,"children":[{"id":12,"text":"Brazil","population":207350000,"flagUrl":"http://code.gijgo.com/flags/24/brazil.png","checked":false,"hasChildren":false,"children":[]},{"id":13,"text":"Argentina","population":43417000,"flagUrl":"http://code.gijgo.com/flags/24/argentina.png","checked":false,"hasChildren":false,"children":[]},{"id":14,"text":"Colombia","population":49819638,"flagUrl":"http://code.gijgo.com/flags/24/colombia.png","checked":false,"hasChildren":false,"children":[]}]},{"id":15,"text":"Europe","population":null,"flagUrl":null,"checked":false,"hasChildren":false,"children":[{"id":16,"text":"England","population":54786300,"flagUrl":"http://code.gijgo.com/flags/24/england.png","checked":false,"hasChildren":false,"children":[]},{"id":17,"text":"Germany","population":82175700,"flagUrl":"http://code.gijgo.com/flags/24/germany.png","checked":false,"hasChildren":false,"children":[]},{"id":18,"text":"Bulgaria","population":7101859,"flagUrl":"http://code.gijgo.com/flags/24/bulgaria.png","checked":false,"hasChildren":false,"children":[]},{"id":19,"text":"Poland","population":38454576,"flagUrl":"http://code.gijgo.com/flags/24/poland.png","checked":false,"hasChildren":false,"children":[]}]}]';
    }

}
