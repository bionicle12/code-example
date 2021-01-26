<?php

namespace DDD\Page\Repository;

use DDD\Page\Entity\Page;
use DDD\Page\Exceptions\NotFoundException;
use DDD\Page\Model\PageModel;

class PageRepository implements PageRepositoryInterface
{
    public function findBySlug(string $slug): Page
    {
        $pageModel = PageModel::with('content')->where('slug', $slug)->first();

        if (!$pageModel) {
            throw new NotFoundException('Page does not found');
        }
        $page = $pageModel->toDomain();
        return $page;
    }
}
