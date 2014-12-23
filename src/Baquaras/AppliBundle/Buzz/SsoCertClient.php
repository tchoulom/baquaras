<?php

namespace Baquaras\AppliBundle\Buzz;

use Buzz\Client\ClientInterface;
use Buzz\Client\Curl;
use Buzz\Client\FileGetContents;
use Buzz\Message\Request;
use Buzz\Message\Response;

class SsoCertClient implements ClientInterface
{
    private $client;
    private $certificate_path;

    /**
     * @param string $certificate_path
     */
    public function __construct($certificate_path)
    {
        $this->certificate_path = $certificate_path;

        if (function_exists('curl_init'))
        {
            $this->client = new Curl();

            curl_setopt($this->client->getCurl(), CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($this->client->getCurl(), CURLOPT_SSL_VERIFYHOST, 2);
            curl_setopt($this->client->getCurl(), CURLOPT_CAINFO, $this->certificate_path);
            curl_setopt($this->client->getCurl(), CURLOPT_CAPATH, dirname($this->certificate_path));
        }
        else
        {
            $this->client = new FileGetContents();
        }
    }

    public function send(Request $request, Response $response)
    {
        $this->client->send($request, $response);
    }
}
