<?php

namespace App\Modules\Client\Models;

use CodeIgniter\Model;

class clientLoginModel extends Model
{
    protected $table = 'master.user_login';
    public function authenticate($username, $password)
    {
        // Fetch user data from database
        $user = $this->where('user_name', $username)->first();

        if ($user) {
            // Compare the MD5 hashed password with the entered password
            if (md5($password) === $user['password']) {
                // Authentication successful
                return $user;
            }
        }
        return false;
    }

    public function getUserData($userId) {
        // Fetch required data from user_login, user_role, device_details, device, and client_details tables based on user_id
        $userData = $this->select('master.user_login.client_id, client_details.client_name, array_agg(device.id) as device_ids, array_agg(device.device_name) as device_names, master.user_login.name, user_role.role_details, master.user_login.status, master.user_login.id as user_id')
            ->join('master.user_role', 'master.user_login.id = master.user_role.user_id')
            ->join('master.device_details', 'master.user_login.id = master.device_details.user_id')
            ->join('master.device', 'master.device_details.device_id = master.device.id') // Join the device table
            ->join('master.client_details', 'master.user_login.client_id = master.client_details.id')
            ->where('master.user_login.id', $userId)
            ->groupBy('master.user_login.client_id, client_details.client_name, master.user_login.name, user_role.role_details, master.user_login.status, master.user_login.id')
            ->findAll();

        return $userData;
    }
}
