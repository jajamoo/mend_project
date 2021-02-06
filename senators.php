<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client as Client;

Class Senator{

    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getSenators()
    {
        $response = $this->client->get('https://www.senate.gov/general/contact_information/senators_cfm.xml');
        $xml_string = simplexml_load_string((string) $response->getBody());
        $member_array = [];

        foreach ($xml_string->member as $member) {
            $member_array[] = (array) $member;
        }

        foreach ($member_array as $new_member){
            $exploded_address_array = explode(' ', (string) $new_member['address']);
            $street = $exploded_address_array[0]. " " .$exploded_address_array[1]. " " . $exploded_address_array[2]. " " . $exploded_address_array[3]. " " . $exploded_address_array[4]. " " ;
            $new_member_array[] = [
                'firstName' => (string) $new_member['first_name'],
                'lastName' => (string) $new_member['last_name'],
                'fullName' => (string) $new_member['first_name'] . " " . $new_member['last_name'],
                'chartId' => (string) $new_member['bioguide_id'],
                'mobile' => (string) $new_member['phone'],
                'address' => [
                    'street' => $street,
                    'city' => $exploded_address_array[5],
                    'state' => $exploded_address_array[6],
                    'zip' => $exploded_address_array[7],
                ]
            ];
        }

        print_r(json_encode($new_member_array));
    }
}

(new Senator())->getSenators();

//print_r(json_encode($new_member_array));
