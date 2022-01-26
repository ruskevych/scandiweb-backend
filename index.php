<?php



require_once 'autoload.php';


use scandiweb\Factory\Router;


$rt = new Router();
$rt->get('/products', 'endpoints/product-list.php');
$rt->get('/', 'endpoints/product-list.php');
$rt->post('/products/add', 'endpoints/add-product.php');
$rt->post('/products/mass-delete', 'endpoints/mass-delete.php');

$rt->run();