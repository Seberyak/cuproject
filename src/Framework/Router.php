<?php
namespace src\Framework;

use src\HttpUtils\Request;

class Router
{

    private static $routes = [];

    public static function add($pattern, $callback) {
        $pattern = '/^' . str_replace('/', '\/', $pattern) . '$/';
        self::$routes[$pattern] = $callback;
    }

    public static function run(Request $request)
    {
        foreach (self::$routes as $pattern => $callback) {
            if (preg_match($pattern, $request->server->requestUri, $params)) {
                array_shift($params);
                return call_user_func_array($callback, array_merge([$request], array_values($params)));
            }
        }
    }
}
