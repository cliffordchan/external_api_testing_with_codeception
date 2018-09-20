<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Response;

/**
 * Class DemoController
 * @package App\Http\Controllers
 */
class DemoController extends Controller
{
    /**
     * @var Client
     */
    private $client;

    /**
     * DemoController constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Simple action to consume an external API and output it in json format
     *
     * When 404 status code is received, an error with text Endpoint moved
     * When 200 status code is received, response body is returned
     * Other status codes are treated as text unavailable
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $response = $this->client->request('GET', env('WORD_API_ENDPOINT'));

        switch ($response->getStatusCode()) {
            case Response::HTTP_OK:
                $body = ['response' => json_decode($response->getBody(), true)];
                break;

            case Response::HTTP_NOT_FOUND:
                $body = ['error' => 'Endpoint moved'];
                break;

            default:
                $body = ['error' => 'Text unavailable'];
                break;
        }

        return response()->json($body);
    }
}
