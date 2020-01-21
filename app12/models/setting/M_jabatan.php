<?php defined('BASEPATH') or exit('No direct script access allowed');

class M_jabatan extends MY_Model
{
    protected $table = 't_jabatan';

    public function __construct()
    {
        parent::__construct();
    }

    public function findByUser($user_id)
    {
        return $this->db->where('user_id', $user_id)
            ->get($this->table)
            ->first_row();
    }

    public function getPrimarySecondaryUserByUserId($user_id)
    {
        $user = $this->findByUser($user_id);

        // only works for user primary & secondary
        if (!in_array(@$user->user_role, [2,3])) {
            return [];
        }
        /*
        * skema kalaou apapun yang di save draft, boleh di edit oleh tim dalam satu user manager yang sama
        * originalnya t_jabatan_primary tidak ada hanya secondary saja
        * skema ini juga menghiraukan yang create primary atau secondary semua bisa melihat dan mengubah, bedanya kalau secondary hanya save draft saja
        */
		if(@$user->user_role == t_jabatan_user_secondary or @$user->user_role == t_jabatan_user_primary)
        {
			return $this->db->where('parent_id', $user->parent_id)->or_where('user_id', $user->parent_id)->get($this->table)->result();
        }

        /*bawah ini exit karena diatas sudah pasti return karena scrip ini adalah script lama yang membedaan primary dan secondary*/
        if(@$user->user_role == t_jabatan_user_primary)
        {
			return $this->db->where('user_id', $user_id)->or_where('parent_id', @$user->id)->get($this->table)->result();
        }
        return [];

        /*return $this->db->where('parent_id', $user->parent_id)
            ->get($this->table)->result();*/

    }

    public function getPrimaryUserByUserId($user_id)
    {
        $user = $this->findByUser($user_id);

        if ($user->user_role == t_jabatan_user_primary) {
            return $user;
        }
        elseif ($user->user_role == t_jabatan_user_secondary) {
            return $this->db->where('id', $user->parent_id)->from($this->table)
                ->get()->first_row();
        }
        elseif ($user->user_role == '1') { // approver
            return $this->db->where('parent_id', $user->id)->from($this->table)
                ->get()->first_row();
        }

        return null;
    }

    public function findParentJabatan($jabatan, $depth = 100)
    {
        static $result;
        static $deep;

        $parent_jabatan = @$this->db->where('id', $jabatan->parent_id)->get('t_jabatan')->result()[0];
        $deep++;

        if ($parent_jabatan->parent_id && $parent_jabatan->parent_id != 0 && $deep < $depth) {
            $this->findParentJabatan($parent_jabatan, $depth);
        }

        $result[] = $parent_jabatan;
        return $result;
    }
}
