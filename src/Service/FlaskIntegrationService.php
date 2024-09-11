<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class FlaskIntegrationService
{
    private $flaskEndpoint;

    public function __construct(string $flaskEndpoint)
    {
        $this->flaskEndpoint = $flaskEndpoint;
    }

    public function executeFlaskAPI(array $data, string $endpoint): array
    {
        $httpClient = HttpClient::create();

        $response = $httpClient->request(
            'POST',
            $this->flaskEndpoint . $endpoint,
            [
                'json' => $data,
                'timeout' => 60, // Increase timeout if necessary
            ]
        );

        return $response->toArray();
    }
}
