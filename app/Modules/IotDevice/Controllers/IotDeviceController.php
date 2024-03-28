<?php
namespace App\Modules\IotDevice\Controllers; 
use App\Controllers\BaseController; 
class IotDeviceController extends BaseController 
{ 
public function index(): string 
{ 
return view('\App\Modules\IotDevice\Views\welcome_message'); 
} 
}