<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client as Client;

Class Senator{

    private $client;

    /**
     * Senator constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSenators()
    {
        try {
            $response = $this->client->get('https://www.senate.gov/general/contact_information/senators_cfm.xml');
            $xml_string = simplexml_load_string((string) $response->getBody());
            $member_array = [];

            foreach ($xml_string->member as $member) {
                $member_array[] = (array) $member;
            }

            foreach ($member_array as $new_member){
                $exploded_address_array = explode(' ',  $new_member['address']);
                $street = $exploded_address_array[0]. " " .$exploded_address_array[1]. " " . $exploded_address_array[2]. " " . $exploded_address_array[3]. " " . $exploded_address_array[4];
                $address_array = [];
                $address_array[] = [
                    'street' => $street,
                    'city'   => $exploded_address_array[5],
                    'state'  => $exploded_address_array[6],
                    'postal' => $exploded_address_array[7]
                ];
                $new_member_array[] = [
                    'firstName' => $new_member['first_name'],
                    'lastName'  => $new_member['last_name'],
                    'fullName'  => $new_member['first_name'] . " " . $new_member['last_name'],
                    'chartId'   => $new_member['bioguide_id'],
                    'mobile'    => $new_member['phone'],
                    'address'   => $address_array
                ];
            }
            print_r(json_encode($new_member_array));
        } catch (\GuzzleHttp\Exception\GuzzleException $e) {
            echo $e->getMessage();
        }
    }
}

(new Senator())->getSenators();
