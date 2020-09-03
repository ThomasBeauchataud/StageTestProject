<?php


namespace App\Security;


use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class UserPasswordEncoder
 * @package App\Security
 * Encode password and validate passwords equalities
 */
class UserPasswordEncoder implements UserPasswordEncoderInterface
{

    /**
     * @inheritDoc
     */
    public function encodePassword(UserInterface $user, string $plainPassword)
    {
        return md5($plainPassword);
    }

    /**
     * @inheritDoc
     */
    public function isPasswordValid(UserInterface $user, string $raw)
    {
        return $user->getPassword() == $this->encodePassword($user, $raw);
    }

    /**
     * @inheritDoc
     */
    public function needsRehash(UserInterface $user): bool
    {
        return false;
    }
}