<?php

namespace App\Controllers;
use App\Models\StudentModel;

class StudentController extends BaseController
{
    public function add()
    {
        $Student= new StudentModel();
        $data['students'] = $Student->getStudent();
      
    }
    public function form()
    {
        return view('/layout/header')
               .view('addStudentForm')
               .view('layout/footer');
      
    }



    public function ajax($method)
    {
        $Student = new StudentModel();
        if ($method == 'delete') {
            $id = $this->request->getVar('id');
            $Student->delete($id);
            return $this->response->setJSON(['status' => 'success','message'=>'Delete Successfully']);
        }

       if($method=='add'){
        $Student = new StudentModel();
        $json = $this->request->getJSON();
        $student_uuid = $this->session->get('uid');
        $data = [
            'student_id' => $json->student_id,
            'name' => $json->name,  // Corrected here
            'phone' => $json->phone,
            'age' => $json->age,
            'uid' => $student_uuid,
        ];
       
        $flag = $Student->insert($data, false);
        if ($flag !== false) {
            return $this->response->setJSON(['status' => 'success']);
        }
    
        return $this->response->setJSON(['status' => 'error']);
       }

        if($method=='update'){
            $formData = $this->request->getJSON(true);
     
            $id = $this->request->getGet('id');
           
            
            $data = [
                'student_id'=>$formData['student_id'],
                'name' => $formData['name'],
                'phone' => $formData['phone'],
                'age' => $formData['age'],
            ];
         
        
           $flag = $Student->set($data)->where('id', $id)->update();

            if ($flag) {
                return $this->response->setJSON(['status' => 'success','message'=>'Edited Successfully']);
            } else {
                return $this->response->setJSON(['status' => 'failed','message'=>'Edit Faild']);
            }
        }

    }
}