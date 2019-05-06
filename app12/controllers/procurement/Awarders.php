<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class Awarders extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        show_404();
	}

	public function acceptance()
	{
        $this->load->model('approval/M_bl')
            ->model('procurement/M_loi')
            ->model('vendor/M_show_vendor');

		$menu = get_main_menu();

    	$awarders = $this->M_bl->awarders();

    	$this->template->display('procurement/V_awarders_list', compact(
    		'menu', 'awarders'
    	));

	}
}
