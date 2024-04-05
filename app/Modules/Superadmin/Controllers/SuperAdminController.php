<?php
namespace App\Modules\Superadmin\Controllers;

use App\Controllers\BaseController;

use App\Modules\Superadmin\Models\AdminLoginModel;
use App\Modules\Superadmin\Models\createUserModel;
use App\Modules\Superadmin\Models\createClientModel;
use App\Modules\Superadmin\Models\createDeviceModel;

class SuperAdminController extends BaseController
{
    protected $adminLoginModel;
    protected $createUserModel;
    protected $createClientModel;
    protected $createDeviceModel;

    public function __construct() {
        $this->adminLoginModel = new AdminLoginModel();
        $this->createUserModel = new CreateUserModel();
        $this->createClientModel = new CreateClientModel();
        $this->createDeviceModel = new CreateDeviceModel();
    }

    public function index(): string {
        return view('\App\Modules\Superadmin\Views\welcome_message');
    }

    public function login() {
        return view('\App\Modules\Superadmin\Views\login');
    }

    public function dashboard() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\Superadmin\Views\createClient');
    }

    public function createUser() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\Superadmin\Views\createUser');
    }

    public function createDevice() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\Superadmin\Views\createDevice');
    }

    public function otaUpdate() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\Superadmin\Views\otaUpdate');
    }

    public function loginAuth() {
        $request = $this->request->getJSON();

        $username = $request->username;
        $password = md5($request->password);
        // Load the database
        $db = \Config\Database::connect();

        $builder = $db->table('master.admin_login');
        $builder->select('id');
        $builder->where('username', $username);
        $builder->where('password', $password);
        $query = $builder->get();
        if ($row = $query->getRow()) {
            // Start session and set isLoggedIn to true
            session()->set('isLoggedIn', true);
            // Store the user's ID in the session
            session()->set('userId', $row->id);
            $data['status'] = 'success';
            $data['message'] = 'Login successful';
        } else {
            $data['status'] = 'error';
            $data['message'] = 'Invalid username or password';
        }

        return $this->response->setJSON($data);
    }

    public function logout(){
        // Destroy session on logout
        session()->destroy();
        return redirect()->to(base_url('superAdmin/login'));
    }

    public function addUser(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
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

        // // Check if 'client_id' is provided before adding it to the $data array
        // if ($clientID) {
        //     $data['client_id'] = $clientID;
        // }

        // Prepare role-related data
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

    public function getUsers(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        // Fetch users with role details from the model
        $users = $this->createUserModel->getUsersWithRoleDetails();

        // Return JSON response
        return $this->response->setJSON($users);
    }

    public function getClient(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        // Use $this->createClientModel to access the model
        $clients = $this->createClientModel->getClientsWithRoles();
        return $this->response->setJSON($clients);
    }

    public function addClient(){
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        // Get the current user's ID
        $currentUserId = session()->get('userId');

        // Get the posted data
        $name = $this->request->getPost('name');
        $status = $this->request->getPost('status');

        // Check if the client name already exists
        if ($this->createClientModel->clientExists($name)) {
            return "duplicate"; // Return a response indicating duplicate name
        }

        // Get the role-related data
        $roleData = [
            'role_name' => $this->request->getPost('role_name'),
            'can_view' => $this->request->getPost('can_view') == 'true' ? true : false,
            'can_create' => $this->request->getPost('can_create') == 'true' ? true : false,
            'can_delete' => $this->request->getPost('can_delete') == 'true' ? true : false,
            'can_edit' => $this->request->getPost('can_edit') == 'true' ? true : false,
            'status' => $this->request->getPost('status'),
        ];

        // Insert data into the client_details table
        $data = [
            'date_created' => date('Y-m-d H:i:s'),
            'client_name' => $name,
            'status' => $status,
            'created_by_id' => $currentUserId,
        ];

        $insertResult = $this->createClientModel->insert($data);

        if ($insertResult === false) {
            log_message('error', 'Error inserting data into the database: ' . print_r($this->createClientModel->errors(), true));
            return "Error adding user";
        }

        $clientId = $this->createClientModel->insertID();
        log_message('info', 'User added successfully with ID: ' . $clientId);

        // Add client ID to the role data
        $roleData['client_id'] = $clientId;

        // Insert role-related data into the role_list table
        // $roleInsertResult = $this->createClientModel->addRole($roleData);
        $roleInsertResult = $this->createClientModel->addRole($insertResult, $roleData);

        if ($roleInsertResult === false) {
            log_message('error', 'Error inserting role data into the database');
        }

        // Prepare the response containing both client ID and name
        $response = $clientId . '|' . $name;

        return $response;
    }

    public function createSchemaAndTables() {

        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        $clientId = $this->request->getPost('clientId');

        if (!$clientId) {
            return "Error: Client ID not provided.";
        }

        $db = \Config\Database::connect();
        $schemaName = 'client_' . $clientId;
        $schemaQuery = $db->table('information_schema.schemata')
                        ->select('schema_name')
                        ->where('schema_name', $schemaName)
                        ->get();
        $result = $schemaQuery->getResult();
        if (empty($result)) {
            // Create the schema
            $db->query("CREATE SCHEMA {$schemaName}");
        }

        $db->query("
            CREATE TABLE IF NOT EXISTS {$schemaName}.device_log (
                id SERIAL PRIMARY KEY,
                device_id INT,
                channel_id INT,
                test_count_id INT,
                sample_name VARCHAR(255),
                progress_value FLOAT,
                start_time TIMESTAMP,
                end_time TIMESTAMP,
                log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                data_extra JSONB
            )
        ");
        $db->query("
            CREATE TABLE IF NOT EXISTS {$schemaName}.device_parameter (
                id SERIAL PRIMARY KEY,
                log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                progress_threshold FLOAT,
                rotation_interval INT,
                rotation_enable BOOLEAN,
                temperature FLOAT
            )
        ");
        return "Schema and tables created successfully for client ID: $clientId.";
    }

    public function updateClient(){
        $clientId = $this->request->getPost('clientId');
        $status = $this->request->getPost('status');
        $roleDetails = $this->request->getPost('roleDetails'); // Get the role details as an array

        // Convert role details values to boolean
        $roleDetails = array_map(function ($value) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }, $roleDetails);

        // Construct data array
        $data = [
            'status' => $status,
            'role_details' => json_encode($roleDetails) // Convert array to JSON string
        ];

        $result = $this->createClientModel->updateClient($clientId, $data);

        if ($result) {
            // Construct the response object with information about the update
            $response = [
                'success' => true,
                'message' => 'Client details updated successfully',
                'clientId' => $clientId,
                'updatedData' => $data // Include the updated data in the response
            ];
            return $this->response->setJSON($response);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update client details']);
        }
    }

    public function updateUser(){
        $clientId = $this->request->getPost('clientId');
        $userId = $this->request->getPost('userId');

        $status = $this->request->getPost('status');
        $roleDetails = $this->request->getPost('roleDetails'); // Get the role details as an array
        $user_name = $this-> request->getPost('user_name');
        // Convert role details values to boolean
        $roleDetails = array_map(function ($value) {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }, $roleDetails);

        // Construct data array
        $data = [
            'status' => $status,
            'role_details' => json_encode($roleDetails) // Convert array to JSON string
        ];

        $result = $this->createUserModel->updateUserRole($userId, $data);

        if ($result) {
            // Construct the response object with information about the update
            $response = [
                'success' => true,
                'message' => 'User details updated successfully',
                'userId' => $userId,
                'updatedData' => $data // Include the updated data in the response
            ];
            return $this->response->setJSON($response);
        } else {
            return $this->response->setJSON(['success' => false, 'error' => 'Failed to update client details']);
        }
    }

    public function addDevice() {
        // Check if it's an AJAX request
        if ($this->request->isAJAX()) {
            // Get data from POST request
            $name = $this->request->getPost('name');
            $status = $this->request->getPost('status');
            $macId = $this->request->getPost('mac_id');
            $clientId = $this->request ->getpost('client_id');
            // Prepare data array
            $data = [
                'log_time' => date('Y-m-d H:i:s'),
                'device_name' => $name,
                'mac_id' => $macId,
                'status' => $status,
                'client_id' => $clientId
            ];

            // Insert data into the database
            $inserted = $this->createDeviceModel->insert($data);

            if ($inserted === false) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to add device']);
            } else {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Device added successfully']);
            }
        } else {
            // Handle non-AJAX requests
            return redirect()->to(site_url('/'));
        }
    }

    public function getDevices() {
        // Fetch devices from the database
        $devices = $this->createDeviceModel->findAll();

        // Return the devices as JSON response
        return $this->response->setJSON($devices);
    }

    public function getClientId() {
        $createClientModel = new CreateClientModel();
        $clients = $createClientModel->getClientWithRoleDetails(); // Assuming you have a method to fetch all clients

        return $this->response->setJSON($clients);
    }

    public function getDevicesByClientId()
    {
        $clientId = $this->request->getGet('clientId'); // Get the client ID from the request

        // Instantiate the CreateClientModel
        $createClientModel = new CreateClientModel();

        // Call the getDevicesByClientId method to fetch devices based on the client ID
        $devices = $createClientModel->getDevicesByClientId($clientId);

        // Return devices as JSON response
        return $this->response->setJSON($devices);
    }

}
