<?php

declare(strict_types=1);

namespace App\Traits;

use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * ValidatorTrait.
 */
trait ValidatorTrait
{
    /** @var ValidatorInterface */
    protected $validator;

    /**
     * @required
     */
    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    /**
     * @throws \Exception
     */
    private function extractFirstErrorFromViolationList(ConstraintViolationList $violationList): ?string
    {
        if (0 === $violationList->count()) {
            return null;
        }

        return $violationList->get(0)->getMessage();
    }
}
