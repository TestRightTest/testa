<?php 
$routes->group("iot", ["namespace" => "App\Modules\IotDevice\Controllers"], function ($routes) { 
$routes->get("/", "IotDeviceController::index"); 
}); 
?>