<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStudentIdToYourTableName extends Migration
{
    public function up()
    {
        $this->forge->addColumn('student', [
            'student_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('student', 'student_id');
    }
}
