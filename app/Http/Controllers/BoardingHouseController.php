<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use App\Models\BoardingHouse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class BoardingHouseController extends Controller
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

    public function show($slug)
    {
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);

        return view('pages.boarding-house.show', compact('boardingHouse'));
    }

    public function rooms($slug)
    {
        $boardingHouse = $this->boardingHouseRepository->getBoardingHouseBySlug($slug);

        return view('pages.boarding-house.rooms', compact('boardingHouse'));
    }

    public function find()
    {
        $cities = $this->cityRepository->getAllCities();
        $categories = $this->categoryRepository->getAllCategories();

        return view ('pages.boarding-house.find', compact('cities', 'categories'));
    }

    public function findResults(Request $request)
    {
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses($request->search, $request->city, $request->category);

        return view('pages.boarding-house.index', compact('boardingHouses'));
    }

    public function saved()
    {
        return view('pages.boarding-house.saved');
    }

    /**
     * API untuk mengambil data kos yang tersimpan di localStorage
     */
    public function getSavedKos(\Illuminate\Http\Request $request)
    {
        // Menerima string slug dipisah koma, contoh: "kos-a,kos-b"
        $slugs = $request->input('slugs');
        
        if (empty($slugs)) {
            return response()->json(['html' => '']);
        }

        $slugArray = explode(',', $slugs);
        
        // Ambil data kos dari database
        $houses = \App\Models\BoardingHouse::whereIn('slug', $slugArray)->get();
        
        if ($houses->isEmpty()) {
            return response()->json(['html' => '']);
        }

        // Render tampilan kartu kos menggunakan partials yang sudah ada
        // Pastikan Anda sudah membuat file resources/views/partials/kos_list.blade.php
        $html = view('partials.kos_list', ['houses' => $houses])->render();

        return response()->json(['html' => $html]);
    }
}
