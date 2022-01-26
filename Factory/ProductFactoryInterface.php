<?php

declare(strict_types=1);

namespace scandiweb\Factory;

interface ProductFactoryInterface
{
    public static function createProduct(array $data): ProductInterface;

}