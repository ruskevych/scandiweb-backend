<?php

namespace scandiweb\Factory;

class FurnitureProduct implements ProductInterface
{
    /**
     * @var array $inputs
     */
    private array $inputs;

    /**
     * @var array
     */
    private array $errors;


    public function __construct($inputs)
    {
        if (!isset($inputs['height']) || !isset($inputs['width']) || !isset($inputs['length'])){
            die(json_encode(array(
                'error'=> 'height, width and length are required for Furniture product'
            )));
        }
        else{
            $this->inputs = $inputs;
        }
    }

    /**
     * @return void
     */
    public function validateInputs()
    {
        $Validator = new Validation();

        $skuErrors = $Validator->name('sku')->value($this->inputs['sku'])->unique()->required()->getErrors();
        if(!empty($skuErrors)) $this->errors['sku'] = $skuErrors;

        $nameErrors = $Validator->name('name')->value($this->inputs['name'])->required()->getErrors();
        if(!empty($nameErrors)) $this->errors['name'] = $nameErrors;

        $priceErrors = $Validator->name('price')->value($this->inputs['price'])->required()->isNumber()->getErrors();
        if(!empty($priceErrors)) $this->errors['price'] = $priceErrors;

        $typeErrors = $Validator->name('type')->value($this->inputs['type'])->required()->getErrors();
        if(!empty($typeErrors)) $this->errors['type'] = $typeErrors;

        $heightErrors = $Validator->name('height')->value($this->inputs['height'])->required()->isNumber()->getErrors();
        if(!empty($heigthErrors)) $this->errors['height'] = $heightErrors;

        $widthErrors = $Validator->name('width')->value($this->inputs['width'])->required()->isNumber()->getErrors();
        if(!empty($widthErrors)) $this->errors['width'] = $widthErrors;

        $lengthErrors = $Validator->name('length')->value($this->inputs['length'])->required()->isNumber()->getErrors();
        if(!empty($lengthErrors)) $this->errors['length'] = $lengthErrors;



    }

    /**
     * @return void
     */
    public function printProduct()
    {
        $element = array(
            'sku' => $this->inputs["sku"],
            'name' => $this->inputs["name"],
            'price' => $this->inputs["price"],
            'type' => $this->inputs["type"],
            'attribute' => $this->inputs["height"] ."x" . $this->inputs["width"] . "x" . $this->inputs["length"]
        );
        echo json_encode($element, JSON_PRETTY_PRINT);

    }

    /**
     * @return array
     */
    public function getErrors():array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function insertIntoDb():bool
    {
        if(empty($this->errors)){
            $db = (new DBMan())->get();
            $query = new QueryBuilder("insert");
            $query->setTable(PRODUCTS_TABLE);

            $query->addColumn("sku");
            $query->addValue($this->inputs['sku']);

            $query->addColumn("name");
            $query->addValue($this->inputs['name']);


            $query->addColumn("price");
            $query->addValue($this->inputs['price']);

            $query->addColumn("type");
            $query->addValue($this->inputs['type']);

            $query->addColumn("attribute");
            $query->addValue($this->inputs["height"] ."x" . $this->inputs["width"] . "x" . $this->inputs["length"]);

            return $db->query($query->buildQuery());
        }

        else
            return false;
    }

    /**
     * @return void
     */
    public function printErrors()
    {
        $arrayKeys = array_keys($this->errors);
        $lastArrayKey = array_pop($arrayKeys);

        echo "[";
        foreach($this->errors as $key => $error){
            echo json_encode($error, JSON_PRETTY_PRINT);
            if($key !== $lastArrayKey)
                echo ",";
        }
        echo "]";
    }


}