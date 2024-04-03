<?php
namespace App\Modules\Client\Controllers; 
use App\Controllers\BaseController; 
class ClientController extends BaseController 
{ 
public function index(): string 
{ 
return view('\App\Modules\Client\Views\welcome_message'); 
} 
}