<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use App\Entity\User;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class UserPasswordComplexityValidator extends ConstraintValidator
{
    private const PASSWORD_COMPLEXITY_PATTERN = '/^(?=.*?[A-Z])(?=.*?\d)(?=.*?[#?!@$%^&*-]).{8,}$$/';

    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof UserPasswordComplexity) {
            throw new UnexpectedTypeException($constraint, UserPasswordComplexity::class);
        }

        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedTypeException($value, 'string');
        }

        if (!preg_match(self::PASSWORD_COMPLEXITY_PATTERN, $value)) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}