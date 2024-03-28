<?php
namespace App\Modules\Web\Controllers; 
use App\Controllers\BaseController; 
class PublicController extends BaseController 
{ 
public function index(): string 
{ 
return view('\App\Modules\Web\Views\welcome_message'); 
} 
}