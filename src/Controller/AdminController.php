<?php


namespace App\Controller;


use App\Entity\User;
use App\Service\User\CountryProvider;
use App\Service\User\UserSuppression;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

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
     * AdminController constructor.
     * @param MessageBusInterface $bus
     * @param EntityManagerInterface $em
     * @param CountryProvider $countryProvider
     */
    public function __construct(MessageBusInterface $bus, EntityManagerInterface $em, CountryProvider $countryProvider)
    {
        $this->bus = $bus;
        $this->em = $em;
        $this->countryProvider = $countryProvider;
    }


    /**
     * Display the list of existing users
     * @Route("/", name="index", methods={"GET"})
     * @return Response
     */
    public function index()
    {
        $users = $this->em->getRepository(User::class)->findBy(array(), array('country' => 'ASC'));
        $countries = $this->countryProvider->getCountryList();
        return $this->render("users.html.twig",
            array("users" => $users, "countries" => $countries, "genders" => User::GENDERS)
        );
    }

    /**
     * Display information about a specific user
     * @Route("/{id}", name="select", methods={"GET"})
     * @param int $id
     * @return Response
     */
    public function select(int $id)
    {
        $user = $this->em->getRepository(User::class)->find($id);
        $countries = $this->countryProvider->getCountryList();
        return $this->render("user.html.twig",
            array("user" => $user, "countries" => $countries, "genders" => User::GENDERS)
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
     */
    public function update(Request $request)
    {
        //TODO Implements
    }
}