<?php

namespace Domain\Page\Repository;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface PageRepositoryInterface
 *
 * @package Domain\Page\Repository
 */
interface PageRepositoryInterface
{
    /**
     * @param int $pager
     * @return \Illuminate\Support\Collection
     */
    public function findAll(int $pager = 0): \Illuminate\Support\Collection;
}
