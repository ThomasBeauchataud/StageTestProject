<?php


namespace App\Service\User;


use App\Entity\User;

/**
 * Class UserUpdate
 * @package App\Service\User
 * UserUpdate message destined to the middleware to update a user
 */
class UserUpdate
{

    /**
     * @var User
     */
    private User $user;

    /**
     * @var int
     */
    private int $userId;

    /**
     * UserUpdate constructor.
     * @param User $user
     * @param int $userId
     */
    public function __construct(User $user, int $userId)
    {
        $this->user = $user;
        $this->userId = $userId;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}