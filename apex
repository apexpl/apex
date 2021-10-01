#!/usr/bin/env php
<?php
declare(strict_types = 1);

use Apex\App\App;
use Apex\App\Cli\Cli;

/**
 * Check the cwd and ensure we're currently inside an Apex installation 
 * directory in case we're executing from the environment path.
 */
$cwd = checkCwd();

/**
 * Load up composer, so we have access to all of our goodies. 
 */
require_once($cwd . '/vendor/autoload.php');

/**
 * Create our application, and get ready to handle the request.
 */
$app = new App();
$cntr = $app->getContainer();

// Run, and exit
$cli = $cntr->makeset(Cli::class);
$cli->run();

// Exit
exit(0);

/**
 * Check the CWD
 *
 * Get the current cwd, checks to ensure its a correct Apex installation.  Used 
 * when the 'apex' phar archive is located within the environment path.
 */
function checkCwd()
{

    // Get directory
    $dir = getcwd();
    if (!file_exists("$dir/boot/container.php")) {
        $dir = __DIR__;
    }

        // Check directory

    if (!file_exists("$dir/boot/container.php")) { die("Not in an Apex installation directory."); }
    if (!file_exists("$dir/vendor/autoload.php")) { die("Composer packages have not yet been installed.  Please first install with:  composer update"); }
    if (!file_exists("$dir/vendor/apex/armor/src/Armor.php")) { die("Not in an Apex installation directory."); }

    // Return
    return $dir;

}



