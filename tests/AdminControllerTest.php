<?php


namespace App\Tests;


use App\Entity\User;
use App\Service\User\UserFactory;
use Exception;

/**
 * Class AdminControllerTest
 * @package App\Tests
 * @coversDefaultClass \App\Controller\AdminController
 */
class AdminControllerTest extends AbstractControllerTest
{

    private CONST NAME = "NAME_TEST";
    private CONST NEW_NAME = "NEW_NAME_TEST";
    private CONST SURNAME = "SURNAME_TEST";
    private CONST EMAIL = "email.test@gmail.com";
    private CONST GENDER = User::GENDER_MALE;
    private CONST COUNTRY = "FRANCE";
    private CONST BIRTHDATE = "1996-02-21";

    /**
     * @covers \App\Controller\AdminController::index
     */
    public function testIndex()
    {
        $this->loginAdmin();
        $this->client->request('GET', $this->router->generate("admin_index"));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Error while trying to load admin index page");
        $this->logout();
    }

    /**
     * @covers \App\Controller\AdminController::select
     * @throws Exception
     */
    public function testSelect()
    {
        $this->loginAdmin();
        $data = array(
            "name" => self::NAME,
            "surname" => self::SURNAME,
            "email" => self::EMAIL,
            "gender" => self::GENDER,
            "country" => self::COUNTRY,
            "birthDate" => self::BIRTHDATE
        );
        $user = UserFactory::createUser($data);
        $this->em->persist($user);
        $this->em->flush();
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        $this->client->request('GET', $this->router->generate("admin_select", array("id" => $user->getId())));
        $this->assertEquals(200, $this->client->getResponse()->getStatusCode(), "Error while trying to load admin select page");
        $this->em->remove($user);
        $this->em->flush();
        $this->logout();
    }

    /**
     * @covers \App\Controller\AdminController::create
     * @throws Exception
     */
    public function testCreate()
    {
        $this->loginAdmin();
        $parameters = array(
            "name" => self::NAME,
            "surname" => self::SURNAME,
            "email" => self::EMAIL,
            "gender" => self::GENDER,
            "country" => self::COUNTRY,
            "birth_date" => self::BIRTHDATE
        );
        $this->client->request('POST', $this->router->generate("admin_create"), $parameters);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(),
            "Error while trying to execute create user form");
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        $this->assertNotNull($user, "Error while creating a user : user not created");
        $this->client->request('POST', $this->router->generate("admin_create"), $parameters);
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
            $this->logout();
        }
    }

    /**
     * @covers \App\Controller\AdminController::update
     * @throws Exception
     */
    public function testUpdate()
    {
        $this->loginAdmin();
        $data = array(
            "name" => self::NAME,
            "surname" => self::SURNAME,
            "email" => self::EMAIL,
            "gender" => self::GENDER,
            "country" => self::COUNTRY,
            "birthDate" => self::BIRTHDATE
        );
        $user = UserFactory::createUser($data);
        $this->em->persist($user);
        $this->em->flush();
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        $parameters = array(
            "id" => $user->getId(),
            "name" => self::NEW_NAME,
            "surname" => self::SURNAME,
            "email" => self::EMAIL,
            "gender" => self::GENDER,
            "country" => self::COUNTRY,
            "birth_date" => self::BIRTHDATE
        );
        $this->client->request('POST', $this->router->generate("admin_update"), $parameters);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(),
            "Error while trying to update a user");
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        try {
            $this->assertEquals(self::NEW_NAME, $user->getName());
        } catch (Exception $e ) {
            throw $e;
        } finally {
            $this->em->remove($user);
            $this->em->flush();
            $this->logout();
        }
    }

    /**
     * @covers \App\Controller\AdminController::delete
     * @throws Exception
     */
    public function testDelete()
    {
        $this->loginAdmin();
        $data = array(
            "name" => self::NAME,
            "surname" => self::SURNAME,
            "email" => self::EMAIL,
            "gender" => self::GENDER,
            "country" => self::COUNTRY,
            "birthDate" => self::BIRTHDATE
        );
        $user = UserFactory::createUser($data);
        $this->em->persist($user);
        $this->em->flush();
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        $parameters = array("id" => $user->getId());
        $this->client->request('POST', $this->router->generate("admin_delete"), $parameters);
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode(),
            "Error while trying to delete a user");
        $user = $this->em->getRepository(User::class)->findOneBy(["email" => self::EMAIL]);
        try {
            $this->assertNull($user, "Error while trying to delete a user");
        } catch (Exception $e) {
            $this->em->remove($user);
            $this->em->flush();
            throw $e;
        } finally {
            $this->logout();
        }
    }

}