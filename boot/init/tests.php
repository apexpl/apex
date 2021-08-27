<?php

use Apex\App\App;
use Apex\App\Sys\Tests\Stubs\CliStub;

require_once(__DIR__ . '/../../vendor/autoload.php');
$app = new App();
$cntr = $app->getContainer();

// Set aliases
$cntr->addAlias(\Apex\App\Cli\Cli::class, CliStub::class);

// Set confdir env
$confdir = rtrim($_SERVER['HOME'], '/') . '/.config/apex-test';
PutEnv('APEX_CONFDIR=' . $confdir);


