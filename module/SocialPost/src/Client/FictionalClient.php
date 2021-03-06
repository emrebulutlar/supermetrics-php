<?php

namespace SocialPost\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Utils;
use SocialPost\Exception\InvalidTokenException;

/**
 * Class FictionalClient
 * @package SocialPost\Client
 */
class FictionalClient implements SocialClientInterface
{
    /**
     * FictionalSocialApiClient constructor.
     *
     * @param Client $client
     * @param string $clientId
     */
    public function __construct(
        private readonly Client $client,
        private readonly string $clientId
    ) {
    }

    /**
     * @param string $url
     * @param array $parameters
     *
     * @return string
     * @throws GuzzleException
     */
    public function get(string $url, array $parameters): string
    {
        return $this->request('GET', $url, [], $parameters);
    }

    /**
     * @param string $url
     * @param array $body
     *
     * @return string
     * @throws GuzzleException
     */
    public function post(string $url, array $body): string
    {
        $headers = ['Content-Type' => 'application/json'];

        return $this->request('POST', $url, $headers, [], $body);
    }

    /**
     * @param string $url
     * @param array $body
     *
     * @return string
     * @throws GuzzleException
     */
    public function authRequest(string $url, array $body): string
    {
        $body['client_id'] = $this->clientId;

        return $this->post($url, $body);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $headers
     * @param array $parameters
     * @param array $body
     *
     * @return string
     * @throws GuzzleException
     */
    protected function request(string $method, string $url, array $headers, array $parameters, array $body = []): string
    {
        if (!empty($parameters)) {
            $url = sprintf('%s?%s', $url, http_build_query($parameters));
        }

        $body = empty($body) ? null : json_encode($body);

        $request = new Request($method, $url, $headers, $body);

        try {
            $response = $this->client->send($request);
        } catch (ServerException $exception) {
            if ($this->isTokenInvalid($exception)) {
                throw new InvalidTokenException();
            }

            throw $exception;
        }

        return $response->getBody()->getContents();
    }

    /**
     * @param ServerException $exception
     *
     * @return bool
     */
    protected function isTokenInvalid(ServerException $exception): bool
    {
        $response = Utils::jsonDecode(
            $exception->getResponse()->getBody()->getContents(),
            true
        );

        if (!isset($response['error']['message'])
            || 'Invalid SL Token' !== $response['error']['message']
        ) {
            return false;
        }

        return true;
    }
}
