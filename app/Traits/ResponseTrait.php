<?php

namespace App\Traits;


trait ResponseTrait
{
    protected $success = 200;
    protected $error = 500;

    public $response = ['status' => false, 'data' => [], 'message' => ''];

    public function success($data = [], $message = NULL)
    {
        $this->response['status'] = true;
        $this->response['data'] = $data;
        $this->response['message'] = !is_null($message) ? $message : getMessage(DATA_FETCH_SUCCESSFULLY);
        return response()->json($this->response, $this->success);
    }

    public function error($data = [], $message = NULL)
    {
        $this->response['status'] = false;
        $this->response['data'] = $data;
        $this->response['message'] = !is_null($message) ? $message : getMessage(SOMETHING_WENT_WRONG);
        return response()->json($this->response, $this->error);
    }
}
