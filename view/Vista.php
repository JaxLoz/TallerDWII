<?php

namespace view;

use util\HttpResponses;
use viewInterface;

require "view/viewInterface.php";
require "util/HttpResponses.php";

class vista implements viewInterface
{

    private HttpResponses $httpResponse;

    public function __construct()
    {
        $this->httpResponse = new HttpResponses();
    }

    public function showResponse($data, $tableName, $action)
    {
        if($data == null){
            $response = [
                "status code" => 404,
                "message" => "No $tableName $action"
            ];
        }else{
            $response = [
                "status code" => 200,
                "message" => "$tableName $action",
                "athletes" => $data
            ];
        }

        $this->httpResponse->httpResponse($response["status code"], "Content-Type: application/json", $response);
    }
}