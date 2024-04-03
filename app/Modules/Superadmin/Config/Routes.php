<?php
$routes->group("superAdmin", ["namespace" => "App\Modules\SuperAdmin\Controllers"], function ($routes) {
    $routes->get("/", "SuperAdminController::login");
    $routes->get("login", "SuperAdminController::login");
    $routes->get("dashboard", "SuperAdminController::dashboard");
    $routes->get("createuser", "SuperAdminController::createUser");
    $routes->get("otaupdate", "SuperAdminController::otaUpdate");
    $routes->get("getUsers", "SuperAdminController::getUsers");
    $routes->get("getClient", "SuperAdminController::getClient");
    $routes->get("logout", "SuperAdminController::logout");
    $routes->get("createdevice", "SuperAdminController::createDevice");
    $routes->get("getDevices", "SuperAdminController::getDevices");
    $routes->get("getClientId", "SuperAdminController::getClientId");
    $routes->get("getDevicesByClientId", "SuperAdminController::getDevicesByClientId");


    $routes->post("loginAuth", "SuperAdminController::loginAuth");
    $routes->post('adduser', 'SuperAdminController::addUser');
    $routes->post('addclient', 'SuperAdminController::addClient');
    $routes->post("createSchemaAndTables", "SuperAdminController::createSchemaAndTables");
    $routes->post("addDevice", "SuperAdminController::addDevice");
    $routes->post("updateUser", "SuperAdminController::updateUser");
    $routes->post("updateClient", "SuperAdminController::updateClient");

});
?>
