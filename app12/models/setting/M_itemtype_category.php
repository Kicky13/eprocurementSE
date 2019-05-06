<?php if (!defined('BASEPATH')) exit('Anda tidak masuk dengan benar');

class M_itemtype_category extends MY_Model {
	protected $table = 'm_itemtype_category';

    public function __construct() {
        parent::__construct();
    }

    public function byParentCategory()
    {
        $result = array();
        foreach($this->allActive() as $category) {
            $result[$category->itemtype][] = $category;
        }

        return $result;
    }
}
