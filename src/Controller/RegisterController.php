<?php


namespace App\Controller;


use App\Entity\Admin;
use App\Entity\User;
use App\Service\User\CountryProvider;
use App\Service\User\UserCreation;
use App\Service\User\UserFactory;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use GeoIp2\Database\Reader;
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
     * @var CountryProvider
     */
    private CountryProvider $countryProvider;

    /**
     * RegisterController constructor.
     * @param ValidatorInterface $validator
     * @param MessageBusInterface $bus
     * @param CountryProvider $countryProvider
     */
    public function __construct(ValidatorInterface $validator, MessageBusInterface $bus, CountryProvider $countryProvider)
    {
        $this->validator = $validator;
        $this->bus = $bus;
        $this->countryProvider = $countryProvider;
    }


    /**
     * Display the form to create a user without being authenticated
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $city = null;
        try {
            $reader = new Reader($this->getParameter("geo_lite_path"));
            $record = $reader->city($request->getClientIp());
            var_dump($record);
        } catch (Exception $e) {

        }
        $countries = $this->countryProvider->getCountryList();
        return $this->render("register.html.twig",
            array("error" => $request->query->get("error"), "countries" => $countries, "genders" => User::GENDERS)
        );
    }

    /**
     * Handle the user creation form
     * @Route("/creation", name="creation", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function creation(Request $request)
    {
        $user = UserFactory::createUser(array(
            "name" => $request->request->get("name"),
            "surname" => $request->request->get("surname"),
            "email" => $request->request->get("email"),
            "gender" => $request->request->get("gender"),
            "birthDate" => DateTime::createFromFormat("Y-d-m", $request->request->get("birth_date")),
        ));
        $errors = $this->validator->validate($user);
        if (count($errors) == 0) {
            $this->bus->dispatch(new UserCreation($user));
            if (in_array(Admin::ROLE_ADMIN, $this->getUser()->getRoles())) {
                return $this->redirectToRoute("admin_index");
            }
        }
        $error = $errors[0]->getMessage();
        return $this->redirectToRoute("register_index", array("error" => $error));
    }
}