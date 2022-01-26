<?php

namespace scandiweb\Factory;

class BookProductFactory implements ProductFactoryInterface
{

    public static function createProduct(array $data): ProductInterface
    {
        return new BookProduct($data);
    }
}