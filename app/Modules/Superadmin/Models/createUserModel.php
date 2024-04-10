<?php

namespace App\Modules\superadmin\Models;

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
            'can_adjust' => $data['can_adjust'],
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
    
        // Subquery to aggregate role details for each user
        $roleSubquery = $this->db->table('master.user_role')
            ->select('user_id, STRING_AGG(role_details::text, \', \') AS role_details')
            ->groupBy('user_id')
            ->getCompiledSelect();
    
        // Subquery to aggregate device IDs for each user
        $deviceSubquery = $this->db->table('master.device_details')
            ->select('user_id, STRING_AGG(device_id::text, \', \') AS device_ids')
            ->groupBy('user_id')
            ->getCompiledSelect();
    
        // Main query to join user_login, role details, client details, and device IDs
        $query = $this->db->table('master.user_login')
            ->select('user_login.id, user_login.*, role_agg.role_details, client_details.client_name, device_agg.device_ids');
    
        // Join with role details subquery
        $query->join("($roleSubquery) as role_agg", 'role_agg.user_id = user_login.id', 'left');
    
        // Join with client details
        $query->join('master.client_details', 'master.client_details.id = user_login.client_id', 'left');
    
        // Join with device IDs subquery
        $query->join("($deviceSubquery) as device_agg", 'device_agg.user_id = user_login.id', 'left');
    
        // Join with device names using master.device table
        $query->join('master.device', 'master.device.id = ANY(string_to_array(device_agg.device_ids, \',\')::int[])', 'left');
    
        // Select device names
        $query->select("ARRAY_TO_STRING(ARRAY_AGG(master.device.device_name), ', ') AS device_names");
    
        // Group by necessary columns
        $query->groupBy('user_login.id, user_login.*, role_agg.role_details, client_details.client_name, device_agg.device_ids');
    
        // Execute the query and return results
        return $query->get()->getResult();
        
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
