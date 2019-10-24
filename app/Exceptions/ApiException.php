<?php
namespace App\Exceptions;

use Illuminate\Http\Response;

class ApiException extends \Exception
{
    function __construct($message='',$code = Response::HTTP_BAD_REQUEST)
    {
        parent::__construct($message,$code);
    }
}