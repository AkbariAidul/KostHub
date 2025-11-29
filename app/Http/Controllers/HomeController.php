<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use App\Models\Category;
use App\Repositories\CityRepository;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;

    public function __construct(
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
    }

    public function index()
    {
        $cities = $this->cityRepository->getAllCities();
        $categories = $this->categoryRepository->getAllCategories();
        $popularBoardingHouses = $this->boardingHouseRepository->getPopularBoardingHouses(5);
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses();

        return view('pages.home', compact('cities', 'categories', 'popularBoardingHouses', 'boardingHouses'));
    }
}
