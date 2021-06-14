<?php

namespace App\Http\Controllers\Locale;

use App\Http\Controllers\Controller;
use Domain\Locale\Request\LocaleStoreRequest;
use Domain\Locale\Request\LocaleUpdateRequest;
use Domain\Locale\Service\LocaleServiceInterface;
use Illuminate\Http\Request;

/**
 * Class LocaleController
 * @package App\Http\Controllers\Locale
 * @date: 03.11.2020
 */
class LocaleController extends Controller
{
    /**
     * @var LocaleServiceInterface
     */
    private $localeService;

    public function __construct(LocaleServiceInterface $localeService)
    {
        $this->localeService = $localeService;
    }

    public function index()
    {
        $locales = $this->localeService->findAll();

        return response()->json($locales);
    }

    public function activeLocales()
    {
        $locales = $this->localeService->findAllActive();

        return response()->json($locales);
    }

    public function store(LocaleStoreRequest $request)
    {
        $locale = $this->localeService->store($request);

        return response()->json($locale);
    }

    public function edit(Request $request, int $id)
    {
        $locale = $this->localeService->findById($id);

        return response()->json($locale);
    }

    public function update(LocaleUpdateRequest $request, int $id)
    {
        $locale = $this->localeService->findById($id);

        $locale = $this->localeService->update($request, $locale);

        return response()->json($locale);
    }
}
