<?php


namespace App\Service\User;


/**
 * Class UserSuppression
 * @package App\Service\User
 * UserSuppression message destined to the middleware to delete a user
 */
class UserSuppression
{

    /**
     * @var int
     */
    private int $id;

    /**
     * UserSuppression constructor.
     * @param int $id
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }


    /**
     * Return the id of the user to delete
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}