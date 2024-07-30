<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUidToStudentsTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('student', [
            'uid' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('student', 'uid');
    }
}
