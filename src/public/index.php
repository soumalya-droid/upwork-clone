<?php

require_once '../controllers/HomeController.php';
require_once '../controllers/AuthController.php';
require_once '../controllers/CampaignController.php';
require_once '../controllers/BidController.php';

// Get the request URI.
$request_uri = $_SERVER['REQUEST_URI'];
$request_path = strtok($request_uri, '?');

$homeController = new HomeController();
$authController = new AuthController();
$campaignController = new CampaignController();
$bidController = new BidController();

// Simple routing logic
switch (true) {
    case $request_path === '/':
        $homeController->index();
        break;
    case $request_path === '/login':
        $authController->login();
        break;
    case $request_path === '/register':
        $authController->register();
        break;
    case $request_path === '/campaigns':
        $campaignController->index();
        break;
    case $request_path === '/campaigns/create':
        $campaignController->create();
        break;
    case preg_match('/\/campaigns\/(\d+)\/bids/', $request_path, $matches):
        $campaignId = $matches[1];
        $bidController->index($campaignId);
        break;
    case $request_path === '/bids/create':
        $bidController->create();
        break;
    default:
        http_response_code(404);
        echo '404 Not Found';
        break;
}
