<?php

namespace App\Modules\Client\Models;

use CodeIgniter\Model;

class DeviceParametersModel extends Model
{
    protected $table;
    protected $primaryKey = 'id';
    protected $allowedFields = ['progress_threshold', 'rotation_interval', 'rotation_enable', 'temperature'];

    public function __construct()
    {
        parent::__construct();
    }

    // Method to set the table dynamically based on the client ID
    public function setTable($clientId)
    {
        $this->table = 'client_' . $clientId . '.device_parameter';
        return $this;
    }
}
