<?php

require('vendor/autoload.php');

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$request = Request::createFromGlobals();
$response = new Response();

// Routing and main controller
$_pages = [
    '' => 'home',
    '/' => 'home',
    '/hello' => 'hello_name',
    '/exit' => 'redirect_to_google',
];

$requestedPage = $request->getPathInfo();
if(array_key_exists($requestedPage, $_pages)) {
    $controller = sprintf('acme_page_%s', $_pages[$requestedPage]);
    $controllerResponse = $controller($request);
    if(is_a($controllerResponse, Response::class)) {
        $response = $controllerResponse;
    } else {
        $response->setContent(sprintf('<html><body>%s</body></html>', $controllerResponse));
    }
} else {
    $response->setStatusCode(Response::HTTP_NOT_FOUND);
    $response->setContent(sprintf('Page "%s" not found.', $requestedPage));
}

$response->send();

// Pages controllers
function acme_page_home() {
    return 'Welcome to ACME official website !<br/>'
        .'<ul><li><a href="/hello">Come and let us greet you !</a></li>'
        .'<li><a href="/exit">Exit this website</a></li></ul>';
}

function acme_page_hello_name(Request $request) {
    $name = $request->get('name', false);
    if(empty($name)) {
        return 'Tell us your name : <form><input name="name" /><form>';
    } else {
        return sprintf('Hi %s ! Nice to see you !', $name);
    }
}

function acme_page_redirect_to_google() {
    return new RedirectResponse('http://smile.eu');
}
