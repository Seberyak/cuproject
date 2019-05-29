<?php

namespace src\HttpUtils;

class Request
{
    public $server;
    public $headers;
    public $query;
    public $body;
    public $request;

    public function __construct()
    {
        $this->headers = new \stdClass();
        $this->server = new \stdClass();
        $this->query = new \stdClass();
        $this->body = new \stdClass();
        $this->request = new \stdClass();
    }

    public static function Create()
    {
        $request = new static();
        $server = $_SERVER;

        foreach ($server as $name => $value) {
            if (0 === strpos($name, 'HTTP_')) {
                $request->headers->{$request::camelize($request::normalizeServerNames($name))} = $value;
            }else {
                $request->server->{$request::camelize($request::normalizeServerNames($name, true))} = $value;
            }
        }

        if ($get = $_GET) {
            foreach ($get as $name => $value) {
                $request->query->{$name} = $value;
            }
        }
        if ($post = $_POST) {
            foreach ($post as $name => $value) {
                $request->request->{$name} = $value;
            }
        }

        if (isset($request->headers->contentType)) {
            if ($request->headers->contentType === 'application/json' && $content_str = file_get_contents('php://input')) {
                $content = json_decode($content_str);
                if (JSON_ERROR_NONE === json_last_error()) {
                    $request->body = $content;
                }
            }
        }

        return $request;
    }

    public function __set($name, $value)
    {
        $this->$name = $value;
    }

    public function __get($name)
    {
        return $this->$name ?? NULL;
    }

    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    private static function camelize($str) {
        $str = preg_replace('/[^a-z0-9]+/i', ' ', $str);
        $str = trim($str);
        $str = ucwords($str);
        $str = str_replace(' ', '', $str);
        $str = lcfirst($str);

        return $str;
    }

    private static function normalizeServerNames($str, $no_http = false) {
        $str = str_replace('_', ' ', !$no_http ? substr($str, 5): $str);
        $str = ucwords(strtolower($str));
        $str = str_replace(' ', '-', $str);

        return $str;
    }
}
