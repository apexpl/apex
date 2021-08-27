<?php

use Apex\App\Sys\Boot\ErrorHandlers;
use Apex\App\Exceptions\ApexBootloaderException;

// Define site_path
define('SITE_PATH', realpath(__DIR__ . '/../../'));

// Load environment variables
$env_lines = file_exists(SITE_PATH . '/.env') ? file(SITE_PATH . '/.env') : [];
foreach ($env_lines as $line) { 

    if ($line == '' || !preg_match("/^(\w+)(\s*?)\=(.+)$/", $line, $match)) { 
        continue;
    }
    if (!putEnv($match[1] . '=' . trim($match[3]))) { 
        throw new ApexBootloaderException(tr("Unable to add the following environment variable line from the .env file, {1}", $line));
    }
}

// Set time zone
date_default_timezone_set('UTC');

// Set error reporting
$error_handlers = new ErrorHandlers();
error_reporting(E_ALL);
set_error_handler([$error_handlers, 'error']);
set_exception_handler([$error_handlers, 'handleException']);

// Set INI variables
ini_set('pcre.backtrack_limit', '4M');
ini_set('zlib.output_compression_level', '2');

function tr($msg, ...$vars) {
    return $msg;
}

