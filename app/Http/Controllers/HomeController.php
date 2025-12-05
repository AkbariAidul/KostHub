<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\PromoCodeRepositoryInterface; // <--- Import Interface Promo
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private PromoCodeRepositoryInterface $promoCodeRepository; // <--- Property Baru

    public function __construct(
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        PromoCodeRepositoryInterface $promoCodeRepository // <--- Inject di sini
    ) {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->promoCodeRepository = $promoCodeRepository; // <--- Assign di sini
    }

    public function index()
    {
        $cities = $this->cityRepository->getAllCities();
        $categories = $this->categoryRepository->getAllCategories();
        $popularBoardingHouses = $this->boardingHouseRepository->getPopularBoardingHouses(5);
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses();
        
        // Ambil data promo banner yang aktif
        $promoCodes = $this->promoCodeRepository->getActivePromos();

        return view('pages.home', compact(
            'cities', 
            'categories', 
            'popularBoardingHouses', 
            'boardingHouses',
            'promoCodes' // <--- Kirim ke View
        ));
    }
}