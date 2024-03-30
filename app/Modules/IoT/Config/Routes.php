<?php
$routes->group("iot", ["namespace" => "App\Modules\IoT\Controllers"], function ($routes) {
    $routes->get("/", "IotDeviceController::index");
    $routes->get("startLog", "IotDeviceController::startLog");
    $routes->get("endLog", "IotDeviceController::index");
    $routes->get("oldLog", "IotDeviceController::index");
});
?>
