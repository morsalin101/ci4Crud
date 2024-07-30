<?php

namespace App\Controllers;
use App\Models\UserModel;

class UsersController extends BaseController
{
    public function index()
    {
      return redirect()->route('signup');
        
    }

    public function do_register()
    {   
        if($this->session->get('logged_in')) return redirect()->to('students');

        if($this->request->getMethod() === 'POST'){
           
            $users = new UserModel();
            helper('uid');
            // Get the raw POST data
            $json = $this->request->getJSON();
           

            $name = $json->name;
            $email = $json->email;
            $password = $json->password;
            // Optionally hash the password
           $pass = md5($password); 
            $unique_id = generate_uid();
           
            $data = [
                'name' => $name,
                'email' => $email,
                'pass' => $pass,
                'uid'  => $unique_id,
                ];
                
            if ($users->save($data)) {
                return $this->response->setJSON(['status' => 'success']);
            } else {
                return $this->response->setJSON(['status' => 'error']);
            }
        }else{
        
            return 
            view('registration')
            .view('layout/footer');
        }  

    }

    public function do_login()
    {
        if($this->request->getMethod() === 'POST'){

            $users = new UserModel();
              // Get the raw POST data
              $json = $this->request->getJSON();
                $email = $json->email;
                $password = $json->pass;
                $pass = md5($password);
        
            $flag = $users->login($email,$pass); 
            if ($flag > 0) {
                $user_data = $users->where('email',$email)->first();
                $uid = $user_data['uid'];
                $this->session->set([
                    'logged_in' => true,
                    'email' => $email,
                    'uid' => $uid,
                    
                ]);
                return $this->response->setJSON(['status' => 'success']);
            } else {
                 return $this->response->setJSON(['status' => 'failed']);
            }

        }
        else{

            if($this->session->get('logged_in')) return redirect()->to('students');
            return view('login');
        
        }
     
    }
    public function logout() {
        $this->session->destroy();
        return redirect()->route('login');

    }
}