<?php

class M_purchase_order_type extends CI_Model
{
    const TYPE_GOODS = 10; 
    const TYPE_SERVICE = 20; 
    const TYPE_BLANKET = 30; 

    protected $types = array(
        self::TYPE_GOODS    => 'Goods',
        self::TYPE_SERVICE  => 'Service',
        self::TYPE_BLANKET  => 'Blanket',
    );

    protected $mapToMsrType = array(
        self::TYPE_GOODS    => 'MSR01',
        self::TYPE_SERVICE  => 'MSR02',
        self::TYPE_BLANKET  => 'MSRB0', 
    );


    public function getTypes($type = NULL)
    {
        if ($type === NULL) {
            return $this->types; 
        }

        if (array_key_exists($type, $this->types)) {
            return $this->types[$type]; 
        }

        return NULL;
    }

    public function getFromMsrType($type)
    {
        $flipped_type = array_flip($this->mapToMsrType);
        if ($type === NULL) {
            return $flipped_type; 
        }

        if (array_key_exists($type, $flipped_type)) {
            return $flipped_type[$type]; 
        }

        return NULL;
    }
}
