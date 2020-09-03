<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 * @package App\Controller
 */
class AuthenticationController extends AbstractController
{

    /**
     * Display the login page
     * @Route("/login", name="login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        if ($error != null) {
            switch (get_class($error)) {
                case BadCredentialsException::class:
                    $error = "Password field is required.";
                    break;
                case CustomUserMessageAuthenticationException::class:
                    $error = $error->getMessage();
                    break;
            }
        }
        $lastEmail = $authenticationUtils->getLastUsername();
        return $this->render("login.html.twig", array("error" => $error, "last_email" => $lastEmail));
    }

    /**
     * Logout page
     * @Route("/logout", name="logout", methods={"GET"})
     * @param SessionInterface $session
     * @return Response
     */
    public function logout(SessionInterface $session)
    {
        $session->clear();
        return $this->redirectToRoute("index");
    }
}