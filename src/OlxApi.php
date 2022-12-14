<?php

namespace Janrsilva\OlxAdImport;

use GuzzleHttp\Client;
use Janrsilva\OlxAdImport\PublishedAd;

/**
 * OlxApi
 * HTTP Client for Olx API
 *
 * @author janrsilva <janderson.rdsilva@gmail.com>
 */
class OlxApi
{
    const BASE_URI = 'https://apps.olx.com.br';

    private $access_token;
    private $client;

    /**
     *
     * @var string $accessToken - access token from Olx API
     */
    public function __construct(string $access_token)
    {
        $this->access_token = $access_token;

        $headers = [
            'Accept' => 'application/json',
            'User-Agent'=> 'GuzzleHttp/6.5.5 Janrsilva/OlxAdImport/0.0.9',
        ];

        $this->client = new Client(
            [
                'base_uri' => self::BASE_URI,
                'headers' => $headers
            ]
        );
    }

    /**
     * @return any
     */
    public function getBasicInfo()
    {
        $request_data = [
            'access_token' => $this->access_token
        ];

        $response = $this->client->post(
            '/oauth_api/basic_user_info',
            [
                'json' => $request_data
            ]
        );

        return $response->getBody()->getContents();
    }

    /**
     * @return PublishedAdCollection
     */
    public function getPublishedAds(): PublishedAdCollection
    {
        $request_data = [
            'access_token' => $this->access_token
        ];

        $response = $this->client->post(
            '/autoupload/published',
            [
                'json' => $request_data
            ]
        );

        $results = $response->getBody()->getContents();
        $ads = [];
        foreach (json_decode($results, true) as $result) {
            $ads[] = PublishedAd::fromArray($result);
        }

        return new PublishedAdCollection(...$ads);
    }

    /**
     * @return PublishedAdCollection
     */
    public function getPublishingStatus(string $operationToken)
    {
        $request_data = [
            'access_token' => $this->access_token
        ];

        $response = $this->client->post(
            "/autoupload/import/$operationToken",
            [
                'json' => $request_data
            ]
        );

        $results = $response->getBody()->getContents();

        return $results;
    }

    public function getCubiccmsInfo()
    {
        $request_data = [
            'access_token' => $this->access_token,
        ];

        $response = $this->client->post(
            '/autoupload/moto_cubiccms_info',
            [
                'json' => $request_data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
            ]
        );

        $result = json_decode(
            $response->getBody()->getContents(),
        );

        if ($response->getStatusCode() < 0) {
            throw new \Exception($result->statusMessage, $result->statusCode);
        }

        return $result;
    }
    /**
     * @param  array $ads AdCollection
     * @return bool
     */
    public function publishAd(AdCollection $ads): string
    {
        $request_data = [
            'access_token' => $this->access_token,
            "ad_list" => json_decode(json_encode($ads->toArray()), true)
        ];

        $response = $this->client->put(
            '/autoupload/import',
            [
                'json' => $request_data,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json'
                ],
            ]
        );

        $result = json_decode(
            $response->getBody()->getContents(),
        );

        if ($response->getStatusCode() < 0) {
            throw new \Exception($result->statusMessage, $result->statusCode);
        }

        return $result->token;
    }
}
