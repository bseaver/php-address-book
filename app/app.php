<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Contact.php";
    require_once __DIR__."/../test-src/testContact.php";

    session_start();
    define('LIST_OF_CONTACTS', 'list_of_contacts');
    if (empty($_SESSION[LIST_OF_CONTACTS])) {
        $_SESSION[LIST_OF_CONTACTS] = array();
    }

    $app = new Silex\Application();

    $app['debug'] = true;

    $app->get("/", function() {
        return "Hello";
    });

    $app->get("/testContact", function() use ($app) {
        $output = "<a href='/'>Feature not available, click to return to home page<a>";
        if ($app['debug']) {
            $output = testContact();
        }
        return $output;
    });

    return $app;
?>
