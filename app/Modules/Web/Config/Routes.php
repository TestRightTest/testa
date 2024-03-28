<?php 
$routes->group("web", ["namespace" => "App\Modules\Web\Controllers"], function ($routes) { 
$routes->get("/", "PublicController::index"); 
}); 
?>