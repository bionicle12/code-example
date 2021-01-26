<?php

namespace App\Http\Middleware;

use DDD\Locale\Service\LocaleServiceInterface;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class Localization
{
    /** @var LocaleServiceInterface */
    private $localeService;

    public function __construct(LocaleServiceInterface $localeService)
    {
        $this->localeService = $localeService;
    }

    public function handle(
        $request,
        \Closure $next
    ) {
        $locale = $this->getLocale();
        if (! $locale) {
            $defaultLocale = $this->localeService->findDefault();
            if ($defaultLocale) {
                Cookie::forever('locale', $defaultLocale->code);
                App::setLocale($defaultLocale->code);
            }
        } else {
            App::setLocale($locale);
        }

        return $next($request);
    }

    /**
     *
     * @return mixed|string
     */
    private function getLocale()
    {

        // TODO если будут подпапки /ru /en, все куки убрать
        $cookie = Cookie::get('locale');
        if (! $cookie) {
            return 'en';
        }

        $cookieLocaleFromString = Crypt::decrypt(Cookie::get('locale'), false);
        $cookieLocaleArray = explode("|", $cookieLocaleFromString);

        return $cookieLocaleArray[1] ?? 'en';
    }
}
