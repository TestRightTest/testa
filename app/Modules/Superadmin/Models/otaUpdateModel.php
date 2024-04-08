<?php

namespace App\Modules\superadmin\Models;

use CodeIgniter\Model;

class otaUpdateModel extends Model
{
    protected $table = 'master.ota_upgrade'; // Specify the table name
    protected $primaryKey = 'id'; // Specify the primary key field name
        // Specify the allowed fields for mass assignment
        protected $allowedFields = [
            'release_name',
            'release_description',
            'super_admin_id',
            'release_for',
            'status',
            'release_version',
            'ota_file_name',
            'ota_file_size',
        ];

        public function getDeviceDetails()
        {
            // Assuming you have already loaded the database in CodeIgniter
            $db = db_connect();
            
            // Select only id column from the 'master.device' table
            $query = $db->table('master.device')
                        ->select('id, device_name')
                        ->get();
            
            // Check if there are any results
            if ($query->getNumRows() > 0) {
                // Return the results as an array of objects
                return $query->getResult();
            } else {
                // Return an empty array if no records found
                return [];
            }
        }
        
        public function getOtaDevices()
        {
            // Fetch data from the 'master.ota_upgrade' table
            $query = $this->findAll();
    
            // Check if there are any results
            if (!empty($query)) {
                // Return the results
                return $query;
            } else {
                // Return an empty array if no records found
                return [];
            }
        }
        
}