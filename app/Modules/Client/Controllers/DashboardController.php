<?php
namespace App\Modules\Client\Controllers;
use App\Controllers\BaseController;
use App\Modules\Client\Models\clientLoginModel;
use App\Modules\Client\Models\createUserModel;
use Config\Constants;

class DashboardController extends BaseController
{
    protected $db; // Define the $db property
    protected $createUserModel;
    protected $clientLoginModel;

    public function __construct()
    {
        // Load the database service
        $this->db = \Config\Database::connect();
        $this->createUserModel = new CreateUserModel();
        $this->clientLoginModel = new clientLoginModel();
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
    // private function getUserRoleDetails() {
    //     // Fetch user's role details from session or database
    //     // Implement your logic to retrieve role details
    //     $roleDetails = [
    //         Constants::CAN_VIEW => true,
    //         Constants::CAN_EDIT => false,
    //         Constants::CAN_DELETE => false,
    //         Constants::CAN_CREATE => false,
    //         Constants::CAN_ADJUST => false,

    //         // Add other role permissions here
    //     ];

    //     return $roleDetails;
    // }

    // Method to fetch user's role details
// Method to fetch user's role details
private function getUserRoleDetails() {
    // Check if roleDetails is available in the session
    $roleDetails = session()->get('roleDetails');

    if ($roleDetails !== null) {
        return $roleDetails;
    }

    // If roleDetails is not available in the session, fetch it from the database
    $userId = session()->get('userId'); // Assuming you have stored user ID in the session

    // Fetch role details for the user from the database
    $model = new ClientLoginModel();
    $userData = $model->getUserData($userId);

    // Initialize empty array to hold role details
    $roleDetails = [];

    // Check if user data exists
    if (!empty($userData)) {
        // Parse JSON data for role details
        $roleDetailsJson = $userData[0]['role_details'];

        // Decode JSON data into associative array
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
    public function getSelectedUserData()
    {
        $deviceId = $this->request->getGet('device_id');
        $clientId = $this->request->getGet('client_id');
        $schemaName = 'client_' . $clientId;

        $sql = "SELECT * FROM $schemaName.device_log WHERE device_id = ?";
        $query = $this->db->query($sql, [$deviceId]);
        $deviceLogData = $query->getResultArray();
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
        $sql = "SELECT * FROM $schemaName.device_log WHERE device_id IN ($deviceIdsString)";

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

}
