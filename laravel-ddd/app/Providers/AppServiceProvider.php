<?php

namespace App\Providers;

use App\Exceptions\Handler;
use DDD\Banner\Repository\BannerRepository;
use DDD\Banner\Repository\BannerRepositoryInterface;
use DDD\Banner\Service\BannerService;
use DDD\Banner\Service\BannerServiceInterface;
use DDD\FMenu\Repository\FMenuRepository;
use DDD\FMenu\Repository\FMenuRepositoryInterface;
use DDD\FMenu\Service\FMenuService;
use DDD\FMenu\Service\FMenuServiceInterface;
use DDD\HMenu\Repository\HMenuRepository;
use DDD\Locale\Service\LocaleService;
use DDD\Locale\Service\LocaleServiceInterface;
use DDD\HMenu\Service\HMenuService;
use DDD\HMenu\Service\HMenuServiceInterface;
use DDD\HMenu\Repository\HMenuRepositoryInterface;
use DDD\Page\Repository\PageRepository;
use DDD\Page\Repository\PageRepositoryInterface;
use DDD\Page\Service\PageService;
use DDD\Page\Service\PageServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\Illuminate\Foundation\Exceptions\Handler::class, Handler::class);
    }

    public function registerBindings()
    {
        $this->app->bind(LocaleServiceInterface::class, LocaleService::class);

        $this->app->bind(HMenuServiceInterface::class, HMenuService::class);
        $this->app->bind(HMenuRepositoryInterface::class, HMenuRepository::class);

        $this->app->bind(PageServiceInterface::class, PageService::class);
        $this->app->bind(PageRepositoryInterface::class, PageRepository::class);

        $this->app->bind(FMenuServiceInterface::class, FMenuService::class);
        $this->app->bind(FMenuRepositoryInterface::class, FMenuRepository::class);

        $this->app->bind(BannerServiceInterface::class, BannerService::class);
        $this->app->bind(BannerRepositoryInterface::class, BannerRepository::class);
    }
}
