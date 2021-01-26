<?php

namespace App\Http\Controllers;

use DDD\Page\Service\PageServiceInterface;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /** @var PageServiceInterface */
    private $pageService;

    public function __construct(PageServiceInterface $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index(Request $request)
    {
        $page = $this->pageService->findBySlug(config('app.home_page_slug'));

        if (!$page) {
            return view('welcome');
        }

        return view('page.index', [
            'page' => $page
        ]);
    }
}
