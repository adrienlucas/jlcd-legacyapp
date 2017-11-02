<?php

// Routing and main controller
$_pages = [
    '' => 'home',
    '/' => 'home',
    '/hello' => 'hello_name',
    '/exit' => 'redirect_to_google',
];

$request = $_SERVER['PATH_INFO'];
if(array_key_exists($request, $_pages)) {
    $controller = sprintf('acme_page_%s', $_pages[$request]);
    echo "<html><body>";
    $controller();
    echo "</body></html>";
} else {
    http_response_code(404);
    printf('Page "%s" not found.', $request);
}

// Pages controllers
function acme_page_home() {
    echo 'Welcome to ACME official website !<br/>';
    echo '<ul><li><a href="/hello">Come and let us greet you !</a></li>'.
        '<li><a href="/exit">Exit this website</a></li></ul>';
}

function acme_page_hello_name() {
    $name = isset($_GET['name']) ? $_GET['name'] : false;
    if(empty($name)) {
        echo 'Tell us your name : <form><input name="name" /><form>';
    } else {
        printf('Hi %s ! Nice to see you !', $name);
    }
}

function acme_page_redirect_to_google() {
    http_response_code(302);
    header('Location: http://google.fr');
}
