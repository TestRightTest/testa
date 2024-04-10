<?php
namespace App\Modules\Client\Controllers; 
use App\Controllers\BaseController; 
use App\Modules\client\Models\ClientLoginModel;
use App\Modules\client\Models\deviceParametersModel;
use App\Modules\Client\Models\CreateUserModel; // Add this line to import the CreateUserModel

use Config\Constants;
class DashboardController extends BaseController 
{ 
    protected $db; // Define the $db property
    protected $createUserModel;
    protected $clientLoginModel;
    protected $deviceParametersModel;


    public function __construct()
    {
        // Load the database service
        $this->db = \Config\Database::connect();
        $this->createUserModel = new CreateUserModel();
        $this->clientLoginModel = new clientLoginModel();
        $this->deviceParametersModel = new deviceParametersModel();
    }
    public function index(): string 
    { 
    return view('\App\Modules\Client\Views\login'); 
    } 

    public function login():string{
        return view('\App\Modules\Client\Views\login'); 
    }
    public function loginAuth() 
    { 
        $request = $this->request->getJSON();

        $username = $request->username;
        $password = $request->password;

        $model = new ClientLoginModel();
        $authenticatedUser = $model->authenticate($username, $password);
        
        if ($authenticatedUser) {
            // Start session and set isLoggedIn to true
            session()->set('isLoggedIn', true);
            // Store the user's ID in the session
            session()->set('userId', $authenticatedUser['id']);
                    // Store role_details in the session if available
        if (isset($authenticatedUser['role_details'])) {
            session()->set('roleDetails', $authenticatedUser['role_details']);
        }
            $data['status'] = 'success';
            $data['message'] = 'Login successful';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Invalid username or password';
        }

        return $this->response->setJSON($data);    
    }

    public function getUser()
    {
        $session = session();
            if ($session->has('userId')) {
            $userId = $session->get('userId');
    
            $userModel = new ClientLoginModel();
    
            $userData = $userModel->getUserData($userId);
    
            if ($userData) {
                return $this->response->setJSON($userData);
            } else {
                return $this->response->setJSON(['error' => 'User data not found']);
            }
        } else {
            return $this->response->setJSON(['error' => 'User not logged in']);
        }
    }

    public function logout(){
        // Destroy session on logout
        session()->destroy();
        return redirect()->to(base_url('client/login'));
    }


    // public function dashboard()
    // { 
    //     if (!session()->get('isLoggedIn')) {
    //         return redirect()->to(base_url('client/login'));
    //     }
    //     return view('\App\Modules\Client\Views\dashboard'); 
    // } 

    public function dashboard()
    { 
        // Check if the user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('client/login'));
        }
        
        // Get user's role details
        $roleDetails = $this->getUserRoleDetails();
        
