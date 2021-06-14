<?php

namespace Domain\Page\Service;

use Domain\Page\Entity\Page;
use Illuminate\Support\Collection;

/**
 * Interface PageServiceInterface
 *
 * @package Domain\Page\Service
 */
interface PageServiceInterface
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAll(): Collection;
}
