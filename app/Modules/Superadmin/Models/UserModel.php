<?php
namespace App\Modules\superadmin\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'user_login'; // Your table name
    protected $primaryKey = 'id'; // Your primary key field name
    protected $allowedFields = ['name', 'user_name', 'password', 'role', 'status', 'date_created']; // Fields that can be mass-assigned
}
