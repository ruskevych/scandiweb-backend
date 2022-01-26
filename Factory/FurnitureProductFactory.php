<?php

namespace scandiweb\Factory;

class FurnitureProductFactory implements ProductFactoryInterface
{

    public static function createProduct(array $data): ProductInterface
    {
        return new FurnitureProduct($data);
    }
}