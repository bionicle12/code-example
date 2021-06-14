<?php

namespace App\Http\Controllers\Page;

use App\Http\Controllers\Controller;
use Domain\Locale\Service\LocaleServiceInterface;
use Domain\Page\Requests\PageStoreRequest;
use Domain\Page\Requests\PageUpdateRequest;
use Exception;
use Domain\Page\Service\PageServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class PageController
 *
 * @package App\Http\Controllers\Page
 */
class PageController extends Controller
{
    /**
     * @var \Domain\Page\Service\PageServiceInterface
     */
    private $pageService;

    /**
     * @var \Domain\Locale\Service\LocaleServiceInterface
     */
    private $localeService;

    /**
     * PageController constructor.
     *
     * @param \Domain\Page\Service\PageServiceInterface $pageService
     * @param \Domain\Locale\Service\LocaleServiceInterface $localeService
     */
    public function __construct(
        PageServiceInterface $pageService,
        LocaleServiceInterface $localeService
    ) {
        $this->pageService = $pageService;
        $this->localeService = $localeService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $pages = $this->pageService->findAll();

        $array = [];
        foreach ($pages as $page) {
            $array[] = [
                'id' => $page->getId(),
                'category' => $page->getCategory(),
                'slug' => $page->getSlug(),
                'title' => $page->getContent()
                    ->first()
                    ->getTitle()
                    ->getTitle(),
                'status' => (boolean) $page->getContent()
                    ->first()
                    ->getStatus() ? "true" : "false",
            ];
        }

        return response()->json($array);
    }

//    public function create()
//    {
//        $activeLocales = $this->localeService->findAllActive();
//
//        return view('pages/create', [
//            'locales' => $activeLocales,
//        ]);
//    }

    /**
     * @param \Domain\Page\Requests\PageStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PageStoreRequest $request): JsonResponse
    {
        $pageId = $this->pageService->store($request);

        return response()->json([
            'id' => $pageId,
        ]);
    }

    /**
     * @param int $pageId
     */
    public function destroy(int $pageId)
    {
        $this->pageService->destroy($pageId);

        response()->json();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param int $pageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(
        Request $request,
        int $pageId
    ): JsonResponse {

        $activeLocales = $this->localeService->findAllActive();

        $page = $this->pageService->findById($pageId);

        $array = [];
        foreach ($page->getContent() as $item) {

            $array[$item->getLocale()->id] = [
                'page_id' => $pageId,
                'title' => $item->getTitle()
                    ->getTitle(),
                'content' => $item->getContent(),
                'styles' => $item->getStyles(),
                'status' => $item->getStatus(),
                'meta-title' => $item->getMeta()
                    ->getTitle(),
                'meta-keywords' => $item->getMeta()
                    ->getKeywords(),
                'meta-description' => $item->getMeta()
                    ->getDescription(),
                'meta-image' => $item->getMeta()
                    ->getImageLink(),
            ];
        }

        return response()->json([
            'page' => $array,
            'category' => $page->getCategory(),
            'slug' => $page->getSlug(),
            'locale' => $activeLocales->toArray(),
        ]);
    }

    /**
     * @param \Domain\Page\Requests\PageUpdateRequest $request
     * @param int $pageId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(
        PageUpdateRequest $request,
        int $pageId
    ): JsonResponse {
        $this->pageService->store($request, $pageId);
        return response()->json();
    }
}
