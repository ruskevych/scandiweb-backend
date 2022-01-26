<?php

namespace scandiweb\Factory;

class DiskProductFactory implements ProductFactoryInterface
{


    public static function createProduct(array $data): ProductInterface
    {
        return new DiskProduct($data);
    }
}