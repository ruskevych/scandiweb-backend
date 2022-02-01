<?php

namespace scandiweb\Factory;

class ProductHelper
{
        $typeValues = ['DVD' => 'scandiweb\Factory\DiskProductFactory', 
                       'Book' => 'scandiweb\Factory\BookProductFactory', 
                       'Furniture' => 'scandiweb\Factory\FurnitureProductFactory'];

        $productFactory = $typeValues[$type];
        return new $productFactory();


}
