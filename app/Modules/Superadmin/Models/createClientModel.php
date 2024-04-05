<?php

namespace App\Modules\Superadmin\Models;

use CodeIgniter\Model;

class createClientModel extends Model
{
    protected $table = 'master.client_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date_created', 'client_name','status', 'created_by_id'];
    public function clientExists($name)
    {
        return $this->where('client_name', $name)->countAllResults() > 0;
    }

    public function addRole($clientId, $data)
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

        $roleInsert = $this->db->table('master.role_list')->insert($roleData);

        if (!$roleInsert) {
            return false;
        }

        $roleId = $this->db->insertID();

        // Insert data into the client_role table
        $clientRoleData = [
            'date_created' => date('Y-m-d H:i:s'),
            'client_id' => $clientId, // Assign the client_id passed from the controller
            'role_id' => $roleId,
            'role_details' => json_encode([
                'can_create' => $data['can_create'],
                'can_delete' => $data['can_delete'],
                'can_update' => $data['can_edit'],
                'can_view' => $data['can_view']
            ]),
            'status' => $data['status'],
            'updated_on' => date('Y-m-d')
        ];

        return $this->db->table('master.client_role')->insert($clientRoleData);
    }
    public function getClientsWithRoles()
    {
        return $this->select('master.client_details.*, client_role.role_details')
            ->join('master.client_role', 'client_role.client_id = client_details.id', 'left')
            ->findAll();
    }
    public function updateClient($clientId, $data)
    {
        try {
            $this->db->table('master.client_role')
                ->where('client_id', $clientId)
                ->update($data);

            // Update status in client_details table
            $this->db->table('master.client_details')
                ->where('id', $clientId)
                ->update(['status' => $data['status']]);

            // Log the success message
            log_message('debug', 'Client data updated successfully.');
            return true;
        } catch (\Exception $e) {
            log_message('error', $e->getMessage()); // Log any errors
            return false;
        }
    }

    public function getClientWithRoleDetails()
{
    // Fetch all clients along with their role details
    $query = $this->db->table('master.client_details')
        ->select('master.client_details.id, master.client_details.client_name, client_role.role_details')
        ->join('master.client_role', 'client_role.client_id = master.client_details.id', 'left')
        ->get();

    return $query->getResultArray();
}
    public function getDevicesByClientId($clientId)
    {
        // Query to fetch devices based on client ID
        $query = $this->db->table('master.device')
            ->select('id, device_name')
            ->where('client_id', $clientId)
            ->get();

        return $query->getResultArray();
    }


}
