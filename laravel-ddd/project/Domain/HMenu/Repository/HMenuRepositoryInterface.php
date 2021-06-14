<?php

namespace Domain\HMenu\Repository;

use Domain\HMenu\Entity\HMenu;

interface HMenuRepositoryInterface
{
    public function findById(int $Id);

    public function findPaginatedAll(int $itemsPerPage);

    public function findAll();

    public function store(HMenu $hMenu, int $id = null);

    public function destroy(int $id);
}
