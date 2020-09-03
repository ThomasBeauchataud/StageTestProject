<?php


namespace App\Service\User;


use App\Entity\User;
use Exception;

/**
 * Class UserFactory
 * @package App\Service\User
 * Create a User entity
 */
class UserFactory
{

    private CONST FIELDS = ["email", "name", "surname", "gender", "birthDate", "country"];

    /**
     * Create a User entity
     * @param array $data ["email", "name", "surname", "gender", "birthDate", "country", "id" (optional)]
     * @return User
     * @throws Exception
     */
    public static function createUser(array $data): User
    {
        foreach(self::FIELDS as $field) {
            if (!array_key_exists($field, $data)) {
                throw new Exception("UserFactory::createUser array parameter must contains field ".$field);
            }
        }
        $user = new User();
        $user->setEmail($data["email"]);
        $user->setName($data["name"]);
        $user->setSurname($data["surname"]);
        $user->setGender($data["gender"]);
        $user->setBirthDate($data["birthDate"]);
        $user->setCountry($data["country"]);
        if (isset($data["id"])) {
            $user->setId($data["id"]);
        }
        return $user;
    }
}