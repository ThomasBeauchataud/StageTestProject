<?php


namespace App\Service\User;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ConstraintUniqueEmailValidator extends ConstraintValidator
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * ConstraintUniqueEmailValidator constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    /**
     * @param mixed $user
     * @param Constraint $constraint
     * @throws Exception
     */
    public function validate($user, Constraint $constraint)
    {
        if (! $user instanceof User) {
            throw new Exception("The UniqueEmailValidator annotation can only be user of User class");
        }
        $userTest = $this->em->getRepository(User::class)->findOneBy(["email" => $user->getEmail()]);
        if ($userTest != null && $user->getId() != $userTest->getId()) {
            $this->context->buildViolation($constraint->message)
                ->atPath(get_class($user))
                ->addViolation();
        }
    }
}