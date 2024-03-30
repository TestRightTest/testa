<?php

namespace App\Modules\SuperAdmin\Models;

use CodeIgniter\Model;

class CreateClientModel extends Model
{
    protected $table = 'master.client_details';
    protected $primaryKey = 'id';
    protected $allowedFields = ['date_created', 'client_name','status', 'created_by_id'];

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

        $roleInsert = $this->db->table('master.role_list')->insert($roleData);
        
        if (!$roleInsert) {
            return false;
        }

        $roleId = $this->db->insertID();

        // Insert data into the client_role table
        $clientRoleData = [
            'date_created' => date('Y-m-d H:i:s'),
            'client_id' => $data['client_id'], // Assuming you pass client_id from controller
            // 'role_id' => $roleId,
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
        return $this->update($clientId, $data);
    }
}
