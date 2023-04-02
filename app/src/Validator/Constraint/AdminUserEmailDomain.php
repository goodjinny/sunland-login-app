<?php

declare(strict_types=1);

namespace App\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class AdminUserEmailDomain extends Constraint
{
    public $message = 'Admin email should be in @sunland.dk domain';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
