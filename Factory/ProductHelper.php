<?php

namespace scandiweb\Factory;

class ProductHelper
{
        public static function getProductFactory(string $type): ProductFactoryInterface {
                
                $typeValues = ['DVD' => 'scandiweb\Factory\DiskProductFactory',
                               'Book' => 'scandiweb\Factory\BookProductFactory',
                               'Furniture' => 'scandiweb\Factory\FurnitureProductFactory'];

                $productFactory = $typeValues[$type];
                return new $productFactory();
    
        }


}
