<?php


namespace App\Tests;


use App\Entity\Admin;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class AbstractControllerTest
 * @package App\Tests
 */
abstract class AbstractControllerTest extends WebTestCase
{

    /**
     * @var KernelBrowser
     */
    protected KernelBrowser $client;

    /**
     * @var RouterInterface|null
     */
    protected ?RouterInterface $router;

    /**
     * @var EntityManagerInterface|null
     */
    protected ?EntityManagerInterface $em;

    /**
     * @before
     */
    public function init()
    {
        $this->client = static::createClient();
        $this->router = self::$container->get(RouterInterface::class);
        $this->em = self::$container->get(EntityManagerInterface::class);
    }

    /**
     * @after
     */
    public function after()
    {
        $this->logout();
    }

    protected function getAdmin(): Admin
    {
        return $this->em->getRepository(Admin::class)->findAll()[0];
    }

    protected function loginAdmin()
    {
        $this->client->loginUser($this->getAdmin());
    }

    protected function logout()
    {
        $this->client->request('GET', $this->router->generate('logout'));
    }

}