<?php

require 'vendor/autoload.php';


use src\Framework\Router;
use src\HttpUtils\Request;
use src\HttpUtils\Response;
use src\LoginPage\login;

spl_autoload_register(function ($class){
    $source = __DIR__ . DIRECTORY_SEPARATOR . 'src';
    $replace = str_replace(array('CST', '\\'), array($source, DIRECTORY_SEPARATOR), $class);
    $file = $replace . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
$request = Request::Create();

Router::add('/', function (Request $request) {
    Response::send([
        'route' => 'index'
    ], 200);
});


Router::add('/(\w+)', function (Request $request, $name) {
    Response::send([
        'route' => $name
    ], 200);
});

Router::run($request);


$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader);
echo $twig->render('working_template.html',array(
    'name' => 'ვალერა',
    'age'  => 20,
    'email' => 'v_liparteliani@cu.edu.ge',
    'sex' => 'მამრობითი',
  ));
