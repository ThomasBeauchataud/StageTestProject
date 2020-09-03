<?php


namespace App\Service\User;


use App\Entity\Admin;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use App\Service\EmailFactory;

/**
 * Handle the executing of user messages
 * Class UserManagementHandler
 * @package App\Service\User
 */
class UserManagementHandler implements MessageSubscriberInterface
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var MailerInterface
     */
    private MailerInterface $mailer;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * UserManagementHandler constructor.
     * @param EntityManagerInterface $em
     * @param MailerInterface $mailer
     * @param LoggerInterface $logger
     */
    public function __construct(EntityManagerInterface $em, MailerInterface $mailer, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->logger = $logger;
    }


    /**
     * Add a user to the database and send a email to the user and to the admin to confirm this creation
     * @param UserCreation $userCreation
     */
    public function userCreationHandler(UserCreation $userCreation): void
    {
        $this->em->persist($userCreation->getUser());
        $this->em->flush();
        $admin = $this->em->getRepository(Admin::class)->findAll()[0];
        $email = EmailFactory::createUserCreationEmail($admin, $userCreation->getUser());
        try {
            try {
                $this->mailer->send($email);
            } catch (TransportExceptionInterface $e) {
                $this->logger->alert($e->getMessage());
            }
        } catch (HandlerFailedException $e) {
            $this->logger->alert($e->getMessage());
            //TODO Create a message queue storing emails which couldn't be sent to send them later
        }
    }

    /**
     * Remove a user from the database
     * @param UserSuppression $userSuppression
     */
    public function userSuppressionHandler(UserSuppression $userSuppression): void
    {
        $user = $this->em->getRepository(User::class)->find($userSuppression->getId());
        $this->em->remove($user);
        $this->em->flush();
    }

    /**
     * Update a user from the database
     * @param UserUpdate $userUpdate
     */
    public function userUpdateHandler(UserUpdate $userUpdate): void
    {
        $user = $this->em->getRepository(User::class)->find($userUpdate->getUserId());
        $user->setSurname($userUpdate->getUser()->getSurname());
        $user->setName($userUpdate->getUser()->getName());
        $user->setEmail($userUpdate->getUser()->getEmail());
        $user->setCountry($userUpdate->getUser()->getCountry());
        $user->setGender($userUpdate->getUser()->getGender());
        $user->setBirthDate($userUpdate->getUser()->getBirthDate());
        $user->setJob($userUpdate->getUser()->getJob());
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @inheritDoc
     */
    public static function getHandledMessages(): iterable
    {
        yield UserCreation::class => ["method" => "userCreationHandler"];
        yield UserSuppression::class => ["method" => "userSuppressionHandler"];
        yield UserUpdate::class => ["method" => "userUpdateHandler"];
    }
}