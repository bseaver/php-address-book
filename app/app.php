<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__.'/../vendor/autoload.php';
    require_once __DIR__.'/../src/Contact.php';
    require_once __DIR__.'/../test-src/testContact.php';

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

    $app->get('/', function() use ($app) {
        $edit_contact = new Contact('', '', '', '');

        return $app['twig']->render(
            'contacts.html.twig',
            array('edit_contact' => $edit_contact, 'contacts' => Contact::getAll())
        );
    });

    $app->post('/', function() use ($app) {
        if (array_key_exists('add_contact_button', $_POST)) {
            $contact = new Contact(
                $_POST['contact_name'], $_POST['street_address'],
                $_POST['city_state_zip'], $_POST['phone']
            );
            $contact->save();
            return $app['twig']->render('create_contact.html.twig', array('contact' => $contact));

        } elseif (array_key_exists('delete_all_contacts_button', $_POST)) {
            Contact::deleteAll();
            return $app['twig']->render('delete_contacts.html.twig');

        } elseif (array_key_exists('delete_one_contact_button', $_POST)) {
            $edit_contact = new Contact(
                $_POST['contact_name'], $_POST['street_address'],
                $_POST['city_state_zip'], $_POST['phone']
            );
            Contact::deleteOneContact($_POST['delete_one_contact_button']);
            return $app['twig']->render(
                'contacts.html.twig',
                array('edit_contact' => $edit_contact, 'contacts' => Contact::getAll())
            );
        }
    });

    $app->get('/testContact', function() use ($app) {
        $output = '<a href='/'>Feature not available, click to return to home page<a>';
        if ($app['debug']) {
            $output = testContact();
        }
        return $output;
    });

    return $app;
?>
