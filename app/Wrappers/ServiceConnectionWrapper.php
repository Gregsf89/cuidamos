<?php

namespace App\Wrappers;

use Exception;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Http;

/**
 * Class ServiceConnectionWrapper
 * @package App\Services
 */
class ServiceConnectionWrapper
{
    /**
     * @var string
     */
    private string $uri = '';

    public function __construct(string $uri = '')
    {
        if (!empty($uri)) {
            $this->uri = config('micro_services.' . $uri) ?? '';
        }
    }

    /**
     * Sets the service class member
     *
     * @param string $uri
     */
    public function setService(string $uri)
    {
        $this->uri = config('micro_services.' . $uri) ?? '';
    }

    /**
     * Unsets the service class member
     *
     * @param string $uri
     */
    public function unsetService(string $uri)
    {
        $this->uri = '';
    }

    /**
     * GET Method
     *
     * @param string $url
     * @param array $header
     * @param array $data
     * @param string $accept
     * @return array|null The data response from the service
     *
     * @throws Exception
     */
    public function get(
        string $url,
        array $header = [],
        array $data = [],
        string $accept = 'application/json'
    ): ?array {
        try {
            $response = Http::withHeaders($header)
                ->accept($accept)
                ->get($this->uri . $url, $data);

            return json_decode($response->body(), true);
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), '100001');
        }
    }

    /**
     * POST Method
     *
     * @param string $url
     * @param array $header
     * @param array $data     
     * @param string $accept
     * @return array|null
     *
     * @throws Exception
     */
    public function post(
        string $url,
        array $header = [],
        array $data = [],
        string $accept = 'application/json'
    ): ?array {
        try {
            $response = Http::withHeaders($header)
                ->accept($accept)
                ->post($this->uri . $url, $data);

            return json_decode($response->body(), true);
        } catch (ClientException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        } catch (Exception $e) {
            throw new Exception('invalid_request', '100002');
        }
    }

    /**
     * DELETE Method
     *
     * @param string $url
     * @param array $header
     * @param array $data     
     * @param string $accept
     * @return array|null
     *
     * @throws Exception
     */
    public function delete(
        string $url,
        array $header = [],
        array $data = [],
        string $accept = 'application/json'
    ) {
        try {
            $response = Http::withHeaders($header)
                ->accept($accept)
                ->delete($this->uri . $url, $data);

            return json_decode($response->body(), true);
        } catch (Exception $e) {
            throw new Exception('invalid_request', '100003');
        }
    }

    /**
     * PUT Method
     *
     * @param string $url
     * @param array $header
     * @param array $data     
     * @param string $accept
     * @return array|null
     *
     * @throws Exception
     */
    public function put(
        string $url,
        array $header = [],
        array $data = [],
        string $accept = 'application/json'
    ) {
        try {
            $response = Http::withHeaders($header)
                ->accept($accept)
                ->put($this->uri . $url, $data);

            return json_decode($response->body(), true);
        } catch (Exception $e) {
            throw new Exception('invalid_request', '100004');
        }
    }
}
