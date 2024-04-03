<?php
namespace App\Modules\Iot\Controllers;
use App\Controllers\BaseController;

use App\Modules\iot\Models\DeviceModel;

class IotDeviceController extends BaseController {

    public function index(): string  {
        return view('\App\Modules\Iot\Views\welcome_message');
    }

    public function startLog ( ) {
        if ( !$_GET ) {
            $this->response->setStatusCode ( 400 );
            return;
        }

        $deviceModel = new DeviceModel();
        /*
        *   p1 = MAC ID
        *   p2 = id
        *   p3 = sample name
        *   p4 = start time
        *   p5 = channel id
        *   p6 = test count id
        */
        $arrayData = $_GET;
        //checking whether all the parameter are present or not
        for ( $i = 1; $i <= 6; $i++ ) {
            if ( !isset ( $arrayData[ 'p'.$i ] ) ) {
                $this->response->setStatusCode ( 400 );
                return;
            } else {
                //DO NOTHING
            }
        }
        $device_details = $deviceModel->check_device ( $arrayData["p1"] );
        if ( isset ( $device_details['client_id'] ) ) {
            $whereData = [
                'device_id'     =>  $arrayData['p2'],
                'test_count_id' =>  $arrayData['p6']
            ];
            //Log data to the client specific table
            $writeData = [
                'device_id'     =>  $arrayData['p2'],
                'sample_name'   =>  $arrayData['p3'],
                'start_time'    =>  $arrayData['p4'],
                'channel_id'    =>  $arrayData['p5'],
                'test_count_id' =>  $arrayData['p6']
            ];
            $log_id = $deviceModel->log_device_start_data ( $device_details['client_id'], $whereData, $writeData );
            if( $log_id <= 0 ){
                $this->response->setStatusCode ( 400 );
            } else {
                //DO NOTHING
            }
        } else {
            $this->response->setStatusCode ( 400 );
            return;
        }
    }

    public function endLog ( ) {
        if ( !$_GET ) {
            $this->response->setStatusCode ( 400 );
            return;
        }

        $deviceModel = new DeviceModel();
        /*
        *   p1 = MAC ID
        *   p2 = device id
        *   p3 = test count id
        *   p4 = progress value
        *   p5 = end time
        */
        $arrayData = $_GET;
        //checking whether all the parameter are present or not
        for ( $i = 1; $i <= 5; $i++ ) {
            if ( !isset ( $arrayData[ 'p'.$i ] ) ) {
                $this->response->setStatusCode ( 400 );
                return;
            } else {
                //DO NOTHING
            }
        }
        $device_details = $deviceModel->check_device ( $arrayData["p1"] );
        if ( isset ( $device_details['client_id'] ) ) {
            //Log the data using the test count id
            $whereData = [
                'device_id'         =>  $arrayData['p2'],
                'test_count_id'     =>  $arrayData['p3'],
                'progress_value'    =>  null,
                'end_time'          =>  null
            ];
            $writeData = [
                'progress_value'    =>  $arrayData['p4'],
                'end_time'          =>  $arrayData['p5']
            ];
            $log_id = $deviceModel->log_device_end_data ( $device_details['client_id'], $whereData, $writeData );
            if( $log_id <= 0 ){
                $this->response->setStatusCode ( 400 );
            } else {
                //DO NOTHING
            }
        } else {
            $this->response->setStatusCode ( 400 );
            return;
        }
    }

    public function oldLog ( ) {
        if ( !$_GET ) {
            $this->response->setStatusCode ( 400 );
            return;
        }

        $deviceModel = new DeviceModel();
        /*
        *   p1 = MAC ID
        *   p2 = id
        *   p3 = sample name
        *   p4 = start time
        *   p5 = channel id
        *   p6 = test count id
        *   p7 = progress value
        *   p8 = end time
        */
        $arrayData = $_GET;
        //checking whether all the parameter are present or not
        for ( $i = 1; $i <= 8; $i++ ) {
            if ( !isset ( $arrayData[ 'p'.$i ] ) ) {
                $this->response->setStatusCode ( 400 );
                return;
            } else {
                //DO NOTHING
            }
        }
        $device_details = $deviceModel->check_device ( $arrayData["p1"] );
        if ( isset ( $device_details['client_id'] ) ) {
            $whereData = [
                'device_id'     =>  $arrayData['p2'],
                'test_count_id' =>  $arrayData['p6']
            ];
            //Log data to the client specific table
            $writeData = [
                'device_id'      =>  $arrayData['p2'],
                'sample_name'    =>  $arrayData['p3'],
                'start_time'     =>  $arrayData['p4'],
                'channel_id'     =>  $arrayData['p5'],
                'test_count_id'  =>  $arrayData['p6'],
                'progress_value' =>  $arrayData['p7'],
                'end_time'       =>  $arrayData['p8']
            ];
            $log_id = $deviceModel->log_device_start_data ( $device_details['client_id'], $whereData, $writeData );
            if( $log_id <= 0 ){
                $this->response->setStatusCode ( 400 );
            } else {
                //DO NOTHING
            }
        } else {
            $this->response->setStatusCode ( 400 );
            return;
        }
    }

