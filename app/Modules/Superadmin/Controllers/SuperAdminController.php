<?php
namespace App\Modules\SuperAdmin\Controllers;
use App\Controllers\BaseController;
use App\Modules\SuperAdmin\Models\AdminLoginModel;
use App\Modules\SuperAdmin\Models\createUserModel;
use App\Modules\SuperAdmin\Models\createClientModel;

class SuperAdminController extends BaseController
{
    protected $adminLoginModel;
    protected $createUserModel;
    protected $createClientModel;

    public function __construct() {
        $this->adminLoginModel = new AdminLoginModel();
        $this->createUserModel = new CreateUserModel();
        $this->createClientModel = new CreateClientModel();
    }

    public function index(): string {
        return view('\App\Modules\SuperAdmin\Views\welcome_message');
    }

    public function login():string {
        return view('\App\Modules\SuperAdmin\Views\login');
    }

    public function dashboard() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\SuperAdmin\Views\createClient');
    }

    public function createUser() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\SuperAdmin\Views\createUser');
    }

    public function otaUpdate() {
        // Check if user is logged in
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        return view('\App\Modules\SuperAdmin\Views\otaUpdate');
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

    public function logout()
    {
        // Destroy session on logout
        session()->destroy();
        return redirect()->to(base_url('superAdmin/login'));
    }

    public function addUser()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }
        $createUserModel = new createUserModel();

        // Retrieve data from the AJAX request
        $deviceID = $this->request->getPost('device_id');
        $name = $this->request->getPost('name');
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $create = $this->request->getPost('create');
        $update = $this->request->getPost('update');
        $view = $this->request->getPost('view');
        $delete = $this->request->getPost('delete');

        // Check if the username already exists
        $existingUser = $createUserModel->where('user_name', $username)->first();
        if ($existingUser) {
            return "Username already exists";
        }

        $data = [
            'date_created' => date('Y-m-d H:i:s'),
            'name' => $name,
            'user_name' => $username,
            'password' => md5($password),
            'status' => 1,
            'client_id' => null,
            'c_admin_id' => $create,
            'c_user_id' => $update
        ];
            // Get the role-related data
        $roleData = [
            'role_name' => $this->request->getPost('role_name'),
            'can_view' => $this->request->getPost('can_view') == 'true' ? true : false,
            'can_create' => $this->request->getPost('can_create') == 'true' ? true : false,
            'can_delete' => $this->request->getPost('can_delete') == 'true' ? true : false,
            'can_edit' => $this->request->getPost('can_edit') == 'true' ? true : false,
            'status' => $this->request->getPost('status'),
        ];
        // Insert data into the database
        $insertResult = $createUserModel->insert($data);

        if ($insertResult === false) {
            log_message('error', 'Error inserting data into the database: ' . print_r($createUserModel->errors(), true));
            return "Error adding user";
        }

        // Insert role-related data into the role_list table
        $roleInsertResult = $this->createClientModel->addRole($roleData);

        if ($roleInsertResult === false) {
            log_message('error', 'Error inserting role data into the database');
        }

        log_message('info', 'User added successfully');
        return "User added successfully";
    }

    public function getUsers()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        $users = $this->createUserModel->findAll();
        return $this->response->setJSON($users);
    }
    public function getClient()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        // Use $this->createClientModel to access the model
        $clients = $this->createClientModel->getClientsWithRoles();

        // Extract only client IDs
        $clientIds = array_column($clients, 'id');

        // Log client IDs
        foreach ($clientIds as $clientId) {
            log_message('info', 'Client ID: ' . $clientId);
        }

        return $this->response->setJSON($clients);
    }

    public function addClient()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('superAdmin/login'));
        }

        // Get the current user's ID
        $currentUserId = session()->get('userId');

        // Get the posted data
        $name = $this->request->getPost('name');
        $status = $this->request->getPost('status');

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
        $roleInsertResult = $this->createClientModel->addRole($roleData);

        if ($roleInsertResult === false) {
            log_message('error', 'Error inserting role data into the database');
        }

        // Prepare the response containing both client ID and name
        $response = $clientId . '|' . $name;

        return $response;
    }

    public function createSchemaAndTables()
    {

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

        // Create tables within the schema
        $db->query("
            CREATE TABLE IF NOT EXISTS {$schemaName}.device (
                id SERIAL PRIMARY KEY,
                log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                device_name VARCHAR(255),
                status VARCHAR(50)
            )
        ");

        $db->query("
            CREATE TABLE IF NOT EXISTS {$schemaName}.device_log (
                id SERIAL PRIMARY KEY,
                log_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                channel_id INT,
                progress_value FLOAT,
                start_time TIMESTAMP,
                end_time TIMESTAMP,
                first_reading FLOAT,
                sample_name VARCHAR(255),
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

}
