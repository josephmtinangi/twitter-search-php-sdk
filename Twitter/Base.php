<?php

namespace Twitter;

use GuzzleHttp\Client;

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

}
