<?php


namespace App\Tests;


/**
 * Class IndexControllerTest
 * @package App\Tests
 * @coversDefaultClass \App\Controller\IndexController
 */
class IndexControllerTest extends AbstractControllerTest
{

    /**
     * @covers \App\Controller\IndexController::index
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->router->generate("index"));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Error while trying to load index page");
    }

}