<?php

declare(strict_types=1);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

require __DIR__."/../vendor/autoload.php";

$request  = Request::createFromGlobals();
$response = new Response();

$map = [
    '/home' => 'home',
    '/products' => 'products',
    '/comments' => 'comments',
];

$path = $request->getPathInfo();

if (isset($map[$path])) {
    ob_start();

    extract($request->query->all(), EXTR_SKIP);
    include sprintf(__DIR__.'/../src/pages/%s.php', $map[$path]);

    $response->setContent(ob_get_clean());
} else {
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}

$response->send();

