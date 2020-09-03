<?php


namespace App\Service;


use Exception;
use GeoIp2\Database\Reader;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class DataProvider
 * @package App\Service
 */
class DataProvider
{

    private CONST COUNTRY_API_URL = "https://restcountries.eu/rest/v2/all";

    /**
     * @var RestClient
     */
    private RestClient $client;

    /**
     * @var ParameterBagInterface
     */
    private ParameterBagInterface $parameters;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * CountryProvider constructor.
     * @param RestClient $client
     * @param ParameterBagInterface $parameters
     * @param LoggerInterface $logger
     */
    public function __construct(RestClient $client, ParameterBagInterface $parameters, LoggerInterface $logger)
    {
        $this->client = $client;
        $this->parameters = $parameters;
        $this->logger = $logger;
    }


    /**
     * Return the country name from a request ip
     * @param string $ip
     * @return string|null
     */
    public function getCountryFromIp(string $ip): ?string
    {
        try {
            $reader = new Reader($this->parameters->get("geo_lite_path"));
            return $reader->country($ip)->country->name;
        } catch (Exception $e) {
            $this->logger->alert($e->getMessage());
        }
        return null;
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

    /**
     * Return the list of all existing jobs
     * @return array
     */
    public function getJobList(): array
    {
        return array("Developer", "Engineer", "Manager", "Farmer", "Aeronautics", " Food and catering", " Agriculture",
            "Hunting", "Fishing and breeding", "Crafts", "Arts and entertainment", "Construction", "Commerce",
            "Law", "Publishing", "Teaching and research", "Business", "Maintenance", "Finance", "Printing",
            "Industry", "Computing", "Language and writing", "Marketing and communication", "Media", "Politics",
            "Funeral directors", "Health", "Science", "Security", "Social", "Sport", "Tourism",
            "Transport and logistics", "Illegal activities", "Source");
    }
}