<?php

namespace DDD\HMenu\Service;

use Illuminate\Support\Collection;

interface HMenuServiceInterface
{
    /**
     * @return Collection
     */
    public function findAll();
}
