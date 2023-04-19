<?php
use App\Models\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Создает таблицу `comments`.
     *
     * @return void
     */
    public function up(): void
    {
        $this->db->query("
            CREATE TABLE `comments` (
                `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                `name` TEXT NOT NULL,
                `email` TEXT NOT NULL,
                `title` TEXT NOT NULL,
                `text` TEXT NOT NULL,
                `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
        ");
    }

    /**
     * Удаляет таблицу `comments`.
     *
     * @return void
     */
    public function down(): void
    {
        $this->db->query("DROP TABLE IF EXISTS `comments`;");
    }
}
