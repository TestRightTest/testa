<?php
namespace App\Modules\Client\Controllers; 
use App\Controllers\BaseController; 
use App\Modules\client\Models\ClientLoginModel;

class DashboardController extends BaseController 
{ 
    protected $db; // Define the $db property
    public function __construct()
    {
        // Load the database service
        $this->db = \Config\Database::connect();
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

    public function index(): string 
    { 
    return view('\App\Modules\Client\Views\welcome_message'); 
    } 

    public function dashboard()
    { 
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('client/login'));
        }
        return view('\App\Modules\Client\Views\dashboard'); 
    } 

    public function settings()
    { 
        if (!session()->get('isLoggedIn')) {
            return redirect()->to(base_url('client/login'));
        }
        return view('\App\Modules\Client\Views\settings'); 
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
    
    
    
}