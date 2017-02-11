# Address Book with Silex and Twig

#### Epicodus PHP Week 1 Code Review, 2/10/2017

#### By Benjamin T. Seaver

## Description

This projects demonstrates building an app using PHP and the Silex and Twig frameworks.

## Setup/Installation Requirements
* Clone project
* Run `composer install --prefer-source --no-interaction` from project root
* (See https://getcomposer.org for details on installing _composer_)
* Start PHP in web folder: Example web $ `php -S localhost:8000`
* (See https://secure.php.net/ for details on installing _PHP_)
* In web browser open `localhost:8000`

## Known Bugs
* No known bugs

## Support and contact details
* No support

## Technologies Used
* PHP
* Composer
* Silex
* Twig
* HTML
* CSS
* Bootstrap
* Git

## Copyright (c)
* 2017 Benjamin T. Seaver

## License
* MIT

## Specifications
* Phase 1 - Dependencies and .gitignore
* Phase 2 - Initial Silex framework with "Hello" on home page
* Phase 3 - Contact class: name, street_address, city_state_zip, phone
* Phase 3a- Contact save() stores contact in $_SESSION['list_of_contacts']
* Phase 3b- Test Routine: Save two contacts, list all and delete.
* Phase 4 - Twig pages on home, /create_contact and /delete_contacts
* Phase 4a- Verify buttons on home goto to create and delete pages
* Phase 4b- Verify links on create and delete go back to home page
* Phase 5 - On home submit contact button, new address is displayed
* Phase 6 - On new address link back to home, all added addresses are displayed
* Phase 7 - On Address book cleared page, link returns home with no addresses

### If time allows:

* Phase 8 - Style pages with resources in web folder
* Phase 9 - Create an individual address delete button
* Phase 10 - Use single quotes consistently where PHP variable replacement is not needed
* Phase 11 - Prevent entry of a contact without a Name and one other piece of information
* Phase 12 - Make individual addresses editable

* End specifications
