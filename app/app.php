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
        return $app['twig']->render(
            'contacts.html.twig',
            array('edit_index' => '*',
                'entry_error' => false,
                'edit_contact' => new Contact('', '', '', ''),
                'contacts' => Contact::getAll()
            )
        );
    });


    $app->post('/', function() use ($app) {
        $contact = new Contact(
            $_POST['contact_name'], $_POST['street_address'],
            $_POST['city_state_zip'], $_POST['phone']
        );
        $isAdd = false;
        $isEdit = false;
        $next_template = 'contacts.html.twig';
        // Asterix means adding a contact, not editing a contact
        $edit_index = '*';
        $entry_error = false;

        if (array_key_exists('add_contact_button', $_POST)) {
            $isAdd = true;
        }

        if (array_key_exists('delete_all_contacts_button', $_POST)) {
            Contact::deleteAll();
            $next_template = 'delete_contacts.html.twig';
        }

        if (array_key_exists('delete_one_contact_button', $_POST)) {
            Contact::deleteOneContact($_POST['delete_one_contact_button']);
        }

        if (array_key_exists('edit_one_contact_button', $_POST)) {
            $edit_index = $_POST['edit_one_contact_button'];
            $contact = Contact::contactByIndex($edit_index);
        }

        if (array_key_exists('update_contact_button', $_POST)) {
            $isEdit = true;
            $edit_index = $_POST['update_contact_button'];
        }

        if ($isAdd || $isEdit) {
            // Valid entry needs Name and at least one other bit of info
            $entry_error = !$contact->getName();
            if (!$entry_error) {
                $entry_error = $contact->getStreetAddress() || $contact->getCityStateZip() || $contact->getPhone();
            }
        }

        if (!$entry_error) {
            if ($isAdd) {
                $contact->save();
                $next_template = 'create_contact.html.twig' ;
            }

            if ($isEdit) {
                Contact::updateContact($edit_index, $contact);
                $contact = new Contact('', '', '', '');
                $edit_index = '*';
            }
        }

        return $app['twig']->render(
            $next_template,
            array(
                'edit_index' => '*',
                'entry_error' => false,
                'edit_contact' => $contact,
                'contacts' => Contact::getAll()
            )
        );
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
