<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Fire Error Message
     *
     * @param [type] $message
     * @param [type] $code
     *
     * @return void
     */
    public function fireError($message , $code){
        return response()->json([
            'status' => false,
            'message' => $message,
        ] , $code);
    }
}
