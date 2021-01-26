<?php

namespace DDD\HMenu\Service;

use DDD\HMenu\Repository\HMenuRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class HMenuService implements HMenuServiceInterface
{
    /**
     * @var null HMenuRepositoryInterface
     */
    private $hMenuRepository = null;

    public function __construct(HMenuRepositoryInterface $hMenuRepository)
    {
        $this->hMenuRepository = $hMenuRepository;
    }

    public function findAll()
    {
        $cache_key = 'hMenu_' . app()->getLocale();
        if (Cache::has($cache_key)) {
            $items = unserialize(Cache::get($cache_key), ['allowed_classes' => true]);
            return $items;
        }

        $items = $this->hMenuRepository->findAll();
        Cache::put($cache_key, serialize($items), now()->addMinutes(10));

        return $items;
    }
}
