<?php
$routes->group("iot", ["namespace" => "App\Modules\IoT\Controllers"], function ($routes) {
    $routes->get("/", "IotDeviceController::index");
    $routes->get("startLog", "IotDeviceController::startLog");
    $routes->get("endLog", "IotDeviceController::endLog");
    $routes->get("oldLog", "IotDeviceController::oldLog");
    $routes->get("check_ota", "IotDeviceController::checkOTA");
    $routes->get("fetch_ota", "IotDeviceController::fetchOTA");
});
