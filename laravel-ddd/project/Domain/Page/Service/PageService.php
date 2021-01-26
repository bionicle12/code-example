<?php

namespace DDD\Page\Service;

use DDD\Locale\Service\LocaleServiceInterface;
use DDD\Page\Entity\Page;
use DDD\Page\Entity\PageContent;
use DDD\Page\Entity\PageMeta;
use DDD\Page\Entity\PageTitle;
use DDD\Page\Exceptions\NotFoundException;
use DDD\Page\Repository\PageRepositoryInterface;
use DDD\Page\Service\PageServiceInterface;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;

class PageService implements PageServiceInterface
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository) {
        $this->pageRepository = $pageRepository;
    }

    public function findBySlug(string $slug)
    {
        if (!$slug) {
            throw new NotFoundException("Page not found");
        }

        return $this->pageRepository->findBySlug($slug);
    }
}
