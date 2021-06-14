<?php

namespace Domain\Locale\Service;

use Domain\Locale\Exceptions\NotFoundException;
use Domain\Locale\Model\LocaleModel;
use Illuminate\Http\Request;

/**
 * Class LocaleService
 * @package Domain\Locale\Service
 * @date: 03.11.2020
 */
class LocaleService implements LocaleServiceInterface
{
    /**
     * @var int
     */
    private $itemsPerPage;

    /**
     * LocaleService constructor.
     */
    public function __construct()
    {
        $this->itemsPerPage = config('app.items_per_page');
    }

    /**
     * Get all Locales
     * @return mixed Collection
     */
    public function findAll()
    {
        $locales = LocaleModel::orderBy('id')->paginate($this->itemsPerPage);

        return $locales;
    }

    /**
     * Get only active locales for other domains
     * @return mixed Collection
     */
    public function findAllActive()
    {
        $locales = LocaleModel::where('status', LocaleModel::LOCALE_STATUS_PUBLISH)->orderBy('id')->get();

        return $locales;
    }

    /**
     * Return Locale by Id
     * @param int $id
     * @return mixed
     * @throws NotFoundException
     */
    public static function findById(int $id)
    {
        $locale = LocaleModel::findOrFail($id);

        return $locale;
    }

    /**
     * Save new Locale
     * @param Request $request
     * @return LocaleModel
     */
    public function store(Request $request): LocaleModel
    {
        $locale = LocaleModel::create($request->all());

        return $locale;
    }

    /**
     * Update existing Locale
     * @param Request $request
     * @param LocaleModel $locale
     * @return LocaleModel
     */
    public function update(Request $request, LocaleModel $locale)
    {
        $request->status = (int)$request->status;
        $locale->update($request->all());

        return $locale;
    }

    /**
     * Remove Locale
     * @param LocaleModel $locale
     * @return bool|null
     * @throws \Exception
     */
    public function destroy(LocaleModel $locale) {
        return $locale->delete();
    }
}

