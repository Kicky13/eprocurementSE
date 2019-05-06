<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_material_warehouse extends MY_Model
{
    private $jde;

    protected $table = 'sync_material_warehouse';
    protected $jdeTable = 'f4102';

    public function __construct() {
        parent::__construct();
        $this->load->model('setting/M_master_company');
        $this->load->helper(['array']);
    }

    /**
     * depreciated. move to controller to enable verbosing
     */
    public function importAllFromJDE()
    {
        $result = $this->getAllFromJDE();
            
        $materials = array_pluck($this->allMaterials(), 'material_code', 'material');

        foreach($result as $rec) {
            $id_material = array_search(trim($rec->IBLITM), $materials);
            $id_company = substr(trim($rec->IBMCU), 0, 5);

            if ($id_material) {
                $this->replace([
                    'id_material' => $id_material,
                    'id_company' => $id_company, 
                    'id_warehouse' => $rec->IBMCU
                ]);
            }

            // TODO: log if material does not exists in master
        }
    }

    public function getAllFromJDE()
    {
        $companies = array_pluck($this->M_master_company->get_data(), 'ID_COMPANY');
        $this->jde = $this->load->database('oracle', true);

        $companies = array_map(function($company) {
            return "'$company'";
        }, $companies);
        $companies = implode(',', $companies);
        if ($companies) {
            $sql = "select TRIM(IBLITM) as IBLITM,TRIM(IBMCU) as IBMCU from f4102  where substr(trim(ibmcu), 1, 5) in ($companies)";
            return $this->jde->query($sql)->result();
            // $this->db->select(['iblitm', 'ibmcu'])
            //     ->from($this->jdeTable)
            //     ->where_in('substr(trim(ibmcu))', $companies);

            // return $this->jde->get()->result();
        }

        return [];
    }

    public function replace($data)
    {
        return $this->db->replace($this->table, $data);
    }

    public function isSemicNoExistsInWarehouse($semic_no, $warehouse_id) 
    {
        return $this->db->where('material_code', $semic_no)
            ->where('id_warehouse', $id_warehouse)
            ->get($this->table)->num_rows() > 0;
    }

    public function allMaterials()
    {
        return $this->db->select('material, material_code')->get('m_material')->result();  
    }
}