        // Pass role details to the view
        return view('\App\Modules\Client\Views\dashboard', ['roleDetails' => $roleDetails]); 
    }

    // Method to fetch user's role details
    private function getUserRoleDetails() {
        // Check if roleDetails is available in the session
        $roleDetails = session()->get('roleDetails');

        if ($roleDetails !== null) {
            return $roleDetails;
        }
        $userId = session()->get('userId');

        $model = new ClientLoginModel();
        $userData = $model->getUserData($userId);

        $roleDetails = [];

        if (!empty($userData)) {
            $roleDetailsJson = $userData[0]['role_details'];

            $roleDetails = json_decode($roleDetailsJson, true);
        }

        return $roleDetails;
    }



    public function settings()
    { 
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('client/login'));
        }
        // Get user's role details
        $roleDetails = $this->getUserRoleDetails();
        return view('\App\Modules\Client\Views\settings', ['roleDetails' => $roleDetails]); 
    } 
    public function createuser()
    { 
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('client/login'));
        }
        // Get user's role details
        $roleDetails = $this->getUserRoleDetails();
        return view('\App\Modules\Client\Views\createuser', ['roleDetails' => $roleDetails]); 
    } 


    // public function getSelectedUserData()
    // {
    //     $deviceId = $this->request->getGet('device_id');
    //     $clientId = $this->request->getGet('client_id');
    //     $schemaName = 'client_' . $clientId;
        
    //     $sql = "SELECT * FROM $schemaName.device_log WHERE device_id = ?";
    //     $query = $this->db->query($sql, [$deviceId]);
    //     $deviceLogData = $query->getResultArray();
    //     return $this->response->setJSON($deviceLogData);
    // }
    public function getSelectedUserData()
    {
        $deviceId = $this->request->getGet('device_id');
        $clientId = $this->request->getGet('client_id');
        $schemaName = 'client_' . $clientId;
        
        // Get device log data
        $sql = "SELECT * FROM $schemaName.device_log WHERE device_id = ?";
        $query = $this->db->query($sql, [$deviceId]);
        $deviceLogData = $query->getResultArray();
        
        // Get device name from master.device table
        $sqlDevice = "SELECT device_name FROM master.device WHERE id = ?";
        $queryDevice = $this->db->query($sqlDevice, [$deviceId]);
        $deviceNameData = $queryDevice->getRowArray();
        
        $deviceName = $deviceNameData['device_name'];
        
        // Add device name to each item in device log data
        foreach ($deviceLogData as &$item) {
            $item['device_name'] = $deviceName;
        }
        
        return $this->response->setJSON($deviceLogData);
    }
    
    
    
    public function getAllDeviceData()
    {
        $clientId = $this->request->getGet('client_id');
        $userId = $this->request->getGet('user_id');
        $schemaName = 'client_' . $clientId;
        
        // Fetch device IDs assigned to the user from device_details table
        $deviceIdsQuery = $this->db->table('master.device_details')
                                    ->select('device_id')
                                    ->where('user_id', $userId)
                                    ->get();
        
        $deviceIds = array_column($deviceIdsQuery->getResultArray(), 'device_id');
        
        // If no device IDs found for the user, return an empty array
        if (empty($deviceIds)) {
            return $this->response->setJSON([]);
        }
        
        // Build the SQL query to fetch device log data for the user's devices
        $deviceIdsString = implode(',', $deviceIds);
        $sql = "SELECT dl.*, md.device_name 
                FROM $schemaName.device_log dl
                LEFT JOIN master.device md ON dl.device_id = md.id
                WHERE dl.device_id IN ($deviceIdsString)";
        
        $query = $this->db->query($sql);
        
        $deviceLogData = $query->getResultArray();
        return $this->response->setJSON($deviceLogData);
    }
    
    
    
    public function getclientusers(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superadmin/login'));
        }
        $clientId = $this->request->getGet('client_id');

        // Fetch users with role details from the model
        $users = $this->createUserModel->getUsersWithRoleDetails($clientId);
    
        // Return JSON response
        return $this->response->setJSON($users);
    }
    
    public function addUser(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superadmin/login'));
        }
        $createUserModel = new CreateUserModel();
    
        // Retrieve data from the AJAX request
        $clientID = $this->request->getPost('client_id');
        $name = $this->request->getPost('name');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $status = $this->request->getPost('status');
        $device_id = $this->request->getPost('device_id');
        // Convert checkbox values to boolean
        $create = $this->request->getPost('create') === 'true' ? true : false;
        $update = $this->request->getPost('update') === 'true' ? true : false;
        $view = $this->request->getPost('view') === 'true' ? true : false;
        $delete = $this->request->getPost('delete') === 'true' ? true : false;
    
        // Check if the username already exists
        $existingUser = $createUserModel->where('user_name', $username)->first();
        if ($existingUser) {
            return "Username already exists";
        }
    
        // Get the ID of the current user
        $currentUserId = session()->get('userId');
        $data = [
            'date_created' => date('Y-m-d H:i:s'),
            'name' => $name,
            'user_name' => $username,
            'password' => md5($password),
            'status' => $status,
            'client_id' => $clientID,
            'c_admin_id' => $currentUserId,
            'c_user_id' => 1
        ];

        $roleData = [
            'can_view' => $view,
            'can_create' => $create,
            'can_delete' => $delete,
            'can_edit' => $update
        ];
        
        // Insert data into the database
        $insertResult = $createUserModel->insert($data);
    
        if ($insertResult === false) {
            log_message('error', 'Error inserting data into the database: ' . print_r($createUserModel->errors(), true));
            return "Error adding user";
        }
    
        // Retrieve user_id for the inserted user
        $userId = $insertResult;

        // Convert device_id to string if it's an array
        if (is_array($device_id)) {
            $device_id = implode(',', $device_id);
        }

        // Split device_id string into an array
        $deviceIds = explode(',', $device_id);

        foreach ($deviceIds as $deviceId) {
            $deviceData = [
                'device_id' => $deviceId,
                'user_id' => $userId
            ];

            // Insert device data into the database
            $insertDeviceResult = $createUserModel->db->table('master.device_details')->insert($deviceData);

            if ($insertDeviceResult === false) {
                log_message('error', 'Error inserting device data into the database');
            }
        }


        // Insert role-related data into the role_list table
        $roleInsertResult = $createUserModel->addRole($roleData);
    
        if ($roleInsertResult === false) {
            log_message('error', 'Error inserting role data into the database');
        }
    
        // Insert data into the user_role table
        $userRoleData = [
            'date_created' => date('Y-m-d H:i:s'),
            'client_id' => $clientID,
            'role_id' => $roleInsertResult,
            'role_details' => json_encode($roleData),
            'user_id' => $insertResult,
            'status' => $status,
            'updated_on' => date('Y-m-d')
        ];
    
        $userRoleInsertResult = $createUserModel->db->table('master.user_role')->insert($userRoleData);
    
        if ($userRoleInsertResult === false) {
            log_message('error', 'Error inserting user role data into the database');
        }
    
        log_message('info', 'User added successfully');
        return "User added successfully";
    }
    public function submitRotationInterval()
    {
        if ($this->request->isAJAX()) {
            $deviceParametersModel = new DeviceParametersModel();
    
            // Get rotation interval from POST data
            $rotationInterval = $this->request->getPost('rotationInterval');
            $clientId = $this->request->getPost('client_id');

            // Check if rotation interval is not empty
            if (!empty($rotationInterval)) {
                $deviceParametersModel->setTable($clientId);
                
                $existingRecord = $deviceParametersModel->first();    
                if (!$existingRecord) {
                    $deviceParametersModel->insert(['rotation_interval' => $rotationInterval]);
                    $message = 'Rotation interval inserted successfully';
                } else {
                    $deviceParametersModel->update($existingRecord['id'], ['rotation_interval' => $rotationInterval]);
                    $message = 'Rotation interval updated successfully';
                }
    
                return $this->response->setJSON(['message' => $message, 'rotationInterval' => $rotationInterval]);
            } else {
                // Return an error response if rotation interval is empty
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Rotation interval is empty']);
            }
        } else {
            return redirect()->to('/');
        }
    }

    public function submitProgress()
    {
        if ($this->request->isAJAX()) {
            $deviceParametersModel = new DeviceParametersModel();
    
            $progressThreshold = $this->request->getPost('progressThreshold');
            $clientId = $this->request->getPost('client_id');
    
            if (!empty($progressThreshold) && is_numeric($progressThreshold)) {
                $deviceParametersModel->setTable($clientId);
    
                $existingRecord = $deviceParametersModel->first();
                if (!$existingRecord) {
                    $deviceParametersModel->insert(['progress_threshold' => $progressThreshold]);
                    $message = 'Progress threshold inserted successfully';
                } else {
                    $deviceParametersModel->update($existingRecord['id'], ['progress_threshold' => $progressThreshold]);
                    $message = 'Progress threshold updated successfully';
                }
    
                return $this->response->setJSON(['message' => $message, 'progressThreshold' => $progressThreshold]);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Progress threshold is empty or invalid']);
            }
        } else {
            return redirect()->to('/');
        }
    }
    
    public function enableRotation()
    {
        if ($this->request->isAJAX()) {
            $deviceParametersModel = new DeviceParametersModel();
    
            // Get rotation enabled state from POST data (as boolean)
            $rotationEnabled = $this->request->getPost('rotationEnabled');
            $clientId = $this->request->getPost('client_id');
    
            // Set the table dynamically based on the client ID
            $deviceParametersModel->setTable($clientId);
    
            // Check if any records exist in the table
            $existingRecord = $deviceParametersModel->first();
    
            // If no records exist, insert a new one with the checkbox state
            if (!$existingRecord) {
                $deviceParametersModel->insert(['rotation_enable' => $rotationEnabled]);
                $message = 'Rotation state inserted successfully';
            } else {
                // If records exist, update the existing record with the checkbox state
                $deviceParametersModel->update($existingRecord['id'], ['rotation_enable' => $rotationEnabled]);
                $message = 'Rotation state updated successfully';
            }
    
            // Return a success response
            return $this->response->setJSON(['message' => $message, 'rotationEnabled' => $rotationEnabled]);
        } else {
            return redirect()->to('/');
        }
    }
    
    
    public function getData()
    {
        if ($this->request->isAJAX()) {
            // Retrieve the client_id from the query parameters
            $clientId = $this->request->getGet('client_id');

            // Check if the client_id is provided
            if ($clientId) {
                // Create an instance of the DeviceParametersModel
                $deviceParametersModel = new DeviceParametersModel();

                // Set the table dynamically based on the client ID
                $deviceParametersModel->setTable($clientId);

                // Retrieve data from the model
                $data = $deviceParametersModel->findAll(); // Adjust this based on your requirements

                // Return the data as a JSON response
                return $this->response->setJSON($data);
            } else {
                // If client_id is not provided, return an error response
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Client ID is missing']);
            }
        } else {
            // If not an AJAX request, redirect or handle accordingly
            return redirect()->to('/');
        }
    }

    public function updateTemp()
    {
        if ($this->request->isAJAX()) {
            $deviceParametersModel = new DeviceParametersModel();
    
            $temperature = $this->request->getPost('temperature');
            $clientId = $this->request->getPost('client_id');
            $deviceId = (int) $this->request->getPost('device_id');
            
            // Debugging: Log the received device_id
            log_message('info', 'Received device_id: ' . $deviceId);
    
            if (!empty($temperature) && is_numeric($temperature) && is_int($deviceId)) {
                // Set the table based on client ID
                $deviceParametersModel->setTable($clientId);
    
                // Check if the device ID already exists
                $existingRecord = $deviceParametersModel->where('device_id', $deviceId)->first();
        
                if (!$existingRecord) {
                    // If device ID doesn't exist, insert a new record with device_id
                    $deviceParametersModel->insert([
                        'device_id' => $deviceId,
                        'temperature' => $temperature
                    ]);
                    $message = 'Temperature record added successfully';
                } else {
                    // If device ID exists, update the temperature value
                    $deviceParametersModel->update($existingRecord['id'], ['temperature' => $temperature]);
                    $message = 'Temperature record updated successfully';
                }
        
                return $this->response->setJSON(['message' => $message, 'temperature' => $temperature, 'device_id' => $deviceId]);
            } else {
                return $this->response->setStatusCode(400)->setJSON(['error' => 'Temperature or device ID is empty or invalid']);
            }
        } else {
            return redirect()->to('/');
        }
    }
    
    
    
    
    


    // public function updateTemp()
    // {
    //     $deviceId = $this->request->getPost('device_id');
    //     $temperature = $this->request->getPost('temperature');
    //     $clientId = $this->request->getPost('client_id');
    //     $deviceParametersModel = new DeviceParametersModel();
    
    //     $deviceParametersModel->setTable($clientId);
    
    //     $existingRecord = $deviceParametersModel->where('device_id', $deviceId)->first();
    
    //     if ($existingRecord) {
    //         $deviceParametersModel->update($existingRecord['id'], ['temperature' => $temperature]);
    //         $responseMessage = 'Temperature updated successfully for device ID: ' . $deviceId;
    //         return $this->response->setJSON(['message' => $responseMessage])->setStatusCode(200);
    //     } else {
    //         $responseMessage = 'Device ID not found. Temperature not updated.';
    //         return $this->response->setJSON(['message' => $responseMessage])->setStatusCode(404);
    //     }
    // }
    
}