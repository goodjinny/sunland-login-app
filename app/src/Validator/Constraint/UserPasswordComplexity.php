<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class UserPasswordComplexity extends Constraint
{
    public $message = 'Password should contain minimum eight characters, at least one number, one uppercase letter and one special character';
}