<?php

namespace App\Exception;

use Exception;

class FileUploadException extends Exception
{
    protected $message = 'File upload exception';
}