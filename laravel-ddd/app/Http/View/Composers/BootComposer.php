<?php

namespace App\Http\View\Composers;

use DDD\HMenu\Service\HMenuServiceInterface;
use DDD\Locale\Service\LocaleServiceInterface;
use Illuminate\View\View;

class BootComposer
{
    /**
     * @var LocaleServiceInterface
     */
    private $localeService;

    /**
     * @var HMenuServiceInterface
     */
    private $hMenuService;


    public function __construct(LocaleServiceInterface $localeService, HMenuServiceInterface $hMenuService)
    {
        $this->localeService = $localeService;
        $this->hMenuService = $hMenuService;
    }

    public function compose(View $view)
    {
        $locales = $this->localeService->getAll();

        $hMenus = $this->hMenuService->findAll();

        $view->with('locales', $locales)
            ->with('hMenus', $hMenus);
    }
}
