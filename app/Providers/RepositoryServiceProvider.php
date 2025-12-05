<?php

namespace App\Providers;

use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\PromoCodeRepositoryInterface;
use App\Interfaces\TransactionRepositoryInterfaces;
use App\Models\Transaction;
use App\Repositories\CityRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\BoardingHouseRepository;
use App\Repositories\PromoCodeRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(BoardingHouseRepositoryInterface::class, BoardingHouseRepository::class);    
        $this->app->bind(TransactionRepositoryInterfaces::class, TransactionRepository::class);
        $this->app->bind(PromoCodeRepositoryInterface::class,PromoCodeRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