    public function checkOTA ( ) {
        if ( !$_GET ) {
            $this->response->setStatusCode ( 400 );
            return;
        }

        $deviceModel = new DeviceModel();
        /*
        *   p1 = MAC ID
        *   p2 = device current verion information
        */

        $arrayData = $_GET;
        //checking whether all the parameter are present or not
        for ( $i = 1; $i <= 2; $i++ ) {
            if ( !isset ( $arrayData[ 'p'.$i ] ) ) {
                $this->response->setStatusCode ( 400 );
                return;
            } else {
                //DO NOTHING
            }
        }

        //checking whether valid device version or not
        if ( $this->check_version_number ( $arrayData[ 'p2' ] ) < 1 ) {
            $this->response->setStatusCode ( 400 );
            return;
        } else {
            //DO NOTHING
        }

        //checking whether valid device mac id or not
        if ( $this->check_mac_id ( $arrayData[ 'p1' ] ) == -1 ) {
            $this->response->setStatusCode ( 400 );
            return;
        } else {
            //getting device information
            $device_details = $deviceModel->check_device ( $arrayData["p1"] );
        }
        //checking device exist and next step

        print_r ( "Y=1.1.1" );
    }

    public function fetchOTA ( ) {
        /*header('Content-type: text/plain; charset=utf8', true);

        if ( !$this->check_header('HTTP_USER_AGENT', 'ESP32-http-Update') ) {
            header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
            echo "only for ESP8266 updater!\n";
            exit();
        }

        if( !$this->check_header('HTTP_X_ESP8266_STA_MAC') ||
            !$this->check_header('HTTP_X_ESP8266_AP_MAC') ||
            !$this->check_header('HTTP_X_ESP8266_FREE_SPACE') ||
            !$this->check_header('HTTP_X_ESP8266_SKETCH_SIZE') ||
            !$this->check_header('HTTP_X_ESP8266_CHIP_SIZE') ||
            !$this->check_header('HTTP_X_ESP8266_SDK_VERSION') ||
            !$this->check_header('HTTP_X_ESP8266_VERSION')
        ) {
            header($_SERVER["SERVER_PROTOCOL"].' 403 Forbidden', true, 403);
            echo "only for ESP8266 updater! (header)\n";
            exit();
        }*/

        //if (isset($_SERVER["HTTP_X_ESP8266_VERSION"])) {
            $this->sendFile(FCPATH."assets/firmware/"."update.bin");
            exit();
        //}

        header($_SERVER["SERVER_PROTOCOL"].' 500 no version for ESP MAC', true, 500);
    }

    private function check_header($name, $value = false) {
        if ( !isset ( $_SERVER[$name] ) || ( ( $value ) && ( $_SERVER[$name] != $value ) ) ) {
            return false;
        } else {
            return true;
        }
    }

    private function sendFile($path) {
        //header($_SERVER["SERVER_PROTOCOL"].' 200 OK', true, 200);
        header('Content-Type: application/octet-stream', true);
        header('Content-Disposition: attachment; filename='.basename($path));
        header('Content-Length: '.filesize($path), true);
        //header('x-MD5: '.md5_file($path), true);
        readfile($path);
    }

    /*
    */
    private function check_mac_id ( $macAddress ) {
        if ( preg_match('/^([0-9A-Fa-f]{2}){6}$/', $macAddress) ) {
            return strtoupper ( $macAddress );
        } else {
            return -1;
        }
    }

    private function check_version_number ( $versionNumber ) {
        if ( preg_match('/^(?:\d{1,2}\.){2}\d{1,2}$/', $versionNumber) ) {
            return 1;
        } else {
            return -1;
        }
    }

}
