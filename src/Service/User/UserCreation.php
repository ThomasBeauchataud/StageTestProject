<?php


namespace App\Service\User;


use App\Entity\User;

/**
 * Class UserCreation
 * @package App\Service\User
 * UserCreation message destined to the middleware to create a user
 */
class UserCreation
{

    /**
     * @var User
     */
    private User $user;

    /**
     * UserCreation constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }


    /**
     * Return the user to create with full data
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}