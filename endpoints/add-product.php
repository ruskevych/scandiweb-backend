<?php

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");

use scandiweb\Factory\ProductHelper;

$inputs = json_decode(file_get_contents("php://input"), true);


$product = ProductHelper::getProductFactory($inputs['type'])->createProduct($inputs);


$product->validateInputs();
if(!empty($product->getErrors())){
    http_response_code(200);
    $product->printErrors();
}
else{
    $product->insertIntoDb();
    http_response_code(201);
    echo (json_encode(array(
        "message" => "product created"
    )));

}