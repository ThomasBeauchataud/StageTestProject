<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\User\CountryProvider;
use App\Service\User\UserUpdate;
use App\Service\User\UserFactory;
use App\Service\User\UserSuppression;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AdministratorController
 * @package App\Controller
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdminController extends AbstractController
{

    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var CountryProvider
     */
    private CountryProvider $countryProvider;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * AdminController constructor.
     * @param MessageBusInterface $bus
     * @param EntityManagerInterface $em
     * @param CountryProvider $countryProvider
     * @param ValidatorInterface $validator
     */
    public function __construct(MessageBusInterface $bus, EntityManagerInterface $em, CountryProvider $countryProvider, ValidatorInterface $validator)
    {
        $this->bus = $bus;
        $this->em = $em;
        $this->countryProvider = $countryProvider;
        $this->validator = $validator;
    }


    /**
     * Display the list of existing users
     * @Route("/", name="index", methods={"GET"})
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $users = $this->em->getRepository(User::class)->findBy(array(), array('country' => 'ASC'));
        $countries = $this->countryProvider->getCountryList();
        return $this->render("users.html.twig",
            array("users" => $users, "countries" => $countries, "genders" => User::GENDERS, "message" => $request->query->get("message"))
        );
    }

    /**
     * Display the creation user form
     * @Route("/create", name="create")
     * @param Request $request
     * @return Response
     */
    public function create(Request $request)
    {
        if ($request->isMethod("POST")) {
            return $this->forward('App\Controller\RegisterController::create');
        }
        $countries = $this->countryProvider->getCountryList();
        return $this->render('register.html.twig',
            array("error" => $request->query->get("error"), "countries" => $countries, "genders" => User::GENDERS)
        );
    }

    /**
     * Display information about a specific user
     * @Route("/{id}", name="select", methods={"GET"})
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function select(Request $request, int $id)
    {
        $user = $this->em->getRepository(User::class)->find($id);
        $countries = $this->countryProvider->getCountryList();
        return $this->render("user.html.twig",
            array("user" => $user, "countries" => $countries, "genders" => User::GENDERS, "error" => $request->query->get("error"))
        );
    }

    /**
     * Handle the user suppression form
     * @Route("/delete", name="delete", methods={"POST"})
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request)
    {
        $this->bus->dispatch(new UserSuppression($request->request->get("id")));
        return $this->redirectToRoute("admin_index");
    }

    /**
     * Handle to user update form
     * @Route("/update", name="update", methods={"POST"})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function update(Request $request)
    {
        $user = UserFactory::createUser(array(
            "name" => $request->request->get("name"),
            "surname" => $request->request->get("surname"),
            "email" => $request->request->get("email"),
            "gender" => $request->request->get("gender"),
            "birthDate" => $request->request->get("birth_date"),
            "country" => $request->request->get("country"),
            "id" => $request->request->get("id")
        ));
        $errors = $this->validator->validate($user);
        if (count($errors) == 0) {
            $this->bus->dispatch(new UserUpdate($user, $request->request->get("id")));
            return $this->redirectToRoute("admin_index");
        }
        $error = $errors[0]->getMessage();
        return $this->redirect($this->generateUrl("admin_select", array("id" => $request->request->get("id"))) ."?error=".$error);
    }
}