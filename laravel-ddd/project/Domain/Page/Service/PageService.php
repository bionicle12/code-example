<?php

namespace Domain\Page\Service;

use App\Services\FileService;
use Domain\Locale\Service\LocaleServiceInterface;
use Domain\Page\Entity\Page;
use Domain\Page\Entity\PageContent;
use Domain\Page\Entity\PageMeta;
use Domain\Page\Entity\PageTitle;
use Domain\Page\Repository\PageRepositoryInterface;
use Domain\Page\Service\PageServiceInterface;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class PageService implements PageServiceInterface
{
    /**
     * @var \Domain\Page\Repository\PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var \Domain\Locale\Service\LocaleServiceInterface
     */
    private $localeService;

    /**
     * @var \App\Services\FileService
     */
    private $fileService;

    /**
     * PageService constructor.
     *
     * @param \Domain\Page\Repository\PageRepositoryInterface $pageRepository
     * @param \Domain\Locale\Service\LocaleServiceInterface $localeService
     * @param \App\Services\FileService $fileService
     */
    public function __construct(PageRepositoryInterface $pageRepository, LocaleServiceInterface $localeService, FileService $fileService) {
        $this->pageRepository = $pageRepository;
        $this->localeService = $localeService;
        $this->fileService = $fileService;
    }

    /**
     * @param int $id
     * @return \Domain\Page\Entity\Page
     */
    public function findById(int $id)
    {
        return $this->pageRepository->findById($id);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function findAll(): Collection
    {
        $pager = request()->get("pages", 1);

        $pages = $this->pageRepository->findAll($pager);

        return $pages;
    }

    /**
     * @param $requestData
     * @param int|null $pageId
     * @return mixed
     * @throws \Domain\Locale\Exceptions\NotFoundException
     */
    public function store($requestData, int $pageId = null)
    {
        $content = [];
        if (($requestData->data)) {
            foreach ($requestData->data as $key=>$data) {
                if (is_null($data)) {
                    continue;
                }

                $imagePath = null;
                if (isset($requestData->file('data')[$key]['meta-image']) && !empty($requestData->file('data')[$key]['meta-image'])) {
                    $imagePath = $this->fileService->store($requestData->file('data')[$key]['meta-image']);
                }

                if (!empty($data['title'])) {
                    $pageTitle = new PageTitle($data['title'] ?? '');

                    $pageMeta = new PageMeta(
                        $data['meta-title'] ?? '',
                        $data['meta-description'] ?? '',
                        $data['meta-keywords'] ?? '',
                        $imagePath
                    );

                    $locale = $this->localeService->findById($key);

                    $content[] = new PageContent(
                        $pageTitle,
                        $data['content'] ?? '',
                        $data['styles'] ?? '',
                        $pageMeta,
                        $locale,
                        $data['status'] ?? '',
                        $pageId ?? null
                    );
                }
            }
        }

        $page = new Page(
            $requestData->category,
            $requestData->slug,
            collect($content),
            Auth::user()
        );

        return $this->pageRepository->store($page, $pageId);
    }

    /**
     * @param int $pageId
     */
    public function destroy(int $pageId)
    {
        $this->pageRepository->destroy($pageId);
    }
}
