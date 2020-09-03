<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{

    /**
     * Display the home page
     * @Route("/", name="index", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        return $this->render("index.html.twig");
    }

}