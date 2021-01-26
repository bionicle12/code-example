<?php

namespace DDD\Page\Service;

interface PageServiceInterface
{
    public function findBySlug(string $slug);
}
