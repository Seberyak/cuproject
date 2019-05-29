<?php

namespace src\HttpUtils;

class Response
{
    public static function send(array $data, $code, $headers = [], $format = 'json'){
        foreach ($headers as $name => $item) {
            header(sprintf('%s:%s', $name, $item), true, $code);
        }
        if ($format === 'json') {
            header('Content-type: application/json', true, $code);
            echo json_encode($data);
        }
    }
}
