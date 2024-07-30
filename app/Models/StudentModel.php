<?php

namespace App\Models;

use CodeIgniter\Model;

class StudentModel extends Model
{
    protected $table            = 'student';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = false;
    protected $allowedFields    = [];

    public function getStudent() {
      return $this->select('name,id,phone,age')->findAll();
   }

  // public function add($data) {
    //   $this->db->insert('student');
  // }

   
   

}