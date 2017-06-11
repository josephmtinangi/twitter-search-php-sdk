<?php

namespace Twitter;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Base
{
    const API_URL = "https://api.twitter.com/1.1";

    protected $client;
    protected $token;
    protected $tokenSecret;
    protected $accessToken;

    /**
     * Base constructor.
     */
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param $token
     * @param $secret
     */
    public function setToken($token, $secret)
    {
        $this->token = $token;
        $this->tokenSecret = $secret;
    }

    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function prepareAccessToken()
    {
        try {
            $url = "https://api.twitter.com/oauth2/token";
            $value = ['grant_type' => "client_credentials"
            ];
            $header = array('Authorization' => 'Basic ' . base64_encode($this->token . ":" . $this->tokenSecret),
                "Content-Type" => "application/x-www-form-urlencoded;charset=UTF-8");
            $response = $this->client->post($url, ['query' => $value, 'headers' => $header]);
            $result = json_decode($response->getBody()->getContents());

            $this->accessToken = $result->access_token;
        } catch (RequestException $e) {
            $response = $this->statusCodeHandling($e);
            return $response;
        }
    }

    /**
     * @param $method
     * @param $request
     * @param array $post
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    protected function callTwitteAPI($method, $request, $post = [])
    {
        try {
            $this->prepareAccessToken();
            $url = self::API_URL . $request;
            $header = array('Authorization' => 'Bearer ' . $this->accessToken);
            $response = $this->client->request($method, $url, array('query' => $post, 'headers' => $header));
            return json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);
            return $response;
        }
    }

    protected function statusCodeHandling($e)
    {
        $response = array("statuscode" => $e->getResponse()->getStatusCode(),
            "error" => json_decode($e->getResponse()->getBody(true)->getContents()));
        return $response;
    }
}
