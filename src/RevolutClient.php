<?php

namespace Hmimeee\Revolut;

class RevolutClient
{
    /**
     * Production API environment
     * 
     * @var string $env
     */
    protected string $env = 'sandbox'; // or, live

    /**
     * Production API endpoint
     * 
     * @var string $prod_endpoint
     */
    protected string $prod_endpoint = 'https://merchant.revolut.com';


    /**
     * Development API endpoint
     * 
     * @var string $dev_endpoint
     */
    protected string $dev_endpoint = 'https://sandbox-merchant.revolut.com';

    /**
     * Endpoint of the Revolut API
     * 
     * @var string $endpoint
     */
    public string $endpoint;


    /**
     * Webhook endpoint to handle the events
     * 
     * @var string $webhook_endpoint
     */
    public string $webhook_endpoint;


    /**
     * Endpoint prefix based on the version
     *
     * @var string $prefix
     */
    protected string $prefix = 'api/1.0';


    /**
     * CURL client class instance
     * 
     * @var mixed $client
     */
    protected $client = \GuzzleHttp\Client::class;


    /**
     * Secret key to authorize the request
     * 
     * @var string $key
     */
    public string $key;


    public function __construct()
    {
        //
    }

    /**
     * Set the environment
     * 
     * @param string $env
     * @return $this
     */
    public function setEnvironment(string $env): self
    {
        $this->env = $env == 'live' ? 'live' : 'sandbox';

        return $this;
    }

    /**
     * Set the API secret key before send any request to the endpoint
     * 
     * @param string $key
     * @return $this
     */
    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Send the request to the endpoint
     * 
     * @param string $path
     * @param array|null $data
     * @param string $method
     * @return array Array of result such as `['status' => true, 'data' => ...]` or, `['status' => false, 'message' => ...]`
     */
    public function request(string $path, array $data = null, string $method = 'GET'): array
    {
        try {
            $requestData = [
                'headers' => [
                    'Authorization' => "Bearer $this->key",
                    'Content-Type' => 'application/json'
                ]
            ];

            if ($method == 'POST' && $data) {
                $requestData['body'] = json_encode($data);
            }

            $response = (new $this->client)->request($method, $this->getEndpoint($path), $requestData);

            return [
                'status' => true,
                'data' => json_decode($response->getBody()->getContents())
            ];
        } catch (\Throwable $th) {
            //Throw the exception if the environment is not live
            if ($this->env != 'live') {
                throw $th;
            }

            //Return false result if the environment is live
            return [
                'status' => false,
                'message' => $th->getMessage()
            ];
        }
    }

    /**
     * Get the API endpoint prepared
     * 
     * @param string $path
     * @return string
     */
    public function getEndpoint(string $path): string
    {
        $this->endpoint =  $this->env == 'live' ? $this->prod_endpoint : $this->dev_endpoint;

        $pieces = [
            trim($this->endpoint, '/'),
            trim($this->prefix, '/'),
            trim($path, '/')
        ];

        return implode('/', $pieces);
    }
}
