<?php


namespace App\Tests;


use App\Entity\User;
use Exception;

/**
 * Class RegisterControllerTest
 * @package App\Tests
 * @coversDefaultClass \App\Controller\RegisterController
 */
class RegisterControllerTest extends AbstractControllerTest
{

    private CONST NAME = "NAME_TEST";
    private CONST SURNAME = "SURNAME_TEST";
    private CONST EMAIL = "email.test@gmail.com";
    private CONST GENDER = User::GENDER_MALE;
    private CONST COUNTRY = "FRANCE";
    private CONST BIRTHDATE = "1996-02-21";
    private CONST JOB = "Farmer";

    /**
     * @covers \App\Controller\RegisterController::index
     */
    public function testIndex()
    {
        $this->client->request('GET', $this->router->generate("register_index"));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Error while trying to load register page");
    }

    /**
     * @covers \App\Controller\RegisterController::create
     * @throws Exception
     */
    public function testCreate()
    {
        $parameters = array(
            "name" => self::NAME,
            "surname" => self::SURNAME,
            "email" => self::EMAIL,
            "gender" => self::GENDER,
            "country" => self::COUNTRY,
            "birth_date" => self::BIRTHDATE,
            "job" => self::JOB
        );
        $this->client->request('POST', $this->router->generate("register_create"), $parameters);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(),
            "Error while trying to execute create user form");
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        $this->assertNotNull($user, "Error while creating a user : user not created");
        $this->client->request('POST', $this->router->generate("register_create"), $parameters);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(),
            "Error while trying to execute create an existing user (exception thrown)");
        try {
            $this->assertCount(1, $this->em->getRepository(User::class)->findBy(["email" => self::EMAIL]),
            "Error while creating a user : unique email constraint not applied");
        } catch (Exception $e) {
            throw $e;
        } finally {
            foreach($this->em->getRepository(User::class)->findBy(["email" => self::EMAIL]) as $user) {
                $this->em->remove($user);
            }
            $this->em->flush();
        }
    }
}