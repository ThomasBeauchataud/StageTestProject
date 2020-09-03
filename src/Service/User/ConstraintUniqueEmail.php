<?php


namespace App\Service\User;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * Assert that an email is unique and validate it while updating a user with his email
 */
class ConstraintUniqueEmail extends Constraint
{

    /**
     * @var string
     */
    public string $message = 'A user with this email already exists.';

    /**
     * @inheritDoc
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

}