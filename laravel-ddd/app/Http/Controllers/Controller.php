<?php

namespace App\Http\Controllers;

use DDD\Locale\Service\LocaleService;
use DDD\Locale\Service\LocaleServiceInterface;
use DDD\HMenu\Service\HMenuServiceInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function loadLocales()
    {
        $locales = $this->localeService->getAll();

        $data = [];
        foreach ($locales as $locale) {
            $data[$locale->id] = $locale->title;
        }
        view()->share('locales', $data);
    }

    protected function loadHMenu()
    {
        echo "Parent - ". app()->getLocale() . "<br>";
    }
}
