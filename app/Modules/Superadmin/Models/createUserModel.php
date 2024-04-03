<?php

namespace App\Modules\SuperAdmin\Models;

use CodeIgniter\Model;

class CreateUserModel extends Model
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
    public function getUsersWithRoleDetails()
    {
        return $this->db->table('master.user_login')
            ->select('user_login.*, STRING_AGG(user_role.role_details::text, \', \') AS role_details')
            ->join('master.user_role', 'user_role.user_id = user_login.id', 'left')
            ->groupBy('user_login.id')
            ->get()
            ->getResult();
    }

    public function updateUserRole($userId, $data)
    {
        try {
            $this->db->table('master.user_role')
                ->where('user_id', $userId)
                ->update($data);
    
            // Update status in client_details table
            $this->db->table('master.user_login')
                ->where('id', $userId)
                ->update(['status' => $data['status']]);
    
            // Log the success message
            log_message('debug', 'Client data updated successfully.');
            return true;
        } catch (\Exception $e) {
            log_message('error', $e->getMessage()); // Log any errors
            return false;
        }
    }

}
