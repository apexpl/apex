<?php
declare(strict_types = 1);

namespace Etc\Core\Migrations\update_internal_tasks_1637275361;

use Apex\Migrations\Handlers\Migration;
use Apex\Db\Interfaces\DbInterface;

/**
 * Migration - update_internal_tasks_1637275361
 */
class migrate extends Migration
{

    /**
     * Whether or not to include this migration during initial package installation.
     * This should always be false, and instead you should update the main database schema 
     * as well at /etc/<PACKAGE>/install.sql with any modifications.
     */
    public bool $include_with_initial_install = false; 

    /**
     * Install
     */
    public function install(DbInterface $db):void
    {

        // Execute install.sql file
        $db->executeSqlFile(__DIR__ .'/install.sql');
    }

    /**
     * Remove
     */
    public function remove(DbInterface $db):void
    {

        // Execute SQL file
        $db->executeSqlFile(__DIR__ . '/remove.sql');
    }

}


