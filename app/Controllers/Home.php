<?php

namespace App\Controllers;
use App\Models\StudentModel;
class Home extends BaseController
{
    public function index()
    {
        
        if($this->session->get('logged_in')) {
         return view('/layout/header')
        .view('students')
        .view('/layout/footer');
        }else  return redirect()->route('login');

        
    }
  
  
    public function ajax(){
        $studentModel = new StudentModel();
        $uid = $this->session->get('uid');
        
        // Number of items per page
        $perPage = 5;
    
        // Get the current page number from the query string
        $page = $this->request->getVar('page') ?: 1;
    
        // Fetch the paginated results
        $students = $studentModel->where('uid', $uid)->paginate($perPage, 'group1', $page);
    
        // Get the pager links if needed (optional)
        $pager = $studentModel->pager;
        $pagerLinks = $pager->links('group1', 'default_full');
    
        // Prepare the response data
        $data = [
            'students' => $students,
            'pager' => $pagerLinks,
            'currentPage' => $page,
            'totalPages' => $pager->getPageCount('group1')
        ];
    
        return $this->response->setJSON($data);
    }
    


}