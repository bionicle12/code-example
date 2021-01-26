<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use DDD\Locale\Service\LocaleServiceInterface;
use Illuminate\Http\Request;
use \Illuminate\Support\Facades\Cookie;

class LocalizationController extends Controller
{
    /** @var LocaleServiceInterface */
    protected $localeService;

    public function __construct(LocaleServiceInterface $localeService)
    {
        $this->localeService = $localeService;
    }

    public function index($code)
    {
        $locale = $this->localeService->findByCode($code);

        $cookie = null;
        if ($locale) {
            $cookie = Cookie::forever('locale', $locale->code);
        }

        if ($cookie) {
            return back()->withCookie($cookie);
        }

        return back();
    }

    public function get(Request $request)
    {
        $value = $request->cookie('locale');
        echo $value;
    }
}
