<?php
declare(strict_types = 1);

/**
 * Load Composer
 */
require_once(__DIR__ . '/../vendor/autoload.php');


/**
 * Instantiate Apex app
 */
$app = new \Apex\App\App();


/**
 * Process the http request.
 */
$response = $app->handle($app->getRequest());


/**
 * Output response to cline.t
 */
$app->outputResponse($response);


