<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class AdminUserEmailDomainValidator extends ConstraintValidator
{
    private const SUNLAND_EMAIL_PATTERN = '/^[-\.\w]+@sunland.dk$/';

    public function validate($entity, Constraint $constraint)
    {
        if (!$constraint instanceof AdminUserEmailDomain) {
            throw new UnexpectedTypeException($constraint, AdminUserEmailDomain::class);
        }

        if (null === $entity) {
            return;
        }

        if (!\is_object($entity)) {
            throw new UnexpectedValueException($entity, 'object');
        }

        if (!$entity instanceof User) {
            throw new ConstraintDefinitionException(sprintf('%s constraint could be used with %s entity only', self::class, User::class));
        }

        if (!$entity->isAdmin()) {
            return;
        }

        if (!preg_match(self::SUNLAND_EMAIL_PATTERN, $entity->getEmail())) {
            $this->context->buildViolation($constraint->message)
                ->atPath('email')
                ->addViolation();
        }
    }
}
