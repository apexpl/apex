<?php
declare(strict_types = 1);

namespace apex\app\exceptions;

use apex\app;
use apex\app\exceptions\ApexException;


/**
 * Handles various form errors, such as simple validation errors that call for 
 */
class FormException   extends ApexException
{

    // Properties
    private $error_codes = array(
        'field_required' => "The form field {field} was left blank, and is required"
    );

/**
 * Construct
 *
 * @param string $message The exception message
 * @param string $field The alias of the form field. 
 */
public function __construct($message, $field = '')
{ 

    // Set variables
    $vars = array(
        'field' => $field
    );

    // Get message
    $this->log_level = 'error';
    $this->code = 500;
    $this->message = $this->error_codes[$message] ?? $message;
    $this->message = tr($this->message, $vars);

}


}

