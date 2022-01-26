<?php

namespace scandiweb\Factory;
require_once 'autoload.php';

class Validation
{

    public $errors =array();
    public $patterns = array(
        'float' => '[0-9\.,]+',
    );

    /**
     * @param $name
     * @return $this
     */
    public function name($name){
        $this->name = $name;
        return $this;
    }


    /**
     * @param $value
     * @return $this
     */
    public function value($value){
        $this->value = $value;
        return $this;
    }


    /**
     * @return $this
     */
    public function required(){
        if ($this->value == '' || $this->value == null || strlen($this->value)== 0){
            $error = array(
                'field' => $this->name,
                'error' => 'is required'
            );
            $this->errors[] = $error;
        }
        return $this;
    }


    /**
     * @return $this
     */
    public function unique(){
        $db = (new DBMan())->get();
        $qb = new QueryBuilder('select');
        $qb->setTable(PRODUCTS_TABLE);
        $qb->addColumn("sku");
        $qb->setWhere($this->name." = \"".$this->value."\"");
        $result = $db->query($qb->buildQuery());
        if ($result->num_rows > 0){
            $error = array(
                'field' => $this->name,
                'error' => 'already exists'
            );
            $this->errors[] = $error;
        }
        return $this;

    }


    /**
     * @return $this
     */
    public function isNumber(){
        if (!filter_var($this->value, FILTER_VALIDATE_FLOAT)){
            $error = array(
                'field' => $this->name,
                'error' => 'must be a number'
            );
            $this->errors[] = $error;
        }
        return $this;
    }


    /**
     * @param int $minValue
     * @return $this
     */
    public function min($minValue){
        if( is_string($this->value) ){
            if ( strlen($this->value) >= $minValue){
                $error = array(
                    'field' => $this->name,
                    'error' => 'must be above ' . $minValue . ' characters'
                );
                $this->errors[] = $error;
            }
        }
        if( is_numeric($this->value) ){
            if ( $this->value >= $minValue){
                $error = array(
                    'field' => $this->name,
                    'error' => 'must be greater than ' . $minValue
                );
                $this->errors[] = $error;
            }
        }
        return $this;
    }

    /**
     * @param int $maxValue
     * @return $this
     */
    public function max($maxValue){
        if( is_string($this->value) ){
            if ( strlen($this->value) <= $maxValue){
                $error = array(
                    'field' => $this->name,
                    'error' => 'must be under ' . $maxValue . ' characters'
                );
                $this->errors[] = $error;
            }
        }
        if( is_numeric($this->value) ){
            if ( $this->value <= $maxValue){
                $error = array(
                    'field' => $this->name,
                    'error' => 'must be lower than ' . $maxValue
                );
                $this->errors[] = $error;
            }
        }
        return $this;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        $errors = $this->errors;
        $this->errors = array ();
        return $errors;

    }


}