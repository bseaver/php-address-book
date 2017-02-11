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
            array('edit_index' => '*', 'entry_error' => false, 'edit_contact' => $edit_contact, 'contacts' => Contact::getAll())
        );
    });


    function saveAndRenderContacts($app, $edit_index, $contact)
    {
        $next_template = 'contacts.html.twig';
        $entry_error = false;

        // Save or Update if Contact Name and at least one other field filled in
        if (
            $contact->getName() &&
            (
                $contact->getStreetAddress() ||
                $contact->getCityStateZip() ||
                $contact->getPhone()
                )
            ) {
            if ($edit_index == '*') {
                $contact->save();
                $next_template = 'create_contact.html.twig' ;
            } else {
                Contact::updateContact($edit_index, $contact);
                $contact = new Contact('', '', '', '');
                $edit_index = '*';
            }
        } else {
            $entry_error = true;
        }

        if ($next_template == 'contacts.html.twig') {
            $output = $app['twig']->render(
                $next_template,
                array(
                    'edit_index' => $edit_index,
                    'entry_error' => $entry_error,
                    'edit_contact' => $contact,
                    'contacts' => Contact::getAll()
                )
            );
        } elseif ($next_template = 'create_contact.html.twig') {
            $output = $app['twig']->render($next_template, array('contact' => $contact));
        }

        return $output;
    }


    $app->post('/', function() use ($app) {
        if (array_key_exists('add_contact_button', $_POST)) {
            $contact = new Contact(
                $_POST['contact_name'], $_POST['street_address'],
                $_POST['city_state_zip'], $_POST['phone']
            );
            return saveAndRenderContacts($app, '*', $contact);

        } elseif (array_key_exists('delete_all_contacts_button', $_POST)) {
            Contact::deleteAll();
            return $app['twig']->render('delete_contacts.html.twig');

        } elseif (array_key_exists('delete_one_contact_button', $_POST)) {
            $contact = new Contact(
                $_POST['contact_name'], $_POST['street_address'],
                $_POST['city_state_zip'], $_POST['phone']
            );
            Contact::deleteOneContact($_POST['delete_one_contact_button']);
            return $app['twig']->render(
                'contacts.html.twig',
                array(
                    'edit_index' => '*',
                    'entry_error' => false,
                    'edit_contact' => $contact,
                    'contacts' => Contact::getAll()
                )
            );

        } elseif (array_key_exists('edit_one_contact_button', $_POST)) {
            $edit_index = $_POST['edit_one_contact_button'];
            $contact = Contact::contactByIndex($edit_index);
            return $app['twig']->render(
                'contacts.html.twig',
                array(
                    'edit_index' => (string) $edit_index,
                    'entry_error' => false,
                    'edit_contact' => $contact,
                    'contacts' => Contact::getAll()
                )
            );

        } elseif (array_key_exists('update_contact_button', $_POST)) {
            $edit_index = $_POST['update_contact_button'];
            $contact = new Contact(
                $_POST['contact_name'], $_POST['street_address'],
                $_POST['city_state_zip'], $_POST['phone']
            );
            return saveAndRenderContacts($app, $edit_index, $contact);
        }
    });


    $app->get('/testContact', function() use ($app) {
        $output = '<a href="/">Feature not available, click to return to home page<a>';
        if ($app['debug']) {
            $output = testContact();
        }
        return $output;
    });

    return $app;
?>
