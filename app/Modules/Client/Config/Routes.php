<?php
$routes->group("client", ["namespace" => "App\Modules\Client\Controllers"], function ($routes) {
    $routes->get("/", "ClientController::index"); 
    $routes->get("dashboard", "DashboardController::dashboard");
    $routes->get("login", "DashboardController::login");
    $routes->get("logout", "DashboardController::logout");
    $routes->get("dashboard/settings", "DashboardController::settings");
    $routes->post("loginAuth", "DashboardController::loginAuth");

});
?>
