<?php

namespace App\Modules\SuperAdmin\Models;

use CodeIgniter\Model;

class AdminLoginModel extends Model
{
    protected $table = 'user_login';
    protected $primaryKey = 'id'; 
    protected $allowedFields = ['name', 'username', 'password', 'status','client_id','c_admin_id','c_user_id','updated_on','created_on']; 

    public function authenticate($username, $password)
    {
        // Fetch user data from database
        $user = $this->where('username', $username)->first();
        
        if ($user) {
            // Compare the MD5 hashed password with the entered password
            if (md5($password) === $user['password']) {
                // Authentication successful
                return $user;
            }
        }
        return false;
    }
}
