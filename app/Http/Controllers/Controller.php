<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function exceptionMessage($exception)
    {
        if (method_exists($exception, 'getMessageBag')) {
            return $exception->getMessageBag();
        } else {
            $message = $exception->getMessage();
            $response = trim(preg_replace('/\s\s+/', ' ', str_replace("\n", ' ', $message)));
        }

        return $response;
    }
}
