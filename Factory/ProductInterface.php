<?php

declare(strict_types=1);

namespace scandiweb\Factory;

interface ProductInterface
{
    public function  validateInputs();
    public function  insertIntoDb();
    public function  getErrors();
    public function  printErrors();
    public function  printProduct();

}