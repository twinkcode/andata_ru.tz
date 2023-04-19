<?php
/**
 * File that runs database migrations
 */

require_once __DIR__.'/../app/Models/Database.php';
require_once __DIR__.'/../app/Models/Migration.php';

use App\Models\Database;

$db = new Database();

require_once __DIR__.'/migrations/create_comments_table.php';

$commentsTableMigration = new CreateCommentsTable($db);
isset($argv[1]) && $argv[1] == 'down'
    ? $commentsTableMigration->down()
    : $commentsTableMigration->up();
