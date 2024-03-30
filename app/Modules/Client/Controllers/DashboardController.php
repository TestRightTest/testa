<?php
namespace App\Modules\Client\Controllers; 
use App\Controllers\BaseController; 
class DashboardController extends BaseController 
{ 
public function index(): string 
{ 
return view('\App\Modules\Client\Views\welcome_message'); 
} 
public function dashboard(): string 
{ 
return view('\App\Modules\Client\Views\dashboard'); 
} 
public function login(): string 
{ 
return view('\App\Modules\Client\Views\login'); 
} 
public function settings(): string 
{ 
return view('\App\Modules\Client\Views\settings'); 
} 
}