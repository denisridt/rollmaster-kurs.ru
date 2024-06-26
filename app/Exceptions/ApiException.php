<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ApiException extends HttpResponseException
{
    public function __construct($code, $message, $errors = [])
    {
        $res = [
            'error' => [
                'code'    => $code,
                'message' => $message,
            ]
        ];
        if($errors) $res['error']['errors'] = $errors;

        parent::__construct(response($res, $code));
    }
}
