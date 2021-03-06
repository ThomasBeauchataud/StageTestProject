<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\DataProvider;
use App\Service\User\UserCreation;
use App\Service\User\UserFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Exception;

/**
 * Class RegisterController
 * @package App\Controller
 * @Route("/register", name="register_")
 */
class RegisterController extends AbstractController
{

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    /**
     * @var DataProvider
     */
    private DataProvider $dataProvider;

    /**
     * RegisterController constructor.
     * @param ValidatorInterface $validator
     * @param MessageBusInterface $bus
     * @param DataProvider $dataProvider
     */
    public function __construct(ValidatorInterface $validator, MessageBusInterface $bus, DataProvider $dataProvider)
    {
        $this->validator = $validator;
        $this->bus = $bus;
        $this->dataProvider = $dataProvider;
    }


    /**
     * Display the form to create a user without being authenticated
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $country = $this->dataProvider->getCountryFromIp($request->getClientIp());
        $countries = $this->dataProvider->getCountryList();
        $jobs = $this->dataProvider->getJobList();
        return $this->render("register.html.twig",
            array("error" => $request->query->get("error"), "countries" => $countries, "genders" => User::GENDERS, "country" => $country, "jobs" => $jobs)
        );
    }

    /**
     * Handle the user creation form for unauthenticated user and for admin
     * Redirecting to the page based on the session
     * @Route("/create", name="create", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function create(Request $request)
    {
        $user = UserFactory::createUser(array(
            "name" => $request->request->get("name"),
            "surname" => $request->request->get("surname"),
            "email" => $request->request->get("email"),
            "gender" => $request->request->get("gender"),
            "country" => $request->request->get("country"),
            "birthDate" => $request->request->get("birth_date"),
            "job" => $request->request->get("job")
        ));
        $errors = $this->validator->validate($user);
        $message = $this->getUser() == null
            ? "Your data has been well saved, you should soon receive a mail to confirm your registry"
            : "The user has been well created";
        if (count($errors) == 0) {
            $this->bus->dispatch(new UserCreation($user));
            $redirectRoute = $this->getUser() == null ? "index" : "admin_index";
            return $this->redirectToRoute($redirectRoute, array("message" => $message));
        }
        $error = $errors[0]->getMessage();
        $redirectRoute = $this->getUser() == null ? "register_index" : "admin_create";
        return $this->redirectToRoute($redirectRoute, array("error" => $error));
    }
}