<?php
$routes->group("client", ["namespace" => "App\Modules\Client\Controllers"], function ($routes) {
    $routes->get("/", "ClientController::index");
    $routes->get("dashboard", "DashboardController::dashboard");
    $routes->get("login", "DashboardController::login");
    $routes->get("logout", "DashboardController::logout");
    $routes->get("dashboard/settings", "DashboardController::settings");
    $routes->get("getUser", "DashboardController::getUser");
    $routes->get("getSelectedUserData", "DashboardController::getSelectedUserData");
    $routes->get("getAllDeviceData", "DashboardController::getAllDeviceData");
    $routes->post("loginAuth", "DashboardController::loginAuth");
});
