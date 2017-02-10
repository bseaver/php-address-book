<?php
    function testContact ()
    {
        $output = "Testing Contact Class <br>";

        $output .= "<br> ==> Initial list all <==";
        $output .= testContactsOutput(Contact::getAll());

        $output .= "<br> ==> Add one and list all <==";
        $contact = new Contact("Person One", "One Street", "One City ST 97000", "503-555-1111");
        $contact->save();
        $output .= testContactsOutput(Contact::getAll());

        $output .= "<br> ==> Add a second and list all <==";
        $contact = new Contact("Person Two", "Two Street", "Two City ST 97000", "503-555-2222");
        $contact->save();
        $output .= testContactsOutput(Contact::getAll());

        $output .= "<br> ==> Delete all then list all <==";
        $contact = Contact::deleteAll();
        $output .= testContactsOutput(Contact::getAll());

        return $output;
    }

    function testContactOutput($contact){
        $output = "";
        $output .= "<br> Name: " . $contact->getName();
        $output .= "<br> Street Address: " . $contact->getStreetAddress();
        $output .= "<br> City State Zip: " . $contact->getCityStateZip();
        $output .= "<br> Phone: " . $contact->getPhone();
        $output .= "<br>";
        return $output;
    }

    function testContactsOutput($contacts){
        $output = "";
        if ($contacts) {
            foreach ($contacts as $contact) {
                $output .= testContactOutput($contact);
            }
        } else {
            $output .= "<br> No contacts in list.";
        }
        $output .= "<br>";
        return $output;
    }
?>
