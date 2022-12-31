<?php
declare(strict_types = 1);

namespace Etc\Core;

use Apex\Migrations\Handlers\Migration;
use Apex\Db\Interfaces\DbInterface;
use redis;

/**
 * Installation migration file for the package Demo.
 *
 * Although recommended, if you do not wish to use SQL, Eloquent and Doctrine 
 * migrations are also available.  For details, please see:
 *     https://apexpl.io/docs/database/migrations
 */
class migrate extends Migration
{

    /**
     * Install package
     */
    public function install(DbInterface $db):void
    {

        // Execute install.sql file
        $db->executeSqlFile(__DIR__ .'/install.sql');
    }

    /**
     * Remove package
     */
    public function remove(DbInterface $db):void
    {

        // Execute SQL file
        $db->executeSqlFile(__DIR__ . '/remove.sql');
    }

    /**
     * Reset package to state after installation.
     */
    public function reset(DbInterface $db):void
    {

        // Execute SQL file
        $db->executeSqlFile(__DIR__ . '/reset.sql');
    }

    /**
     * Reset redis keys within package.
     *
     * Exected when the CLI command 'apex sys reset-redis' isrun.
     * This should assume redis instance has been wiped, pull all necessary info from SQL database, 
     * and recreate the redis keys as necessary for this package.
     */
    public function resetRedis(DbInterface $db, redis $redis):void
    {

        // Delete keys
        $redis->del('config');

        // Go through config
        $rows = $db->query("SELECT * FROM internal_config");
        foreach ($rows as $row) { 
            $key = $row['package'] . '.' . $row['alias'];
            $redis->hset('config', $key, $row['value']);
        }

    }


}


