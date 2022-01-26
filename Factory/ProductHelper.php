<?php

namespace scandiweb\Factory;

class ProductHelper
{
    public static function getProductFactory(string $type): ProductFactoryInterface
    {
        switch($type){
            case 'DVD' : {
                return new DiskProductFactory();
            }
            case 'Book' : {
                return new BookProductFactory();
            }
            case 'Furniture' : {
                return new FurnitureProductFactory();
            }
            default: {
                die (json_encode(array(
                    'field' => 'type',
                    'error' => 'is required in format Book | DVD | Furniture'
                )));
            }
        }
    }
}