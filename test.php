<?php

// Test 404
ob_start();
$_GET = $_SERVER = [];
$_SERVER['PATH_INFO'] = '/gimme404';
include('./index.php');
$content = ob_get_clean();

if(strpos($content, 'Page "/gimme404" not found') === false) {
    throw new \Exception('Test 404 failed');
}

// Test home controller
ob_start();
$_GET = $_SERVER = [];
acme_page_home();
$content = ob_get_clean();

if(strpos($content, 'Welcome to ACME') === false) {
    throw new \Exception('Test home failed');
}

// Test greetings controller
ob_start();
$_GET = $_SERVER = [];
$_GET['name'] = 'tester';
acme_page_hello_name();
$content = ob_get_clean();

if(strpos($content, 'Hi tester !') === false) {
    throw new \Exception('Test greetings failed');
}

echo "All test passed !";
exit(0);