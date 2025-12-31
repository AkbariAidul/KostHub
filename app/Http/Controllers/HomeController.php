<?php

namespace App\Http\Controllers;

use App\Interfaces\BoardingHouseRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CityRepositoryInterface;
use App\Interfaces\PromoCodeRepositoryInterface;
use App\Models\BoardingHouse; // Jangan lupa import Model ini
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private CityRepositoryInterface $cityRepository;
    private CategoryRepositoryInterface $categoryRepository;
    private BoardingHouseRepositoryInterface $boardingHouseRepository;
    private PromoCodeRepositoryInterface $promoCodeRepository;

    public function __construct(
        CityRepositoryInterface $cityRepository,
        CategoryRepositoryInterface $categoryRepository,
        BoardingHouseRepositoryInterface $boardingHouseRepository,
        PromoCodeRepositoryInterface $promoCodeRepository
    ) {
        $this->cityRepository = $cityRepository;
        $this->categoryRepository = $categoryRepository;
        $this->boardingHouseRepository = $boardingHouseRepository;
        $this->promoCodeRepository = $promoCodeRepository;
    }

    public function index()
    {
        $cities = $this->cityRepository->getAllCities();
        $categories = $this->categoryRepository->getAllCategories();
        $popularBoardingHouses = $this->boardingHouseRepository->getPopularBoardingHouses(5);
        $boardingHouses = $this->boardingHouseRepository->getAllBoardingHouses();
        $promoCodes = $this->promoCodeRepository->getActivePromos();

        return view('pages.home', compact(
            'cities', 
            'categories', 
            'popularBoardingHouses', 
            'boardingHouses',
            'promoCodes'
        ));
    }

    // Method baru untuk menangani AJAX Search & Filter
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $categorySlug = $request->input('category');

        $query = BoardingHouse::query();

        // 1. Filter Kategori (Jika ada dan bukan 'all')
        if ($categorySlug && $categorySlug !== 'all') {
            $query->whereHas('category', function($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        // 2. Filter Keyword Search (Jika user mengetik)
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhereHas('city', function($subQ) use ($keyword) {
                      $subQ->where('name', 'like', "%{$keyword}%");
                  });
            });
        }

        $boardingHouses = $query->get();

        // Generate HTML output
        $html = '';
        
        if ($boardingHouses->isEmpty()) {
            $html .= '
            <div class="col-span-full text-center py-10 flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-3">
                    <svg class="w-8 h-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <p class="text-slate-500 font-bold text-sm">Yah, kos tidak ditemukan.</p>
                <p class="text-slate-400 text-xs mt-1">Coba kata kunci atau kategori lain ya.</p>
            </div>';
        }

        foreach ($boardingHouses as $house) {
            $url = route('kos.show', $house->slug);
            $thumb = asset('storage/' . $house->thumbnail);
            $price = number_format($house->price / 1000, 0); // Format ribuan (500rb)
            $rating = $house->testimonials->avg('rating') ? number_format($house->testimonials->avg('rating'), 1) : '4.5';
            $categoryName = $house->category->name;
            $cityName = $house->city->name;
            
            // Menggunakan Layout Kartu Horizontal (Sesuai desain baru)
            $html .= <<<HTML
            <a href="{$url}" class="group block bg-white rounded-3xl p-3 border border-slate-100 shadow-sm hover:shadow-lg transition-all duration-300 active:scale-[0.99]">
                <div class="flex gap-4">
                    <div class="relative w-28 h-28 rounded-2xl overflow-hidden shrink-0 bg-slate-100">
                        <img src="{$thumb}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute top-2 right-2 bg-white/90 backdrop-blur px-1.5 py-0.5 rounded-md flex items-center gap-0.5 shadow-sm">
                            <svg class="w-3 h-3 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            <span class="text-[10px] font-bold text-slate-800">{$rating}</span>
                        </div>
                    </div>
                    
                    <div class="flex flex-col justify-between flex-1 py-1">
                        <div>
                            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wide">{$categoryName}</span>
                            <h3 class="font-bold text-slate-800 text-base leading-tight mb-1 line-clamp-2">{$house->name}</h3>
                            <div class="flex items-center gap-1 text-slate-400 text-xs">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                {$cityName}
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <p class="font-extrabold text-[#4FA8C0] text-base">
                                Rp {$price}rb<span class="text-slate-400 font-medium text-[10px]">/bln</span>
                            </p>
                            <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400 group-hover:bg-[#4FA8C0] group-hover:text-white transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
HTML;
        }

        return response()->json(['html' => $html]);
    }

    public function help()
{
    return view('pages.help');
}

public function saved()
{
    return view('pages.boarding-house.saved');
}

public function getSavedKos(Request $request)
{
    // Menerima string slug dipisah koma, contoh: "kos-a,kos-b"
    $slugs = explode(',', $request->input('slugs'));
    
    $houses = \App\Models\BoardingHouse::whereIn('slug', $slugs)->get();
    
    if ($houses->isEmpty()) {
        return response()->json(['html' => '']);
    }

    // Reuse partials yang sudah kita buat sebelumnya
    $html = view('partials.kos_list', ['houses' => $houses])->render();

    return response()->json(['html' => $html]);
}
}