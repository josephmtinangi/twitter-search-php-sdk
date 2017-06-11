<?php

namespace Twitter\Search;

use Twitter\Base;
use GuzzleHttp\Exception\RequestException;

/**
 *
 */
class Search extends Base
{

    /**
     * @param $value
     * @return array
     */
    public function search($value)
    {
        try {
            $url = "/search/tweets.json";
            $response = $this->callTwitteAPI("get", $url, $value);
            return $response;
        } catch (RequestException $e) {
            $response = $this->StatusCodeHandling($e);
            return $response;
        }
    }
}