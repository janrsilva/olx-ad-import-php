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
            'Content-Type' => 'application/x-www-form-urlencoded',
            'Accept' => 'application/json'
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
        pre($results);

        return $results;
    }

    /**
     * @param  array $ads AdCollection
     * @return bool
     */
    public function publishAd(AdCollection $ads): bool
    {
        $arr = json_decode(json_encode($ads->toArray()), true);
        pre(
            'publishAd', $arr
        );
        $request_data = [
            'access_token' => $this->access_token,
            "ad_list" => json_decode(json_encode($ads->toArray()), true)
        ];

        $response = $this->client->put(
            '/autoupload/import',
            [
                'json' => $request_data,
                'headers' => [
                    'Content-Type' => 'application/json'
                ],
            ]
        );

        $result = json_decode(
            $response->getBody()->getContents(),
        );

        pre(
            $result
        );

        if ($result->statusCode < 0) {
            throw new \Exception($result->statusMessage, $result->statusCode);
        }

        return $result;
    }
}
