<?php
$routes->group("superAdmin", ["namespace" => "App\Modules\SuperAdmin\Controllers"], function ($routes) {
    $routes->get("/", "SuperAdminController::login");
    $routes->get("login", "SuperAdminController::login");
    $routes->post("loginAuth", "SuperAdminController::loginAuth");
    $routes->get("dashboard", "SuperAdminController::dashboard");
    $routes->post('adduser', 'SuperAdminController::addUser');
    $routes->post('addclient', 'SuperAdminController::addClient');
    $routes->get("createuser", "SuperAdminController::createUser");
    $routes->get("otaupdate", "SuperAdminController::otaUpdate");
    $routes->get("getUsers", "SuperAdminController::getUsers");
    $routes->get("getClient", "SuperAdminController::getClient");
    $routes->post('updateClient', 'SuperAdminController::updateClient');
    $routes->post("createSchemaAndTables", "SuperAdminController::createSchemaAndTables");
    $routes->get("logout", "SuperAdminController::logout");
    $routes->get("createdevice", "SuperAdminController::createDevice");
    $routes->post("addDevice", "SuperAdminController::addDevice");
    $routes->get("getDevices", "SuperAdminController::getDevices");
    $routes->get("getClientId", "SuperAdminController::getClientId");
    $routes->post("updateUserRole", "SuperAdminController::updateUserRole");

});
?>
