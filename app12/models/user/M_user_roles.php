 <?php

if (!defined('BASEPATH'))
    exit('Anda tidak masuk dengan benar');

class M_user_roles extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->db = $this->load->database('default', true);
    }

    public function show($where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        $data = $this->db->from('m_user_roles')->order_by('CREATE_TIME DESC')->get();
        return $data->result();
    }

    public function get_parent($roles)
    {
        $qry=$this->db->query("SELECT distinct PARENT
                          FROM m_menu where
                          ID_MENU in (".$roles.") AND
                          PARENT != '0'" );
        return $qry;
    }
    public function get_parentTask($roles)
    {
        $qry=$this->db->query("SELECT distinct parent
                          FROM m_menu_task where
                          id in (".$roles.") AND
                          parent != '0'" );
        return $qry;
    }

    public function add($data) {
        $data = $this->db->insert('m_user_roles', $data);
//        echo $this->db->last_query();exit;
        return $data;
    }

    public function update($id, $data) {
        return $this->db->where('ID_USER_ROLES', $id)->update('m_user_roles', $data);
    }

    public function get_usermenu() {
        $query = $this->db->from("m_menu")
                ->where('STATUS = 1')
                ->order_by('PARENT', 'ASC')
                ->get();
        return $query->result();
    }

    public function get_child($dt) {
        $query = $this->db->from("m_menu")
                ->where('PARENT = ', $dt)
                ->where('STATUS = 1')
                ->get();
        return $query->result();
    }

}

?>
