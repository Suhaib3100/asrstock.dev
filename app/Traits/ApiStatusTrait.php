<?php

namespace App\Traits;


trait ApiStatusTrait
{
    public $successStatus = 200;
    public $failureStatus = 500;
    public $validationFailureStatus = 422;
    public $notAllowedStatus = 401;
    public $notFoundStatus = 404;
    public $alreadyFoundStatus = 409;
    public $accessibleStatus = 209;

    public function successApiResponse($response){
        return response()->json($response,$this->successStatus);
    }

    public function success($data=[],$msg=FETCH_DATA_SUCCESSFULLY){
        $response['status'] = true;
        $response['success'] = true;
        $response['message'] = $msg;
        $response['data'] = $data;
        return response()->json($response,$this->successStatus);
    }

    public function failed($data=[],$msg=SOMETHING_WENT_WRONG){
        $response['status'] = true;
        $response['success'] = false;
        $response['message'] = $msg;
        $response['data'] = $data;
        return response()->json($response,$this->validationFailureStatus);
    }

    public function failureApiResponse($response){
        return response()->json($response,$this->failureStatus);
    }

    public function validationfailureApiResponse($response){
        return response()->json($response,$this->validationFailureStatus);
    }

    public function notAllowedApiResponse($response){
        return response()->json($response,$this->notAllowedStatus);
    }

    public function notFoundApiResponse($response){
        return response()->json($response,$this->notFoundStatus);
    }

    public function alreadyFoundApiResponse($response){
        return response()->json($response,$this->alreadyFoundStatus);
    }

    public function accessibleApiResponse($response){
        return response()->json($response,$this->accessibleStatus);
    }
}
