<?php
$routes->group("client", ["namespace" => "App\Modules\Client\Controllers"], function ($routes) {
    $routes->get("/", "ClientController::index"); 
    $routes->get("dashboard", "DashboardController::dashboard");
    $routes->get("dashboard/login", "DashboardController::login");
    $routes->get("dashboard/settings", "DashboardController::settings");
});
?>
