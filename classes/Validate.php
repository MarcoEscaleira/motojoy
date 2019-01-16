<?php
/**
 * Class Validate
 */
class Validate
{
    private $_passed = false;
    private $_errors = array();
    private $_db = null;

    public function __construct() {
        $this->_db = Db::getInstance();
    }

    public function check($type, $items = array()) {
        foreach ($items as $item => $rules) {
            if (isset($rules['show'])) {
                $itemName=$rules['show'];
            }
            foreach ($rules as $rule => $rule_value) {
                $value = trim($type[$item]);
                $item = escape($item);
                if ($rule === 'required' && empty($value)) {
                    $this->addError($itemName." tem de ser preenchido");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError($itemName." tem de conter um minímo de ".$rule_value);
                            }
                            break;

                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError($itemName." tem de conter um máximo de ".$rule_value);
                            }
                            break;

                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if ($check->count()) {
                                $this->addError($itemName." já existe!");
                            }
                            break;

                        case 'matches':
                            if ($value != $type[$rule_value]) {
                                $this->addError($itemName." tem que coicidir a Password");
                            }
                            break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }

        return $this;
    }

    private function addError($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }
}
