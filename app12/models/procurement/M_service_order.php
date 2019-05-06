<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Basically this is mirror of M_purchase_order with module_kode = 'so'
 * Do we need to use __call ?
 */ 
class M_service_order extends MY_Model
{
    const module_kode = 'so';

    protected $table = 't_purchase_order';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('procurement/M_purchase_order');
    }

    public function getLastDocNumber($year, $company)
    {
        return $this->M_purchase_order->getLastDocNumber($year, $company);
    }

    public function isDocNumberExists($po_no, $year, $company)
    {
        return $this->M_purchase_order->isDocNumberExists($po_no, $year, $company);
    }
}
