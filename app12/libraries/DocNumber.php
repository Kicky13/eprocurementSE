<?php

class DocNumber {
    protected $docType;
    protected $company;
    protected $year;
    protected $sequence;
    protected $separator = '-';

    // TODO: should be done in config
    protected $methodLastDocNumber = 'getLastDocNumber';
    protected $methodIsDocNumberExists = 'isDocNumberExists';
    protected $model;
    protected $checkedModel;

    private $docTypeCode = array(
        'MSR'    => 'OR',
        'ED'     => 'OQ',
        'PO'     => 'OP',
        'SO'     => 'OS'
    );

    private $getter = [ 'docType', 'company', 'year', 'sequence' ];

    public function __get($property)
    {
        if (in_array($property, $this->getter)) {
            return $this->$property;
        }
    }

    public function for($docType, $company, $year = null)
    {
        $this->docType = $this->getDocTypeCode($docType);
        $this->company = $company;
        $this->year = $year ? DateTime::createFromFormat('y', $year)->format('Y') : date('Y');
    }

    public static function generate($doctype, $company)
    {
        $docnumber = new DocNumber;
        $docnumber->for($doctype, $company);

        return $docnumber->getNumber();
    }

    public static function createFrom($document_number, $docTypeTo = null)
    {
        $docnumber = new DocNumber;
        $origin = $docnumber->parse($document_number);
        $doc_type_code = $docnumber->getDocTypeCode($docTypeTo);

        return $docnumber->format($origin['year'], $origin['sequence'], $doc_type_code, $origin['company']);
    }

    public static function sFormat($year, $sequenct, $doctype, $company)
    {
        return (new static)->format($year, $sequenct, $doctype, $company);
    }

    public function guessDocTypeCode($document_number)
    {
        return substr($document_number, strpos($document_number, $this->separator), 2);
    }

    public function getDocTypeCode($docType)
    {
        $docType = strtoupper($docType);

        return array_key_exists($docType, $this->docTypeCode) ? $this->docTypeCode[$docType] : '';
    }

    protected function getNumber()
    {
        try {
            // be lazy
            $this->initiateModel();
            $available_number = $this->getAvailableNumber();
        } catch(RuntimeException $e) {
            // compatibity reason with prior version
            throw new RuntimeException($e->getMessage());
        }

        $this->sequence = $available_number;

        return $this->format($this->year, $this->sequence, $this->docType, $this->company);
    }

    protected function format($year, $sequence, $doctype, $company) 
    {
        // example format XXZZZZZZ-OR-YYYYY
        return sprintf('%02d%06d%s%s%s%05s', substr($year, -2), $sequence, $this->separator,
            strtoupper($doctype), $this->separator, $company);
    }

    protected function parse($number)
    {
        @list($year_seq, $doctype, $company) = explode('-', $number);
        $year = substr($year_seq, 0, 2);
        if ($year) {
            $year = DateTime::createFromFormat('y', $year)->format('Y');
        } else {
            $year = date('Y');
        }

        $sequence = substr($year_seq, 2, strlen($year_seq));
        if (!$sequence)
            $sequence = 0;

        return compact('year', 'sequence', 'doctype', 'company');
    }

    protected function getAvailableNumber($last_num = null)
    {
        if (!$last_num) {
            $last_num = $this->model->{$this->methodLastDocNumber}($this->year, $this->company);
        }

        $last_num = $this->parse($last_num);

        $new_sequence = $last_num['sequence'] + 1;

        // Cross check to other model
        // if exists, increment number and check again
        // repeat!
        $new_num = $this->format($last_num['year'], $new_sequence, $last_num['doctype'], $last_num['company']);

        // be elegant, please! Move somewhere else
        $doctype = [];
        if ($last_num['doctype'] == 'OP' or $last_num['doctype'] == 'OS') {
            $doctype = 'OR';
        } elseif ($last_num['doctype'] == 'OR') {
            $doctype = 'OP'; 
        }
        // end move

        if ($doctype) {
            $foreign_num = $this->format($last_num['year'], $new_sequence, $doctype, $last_num['company']);

            if ($this->checkedModel->{$this->methodIsDocNumberExists}($foreign_num, $this->year, $this->company)) {
                return $this->getAvailableNumber($new_num);
            } 
        }

        if ($this->model->{$this->methodIsDocNumberExists}($new_num, $this->year, $this->company)) {
            return $this->getAvailableNumber($new_num);
        } 

        return $new_sequence;
    }

    protected function getMaxModel()
    {
        switch ($this->docType) {
        case 'OR':
            return 'procurement/M_msr';
        case 'OQ':
            return true;
            return 'procurement/M_bl';
        case 'OP':
            return 'procurement/M_purchase_order';
        case 'OS':
            return 'procurement/M_service_order';
        default:
            return false;
        }
    }

    protected function getCheckedModel()
    {
        switch ($this->docType) {
        case 'OR':
            return 'procurement/M_purchase_order';
        case 'OQ':
            return true;
            return 'procurement/M_bl';
        case 'OP':
        case 'OS':
            return 'procurement/M_msr';
        // case 'OS':
        //     return 'procurement/M_purchase_order_service';
        default:
            return false;
        }

    }

    protected function foreignDocType($doctype)
    {
        switch($doc_type) {
        case 'OP':
        case 'OS':
            return 'OR';
        case 'OR':
            return 'OP'; // assume OP & OS are identical
        default:
            return $doctype;
        }
    }

    protected function initiateModel()
    {
        $ci =& get_instance();

        foreach([
            'model' => $this->getMaxModel(),
            'checkedModel' => $this->getCheckedModel()
        ] as $obj_name => $model) {
            if (!is_string($model) || strlen(trim($model)) == 0) {
                continue;
            }

            $_model_path = explode('/', $model);
            $model_name = end($_model_path);

            try {
                $ci->load->model($model, $model_name);
            } catch(RuntimeException $e) {
                // In case model does not exists
                throw new RuntimeException('Cannot get related model');
                // return false;
            }

            if (! property_exists($ci, $model_name)) {
                throw new RuntimeException('Cannot get model object');
                // return false;
            }

            if (! method_exists($ci->{$model_name}, $this->methodLastDocNumber)) {
                throw new RuntimeException('Cannot find method');
                // return false;
            }

            $this->$obj_name = $ci->{$model_name};
        }
    }
}
