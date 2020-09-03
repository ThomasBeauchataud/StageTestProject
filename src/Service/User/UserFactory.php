<?php


namespace App\Service\User;


use App\Entity\User;

/**
 * Class UserFactory
 * @package App\Service\User
 * Create a User entity
 */
class UserFactory
{

    /**
     * Create a User entity
     * @param array $data ["email", "name", "surname", "gender", "birthDate"]
     * @return User
     */
    public static function createUser(array $data): User
    {
        $user = new User();
        $user->setEmail($data["email"]);
        $user->setName($data["name"]);
        $user->setSurname($data["surname"]);
        $user->setGender($data["gender"]);
        $user->setBirthDate($data["birthDate"]);
        return $user;
    }

}