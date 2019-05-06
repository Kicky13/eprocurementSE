<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class Material_warehouse extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('material/M_material_warehouse');
    }

    public function syncFromJDE()
    {
        $this->shout("Sync-ing data from JDE started.... ");

        $result = $this->M_material_warehouse->getAllFromJDE();

        $this->shout("Found ". count($result). " data to be processed");
            
        $this->shout("Getting master of material data... ");
        $materials = array_pluck($this->M_material_warehouse->allMaterials(), 'material_code', 'material');

        $this->shout("Found ". count($materials). " data");

        foreach($result as $rec) {
            $id_material = array_search(trim($rec->IBLITM), $materials);
            $id_company = substr(trim($rec->IBMCU), 0, 5);

            //$this->shout("Processing material ID : ", $id_material);

            if ($id_material) {
                $data = [
                    'id_material' => $id_material,
                    'id_company' => $id_company, 
                    'id_warehouse' => $rec->IBMCU
                ];

                //$this->shout("Replacing data: ");
                //$this->shout(print_r($data, true));

                $result = $this->M_material_warehouse->replace($data);

                $this->shout($result ? 'OK' : 'FAILED');
            }

            // TODO: log if material does not exists in master
        }

        $this->shout("Sync-ing finish here.");
    }

    protected function shout($text, $line_break = false)
    {
        $eol = php_sapi_name() === 'cli' ? PHP_EOL : '<br>';

        echo $text.($line_break ? $eol : '');
    }
}
