<?php

namespace App\Modules\iot\Models;

use CodeIgniter\Model;

class DeviceModel extends Model {
    protected $schema = 'master';
    protected $table  = 'device';

    public function check_device ( $device_id ) {
        return $this->db->table ( $this->schema . '.' . $this->table )
                    ->where ( 'mac_id', $device_id )
                    ->get ( )
                    ->getRowArray ( );
    }

    public function log_device_start_data ( $client, $whereData, $writeData ) {
        //check whether the same test count id and device id exsists
        $queryData = $this->db->table ( 'client_' . $client . '.' . 'device_log' )
                    ->where ( $whereData )
                    ->countAllResults ( );

        if ( $queryData == 0 ) {
            $this->db->table ( 'client_' . $client . '.' . 'device_log' )
            ->insert ( $writeData );

            $returnID = $this->db->insertID ( );
        } else {
            $returnID = -1;
        }
        return $returnID;
    }

    public function log_device_end_data ( $client, $whereData, $writeData ) {
        $queryData = $this->db->table ( 'client_' . $client . '.' . 'device_log' )
                    ->where ( $whereData )
                    ->get ( )
                    ->getRowArray ( );

        if ( isset ( $queryData['id'] ) ) {
            $this->db->table ( 'client_' . $client . '.' . 'device_log' )
            ->where ( array ( 'id' => $queryData['id'] ) )
            ->update ( $writeData );
            $returnID = $queryData['id'];
        } else {
            $returnID = -1;
        }

        return $returnID;
    }

    public function fetch_latest_ota_record ( ) {
        
    }
}
