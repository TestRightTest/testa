<?php
namespace App\Modules\Client\Controllers; 
use App\Controllers\BaseController; 
class DashboardController extends BaseController 
{ 
    public function login():string{
        return view('\App\Modules\Client\Views\login'); 
    }
    public function loginAuth() 
    { 
        $request = $this->request->getJSON();

        $username = $request->username;
        $password = md5($request->password);
        // Load the database
        $db = \Config\Database::connect();

        $builder = $db->table('master.user_login');
        $builder->select('id');
        $builder->where('user_name', $username);
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
}