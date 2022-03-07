<?php
/**
 * Routes for routing between requests
 * use $router object to define the routes
 * get and post
 */

$router->get('/','Controllers\HomeController::Index', true);
$router->get('/cart','Controllers\ShopController::cart', true);
$router->get('/cartcount','Controllers\ShopController::cartCount', true);
$router->get('/checkout','Controllers\ShopController::checkout', true);
$router->get('/account','Controllers\UserController::show', true);
$router->post('/addtocart','Controllers\ShopController::addToCart', true);
$router->post('/updatequantity','Controllers\ShopController::addQuantity', true);
$router->post('/removeitemfromcart','Controllers\ShopController::removeItemFromCart', true);
$router->post('/command','Controllers\ShopController::command', true);
$router->post('/coupon','Controllers\ShopController::coupon', true);

Auth::routes($router);