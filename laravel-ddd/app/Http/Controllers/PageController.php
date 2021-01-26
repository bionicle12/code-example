<?php

namespace App\Http\Controllers;

use DDD\Page\Exceptions\NotFoundException;
use DDD\Page\Service\PageServiceInterface;

class PageController extends Controller
{
    /**
     * @var PageServiceInterface
     */
    private $pageService;

    public function __construct(PageServiceInterface $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(string $slug)
    {
        $page = $this->pageService->findBySlug($slug);

        return view('page.index', [
            'page' => $page
        ]);
    }
}
