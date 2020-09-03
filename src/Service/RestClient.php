<?php


namespace App\Service;


use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * Rest client executing Rest requests
 * Class RestClient
 * @package App\Service
 */
class RestClient
{

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $client;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * RestClient constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->client = HttpClient::create();
        $this->logger = $logger;
    }


    /**
     * Execute a GET api method on a url and return the content as an associative array
     * @param string $url
     * @return array
     */
    public function get(string $url): array
    {
        try {
            $response = $this->client->request('GET', $url);
            return json_decode($response->getContent(), true);
        } catch (TransportExceptionInterface $e) {
            $this->logger->alert($e->getMessage());
        } catch (HttpExceptionInterface $e) {
            $this->logger->alert($e->getMessage());
        }
        return array();
    }

}