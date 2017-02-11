<?php
    class Contact
    {
        private $contact_name;
        private $street_address;
        private $city_state_zip;
        private $phone;

        function __construct($new_contact_name, $new_street_address, $new_city_state_zip, $new_phone)
        {
            $this->setName($new_contact_name);
            $this->setStreetAddress($new_street_address);
            $this->setCityStateZip($new_city_state_zip);
            $this->setPhone($new_phone);
        }

        // Setters
        function setName($new_contact_name)
        {
            $this->contact_name = (string) $new_contact_name;
        }

        function setStreetAddress($new_street_address)
        {
            $this->street_address = (string) $new_street_address;
        }

        function setCityStateZip($new_city_state_zip)
        {
            $this->city_state_zip = (string) $new_city_state_zip;
        }

        function setPhone($new_phone)
        {
            $this->phone = (string) $new_phone;
        }

        // Getters
        function getName()
        {
            return $this->contact_name;
        }

        function getStreetAddress()
        {
            return $this->street_address;
        }

        function getCityStateZip()
        {
            return $this->city_state_zip;
        }

        function getPhone()
        {
            return $this->phone;
        }

        // Utility functions
        function save()
        {
            array_push($_SESSION[LIST_OF_CONTACTS], $this);
        }

        static function getAll()
        {
            return $_SESSION[LIST_OF_CONTACTS];
        }

        static function deleteAll()
        {
            $_SESSION[LIST_OF_CONTACTS] = array();
        }

        static function deleteOneContact($index_to_delete)
        {
            array_splice($_SESSION[LIST_OF_CONTACTS], $index_to_delete, 1);
        }

        static function contactByIndex($index)
        {
            return $_SESSION[LIST_OF_CONTACTS][$index];
        }

        static function updateContact($index, $contact)
        {
            $_SESSION[LIST_OF_CONTACTS][$index] = $contact;
        }
    }
?>
