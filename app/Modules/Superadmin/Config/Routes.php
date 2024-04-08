<?php
$routes->group("superadmin", ["namespace" => "App\Modules\superadmin\Controllers"], function ($routes) {
    $routes->get("/", "superadminController::login");
    $routes->get("login", "superadminController::login");
    $routes->get("dashboard", "superadminController::dashboard");
    $routes->get("createuser", "superadminController::createUser");
    $routes->get("otaupdate", "superadminController::otaUpdate");
    $routes->get("getUsers", "superadminController::getUsers");
    $routes->get("getClient", "superadminController::getClient");
    $routes->get("logout", "superadminController::logout");
    $routes->get("createdevice", "superadminController::createDevice");
    $routes->get("getDevices", "superadminController::getDevices");
    $routes->get("getClientId", "superadminController::getClientId");
    $routes->get("getDevicesByClientId", "superadminController::getDevicesByClientId");
    $routes->get("getDeviceDetails", "superadminController::getDeviceDetails");
    $routes->get("getOtaDevices", "superadminController::getOtaDevices");


    $routes->post("loginAuth", "superadminController::loginAuth");
    $routes->post('adduser', 'superadminController::addUser');
    $routes->post('addclient', 'superadminController::addClient');
    $routes->post("createSchemaAndTables", "superadminController::createSchemaAndTables");
    $routes->post("addDevice", "superadminController::addDevice");
    $routes->post("updateUser", "superadminController::updateUser");
    $routes->post("updateClient", "superadminController::updateClient");
    $routes->post("addupdate", "superadminController::addupdate");

});
?>
