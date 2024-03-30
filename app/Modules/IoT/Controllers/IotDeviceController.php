<?php
namespace App\Modules\Iot\Controllers;
use App\Controllers\BaseController;
use CodeIgniter\Exceptions\HTTPExceptionInterface;

class IotDeviceController extends BaseController {
    public function index(): string  {
        return view('\App\Modules\Iot\Views\welcome_message');
    }

    public function startLog() {
        if ( !$_GET ) {
            $this->response->setStatusCode(400);
            return;
        }
        
        $arrayData = $_GET;
        print_r($_GET);
    }
}
