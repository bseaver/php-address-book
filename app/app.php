<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../test-src/testContact.php";

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
