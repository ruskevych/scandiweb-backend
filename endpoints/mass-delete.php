<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

use scandiweb\Factory\ProductList;

$inputs = json_decode(file_get_contents("php://input"), true);

$pl = new ProductList();
$pl->massDelete($inputs);