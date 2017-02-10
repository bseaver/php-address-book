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

    $app->register(
        new Silex\Provider\TwigServiceProvider(),
        array('twig.path' => __DIR__.'/../views')
    );

    $app->get("/", function() use ($app) {
        return $app['twig']->render('contacts.html.twig', array('contacts' => Contact::getAll()));
    });

    $app->post("/create_contact", function() use ($app) {
        $contact = new Contact(
            $_POST['contact_name'], $_POST['street_address'],
            $_POST['city_state_zip'], $_POST['phone']
        );
        $contact->save();
        return $app['twig']->render('create_contact.html.twig', array('contact' => $contact));
    });

    $app->post("/delete_contacts", function() use ($app) {
        Contact::deleteAll();
        return $app['twig']->render('delete_contacts.html.twig');
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
