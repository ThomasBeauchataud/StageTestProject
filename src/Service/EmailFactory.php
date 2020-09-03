<?php


namespace App\Service;


use App\Entity\Admin;
use App\Entity\User;
use Symfony\Component\Mime\Email;

/**
 * Class EmailFactory
 * @package App\Service
 */
class EmailFactory
{

    /**
     * Create an email destined to the user and the admin resuming the recent user creation
     * @param Admin $admin
     * @param User $user
     * @return Email
     */
    public static function createUserCreationEmail(Admin $admin, User $user): Email
    {
        $content = "Dear " . $user->getSurname() . " " . $user->getName() . ", your data has been well saved \n"
            . "Name : " . $user->getName() . "\n"
            . "Surname : " . $user->getSurname() . "\n"
            . "Email : " . $user->getEmail() . "\n"
            . "Country : " . $user->getCountry() . "\n"
            . "Birth date : " . $user->getBirthDate() . "\n"
            . "Gender : " . $user->getGender();
        return (new Email())
            ->from($admin->getEmail())
            ->to($user->getEmail())
            ->addTo($admin->getEmail())
            ->text($content);
    }

}