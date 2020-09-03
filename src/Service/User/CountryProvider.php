<?php


namespace App\Service\User;


use App\Service\RestClient;

/**
 * Provide the list of all countries
 * Class CountryProvider
 * @package App\Service\User
 */
class CountryProvider
{

    private CONST COUNTRY_API_URL = "https://restcountries.eu/rest/v2/all";

    /**
     * @var RestClient
     */
    private RestClient $client;

    /**
     * CountryProvider constructor.
     * @param RestClient $client
     */
    public function __construct(RestClient $client)
    {
        $this->client = $client;
    }


    /**
     * Return this list of all existing countries
     * @return array
     */
    public function getCountryList(): array
    {
        $data = $this->client->get(self::COUNTRY_API_URL);
        $countries = array();
        foreach($data as $element) {
            array_push($countries, $element["name"]);
        }
        return $countries;
    }

}