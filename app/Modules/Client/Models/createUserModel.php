<?php

namespace App\Modules\Client\Models;

use CodeIgniter\Model;

class createUserModel extends Model
{
    protected $table = 'master.user_login';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'user_name', 'password', 'status', 'date_created', 'updated_on', 'client_id', 'c_admin_id', 'c_user_id'];

    public function addRole($data)
    {
        $roleData = [
            'can_view' => $data['can_view'],
            'can_create' => $data['can_create'],
            'can_delete' => $data['can_delete'],
            'can_edit' => $data['can_edit'],
        ];

        // Insert role data into the role_list table
        $roleInsertResult = $this->db->table('master.role_list')->insert($roleData);

        if ($roleInsertResult === false) {
            return false;
        }
        $roleId = $this->db->insertID();
        return $roleId;

    }

    public function getUsersWithRoleDetails($clientId)
    {
        return $this->db->table('master.user_login')
        ->select('user_login.*, roles.role_details AS role_details, devices.device_ids AS device_ids, devices.device_names AS device_names')
        ->join('(SELECT user_id, STRING_AGG(user_role.role_details::text, \', \') AS role_details FROM master.user_role GROUP BY user_id) AS roles', 'roles.user_id = user_login.id', 'left')
        ->join('(SELECT user_id, ARRAY_AGG(device_details.device_id) AS device_ids, ARRAY_AGG(device.device_name) AS device_names FROM master.device_details JOIN master.device ON device_details.device_id = device.id GROUP BY user_id) AS devices', 'devices.user_id = user_login.id', 'left')
        ->where('user_login.client_id', $clientId) // Add condition to filter by client_id
        ->groupBy('user_login.id, roles.role_details, devices.device_ids, devices.device_names') // Include role_details, device_ids, and device_names in the GROUP BY clause
        ->get()
        ->getResult();
    }

}
