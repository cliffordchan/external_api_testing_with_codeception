<?php

use donatj\MockWebServer\MockWebServer;
use donatj\MockWebServer\Response;
use Illuminate\Http\Response as HttpResponse;

/**
 * Class DemoCest
 */
class DemoCest
{
    /** @var MockWebServer */
    private static $mockWebServer;

    /**
     * Prepare resources before the test
     *
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        $server = new MockWebServer(8001);
        $server->start();

        static::$mockWebServer = $server;
    }

    /**
     * Clear up resources after test
     *
     * @param AcceptanceTester $I
     */
    public function _after(AcceptanceTester $I)
    {
        static::$mockWebServer->stop();
    }

    /**
     * Check page returns status code 200 with some random test
     *
     * @param AcceptanceTester $I
     */
    public function checkIndexPageReturnsStatusCode200WithSomeRandomText(AcceptanceTester $I)
    {
        $response = ['response' => ['pariatur pork loin', 'Short ribs exercitation doner bacon.']];
        static::$mockWebServer->setResponseOfPath(
            '/',
            new Response(json_encode($response), [], HttpResponse::HTTP_OK)
        );

        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpResponse::HTTP_OK);
        $I->see('pork loin');
    }

    /**
     * Check external API returns 404 error code and the function gracefully render "Endpoint moved" text
     *
     * @param AcceptanceTester $I
     */
    public function checkEndpointReturnsStatusCode404NotFoundWithEndpointMovedMessage(AcceptanceTester $I)
    {
        static::$mockWebServer->setResponseOfPath(
            '/',
            new Response(
                json_encode(['error' => 'Endpoint moved']),
                [],
                HttpResponse::HTTP_NOT_FOUND
            )
        );

        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpResponse::HTTP_NOT_FOUND);
        $I->see('Endpoint moved');
    }

    /**
     * Check external API returns 403 error code with suitable message
     *
     * @param AcceptanceTester $I
     */
    public function checkEndpointReturnsStatusCode403ForbiddenWithAccessIsDeniedMessage(AcceptanceTester $I)
    {
        static::$mockWebServer->setResponseOfPath(
            '/',
            new Response(
                json_encode(['error' => 'Access is denied']),
                [],
                HttpResponse::HTTP_FORBIDDEN
            )
        );

        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpResponse::HTTP_FORBIDDEN);
        $I->see('Access is denied');
    }
}
