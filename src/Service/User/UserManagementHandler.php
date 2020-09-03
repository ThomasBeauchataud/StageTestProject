<?php


namespace App\Service\User;


use App\Entity\Admin;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Handler\MessageSubscriberInterface;
use Symfony\Component\Mime\Email;

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
     * Add a user to the database and send a email to the user and to the admin to confirm this creation
     * @param UserCreation $userCreation
     */
    public function userCreationHandler(UserCreation $userCreation): void
    {
        $this->em->persist($userCreation->getUser());
        $this->em->flush();
        $admin = $this->em->getRepository(Admin::class)->findAll()[0];
        $email = (new Email())
            ->from("")
            ->to($userCreation->getUser()->getEmail())
            ->addTo($admin->getEmail())
            ->text("Text test");
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            //TODO handle exception
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
        //TODO Implements
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