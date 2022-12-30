<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function sendResponse($result, $message){
        $response = ['success' => true, 'result' => $result, 'message' => $message ];
        return response()->json($response, 200);
    }

    public function sendError($error, $errorMessages = [], $code = 200){
        $response = ['success' => false,'message' => $error];
        if (!empty($errorMessages)) { $response['result'] = $errorMessages;}
        return response()->json($response, $code);
    }
}
