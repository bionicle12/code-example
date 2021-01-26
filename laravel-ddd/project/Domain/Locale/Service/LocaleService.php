<?php

namespace DDD\Locale\Service;

use DDD\Locale\Model\LocaleModel;

class LocaleService implements LocaleServiceInterface
{
    public function getAll()
    {
        $locales = LocaleModel::where('status', LocaleModel::LOCALE_STATUS_PUBLISH)->get()->keyBy('code');
        return $locales;
    }

    public function findDefault()
    {
        $locale = LocaleModel::where('code', 'en')->first();
        return $locale;
    }

    public function findByCode($code)
    {
        return LocaleModel::where('code', $code)->first();
    }
}
