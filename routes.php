<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define your base URL
$base_url = '/iods';

// Include necessary controllers
require_once 'src/controllers/Authcontroller.php';
require_once 'src/controllers/Usercontroller.php';
require_once 'src/controllers/Dashboard.php';
require_once 'src/controllers/Documentcontroller.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case $base_url . '/':
    case $base_url . '/login';
        $controller = new Authcontroller();
        $controller->login();
        break;

    case $base_url . '/logout':
        // Create an instance of the controller and call the logout method
        $controller = new AuthController();
        $controller->logout();
        break;

    case $base_url . '/dashboard';
        $controller = new Dashboard();
        $controller->dashboard();
        break;
    case $base_url . '/User';
        $controller = new Usercontroller();
        $controller->alluser();
        break;
    case $base_url . '/iniaudocument';
        $controller = new Documentcontroller();
        $controller->iniaudocument();
        break;
    case $base_url . '/outiaudocument';
        $controller = new Documentcontroller();
        $controller->outiaudocument();
        break;
    case $base_url . '/createdocumentin';
        $controller = new Documentcontroller();
        $controller->createdocumentin();
        break;
    case $base_url . '/senddocument';
        $controller = new Documentcontroller();
        $controller->uploadDocument();
        break;
    case $base_url . '/exportData';
        $controller = new Documentcontroller();
        $controller->export();
        break;
    default:
        // You can add a default case or handle 404 not found here
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
        break;
}
