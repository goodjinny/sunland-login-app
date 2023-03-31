<?php

declare(strict_types=1);

namespace App\Traits;

use Doctrine\ORM\EntityManagerInterface;

/**
 * EntityManagerTrait.
 */
trait EntityManagerTrait
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @required
     */
    public function setEntityManager(EntityManagerInterface $em): void
    {
        $this->em = $em;
    }
}
