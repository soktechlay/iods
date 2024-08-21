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
require_once 'src/controllers/Usercontroller.php';

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

switch ($uri) {
    case $base_url . '/':
    case $base_url . '/login';
        $controller = new Authcontroller();
        $controller->login();
        break;
    case $base_url . '/logout':
        session_destroy();
        header("Location: $base_url/login");
        exit();
    case $base_url . '/register-user';
        $controller = new Authcontroller();
        $controller->create();
        break;
    case $base_url . '/register';
        $controller = new Authcontroller();
        $controller->register();
        break;
    case $base_url . '/dashboard';
        $controller = new Dashboard();
        $controller->dashboard();
        break;
        case $base_url . '/createuser';
        $controller = new Usercontroller();
        $controller->createuser();
        break;
    default:
        // You can add a default case or handle 404 not found here
        header("HTTP/1.0 404 Not Found");
        echo "Page not found";
        break;
}
