<?php

namespace App\Modules\superadmin\Models;

use CodeIgniter\Model;

class CreateDeviceModel extends Model
{
    protected $table = 'master.device'; // Assuming the table is under the master schema
    protected $primaryKey = 'id';
    protected $allowedFields = ['log_time', 'device_name', 'mac_id', 'status','client_id'];
}
