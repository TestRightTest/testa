<?php

namespace App\Modules\SuperAdmin\Models;

use CodeIgniter\Model;

class CreateUserModel extends Model
{
    protected $table = 'master.user_login'; // Specify the schema and table name
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'user_name', 'password', 'status', 'date_created', 'updated_on', 'client_id', 'c_admin_id', 'c_user_id'];

    public function addRole($data)
    {
        // Insert data into the role_list table
        $roleData = [
            'date_created' => date('Y-m-d H:i:s'),
            'role_name' => $data['role_name'],
            'can_view' => $data['can_view'],
            'can_create' => $data['can_create'],
            'can_delete' => $data['can_delete'],
            'can_edit' => $data['can_edit'],
            'status' => $data['status'],
            'updated_on' => date('Y-m-d')
        ];

        return $this->db->table('master.role_list')->insert($roleData);
    }
}