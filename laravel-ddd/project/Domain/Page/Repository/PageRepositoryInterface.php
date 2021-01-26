<?php

namespace DDD\Page\Repository;

interface PageRepositoryInterface
{
    public function findBySlug(string $slug);
}
