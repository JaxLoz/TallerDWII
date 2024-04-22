<?php

namespace util;

class HttpResponses
{
    public function httpResponse(int $code, string $header, $date)
    {
        http_response_code($code);
        header($header);
        echo json_encode($date);
    }
}