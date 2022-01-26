<?php


header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header("Access-Control-Allow-Headers: X-Requested-With");

use scandiweb\Factory\ProductList;

$pl = new ProductList();
$pl -> printAll();