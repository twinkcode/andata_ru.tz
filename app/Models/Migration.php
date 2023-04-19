<?php
namespace App\Models;

abstract class Migration
{
    protected Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    abstract public function up();

    abstract public function down();
}
