<?php

namespace Database\Seeders;

use App\Models\BoardingHouse;
use App\Models\Room;
use App\Models\Bonus;
use App\Models\Testimonial;
use App\Models\City;
use App\Models\Category;
use Illuminate\Database\Seeder;

class BoardingHouseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. AMBIL KATEGORI (Ambil ID-nya saja jika ketemu)
        $catHotel = Category::where('slug', 'hotel')->first();
        $catVilla = Category::where('slug', 'villa')->first();
        $catApartemen = Category::where('slug', 'apartemen')->first();
        $catGuestHouse = Category::where('slug', 'guest-house')->first();
        $catCoLiving = Category::where('slug', 'co-living')->first();

        // 2. AMBIL KOTA (Ambil ID-nya saja jika ketemu)
        $bjm = City::where('slug', 'banjarmasin')->first();
        $bjb = City::where('slug', 'banjarbaru')->first();
        $batola = City::where('slug', 'barito-kuala')->first(); 
        $amuntai = City::where('slug', 'amuntai')->first();
        $barabai = City::where('slug', 'barabai')->first();

        // Pengecekan safety agar tidak error jika data null
        if (!$catHotel || !$catVilla || !$catApartemen || !$catGuestHouse || !$catCoLiving) {
            $this->command->error('Data Kategori belum lengkap. Pastikan slug kategori sudah benar.');
            return;
        }
        if (!$bjm || !$bjb || !$batola || !$amuntai || !$barabai) {
            $this->command->error('Data Kota belum lengkap. Pastikan slug kota sudah benar.');
            return;
        }

        $boardingHouses = [
            [
                // 1. HOTEL di BANJARMASIN
                'data' => [
                    'name' => 'Grand Borneo Residence',
                    'slug' => 'grand-borneo-residence',
                    'thumbnail' => 'boarding-houses/hotel-thumb.jpg', 
                    'city_id' => $bjm->id, // [FIX] Ambil ID dari objek
                    'category_id' => $catHotel->id, // [FIX] Ambil ID dari objek
                    'description' => 'Hunian mewah rasa hotel di pusat kota Banjarmasin. Akses mudah ke Duta Mall dan perkantoran.',
                    'price' => 2500000,
                    'address' => 'Jl. Lambung Mangkurat No. 88, Banjarmasin',
                ],
                'rooms' => [
                    ['name' => 'Executive Suite', 'room_type' => 'King Bed', 'square_feet' => 32, 'capacity' => 2, 'price_per_month' => 2500000, 'is_available' => true, 'images' => ['rooms/hotel-1.jpg']]
                ],
                'bonuses' => [
                    ['image' => 'bonuses/pool.png', 'name' => 'Swimming Pool', 'description' => 'Kolam renang indoor'],
                    ['image' => 'bonuses/gym.png', 'name' => 'Gym Center', 'description' => 'Alat fitness lengkap'],
                ],
                'testimonials' => [
                    ['photo' => 'testimonials/user1.jpg', 'name' => 'Rina S.', 'content' => 'Fasilitasnya juara, beneran kayak hotel bintang 5.', 'rating' => 5]
                ]
            ],
            [
                // 2. VILLA di BARITO KUALA
                'data' => [
                    'name' => 'Villa Riverside Batola',
                    'slug' => 'villa-riverside-batola',
                    'thumbnail' => 'boarding-houses/villa-thumb.jpg',
                    'city_id' => $batola->id, // [FIX]
                    'category_id' => $catVilla->id, // [FIX]
                    'description' => 'Villa asri di pinggiran sungai Barito. Suasana tenang, cocok untuk healing dan istirahat dari hiruk pikuk kota.',
                    'price' => 3500000,
                    'address' => 'Jl. Trans Kalimantan, Handil Bakti',
                ],
                'rooms' => [
                    ['name' => 'Riverside Villa', 'room_type' => 'Entire House', 'square_feet' => 60, 'capacity' => 4, 'price_per_month' => 3500000, 'is_available' => true, 'images' => ['rooms/villa-1.jpg']]
                ],
                'bonuses' => [
                    ['image' => 'bonuses/garden.png', 'name' => 'Private Garden', 'description' => 'Taman luas'],
                    ['image' => 'bonuses/fishing.png', 'name' => 'Fishing Area', 'description' => 'Area memancing'],
                ],
                'testimonials' => [
                    ['photo' => 'testimonials/user2.jpg', 'name' => 'Agus W.', 'content' => 'Pemandangan sungainya bagus banget pas sore.', 'rating' => 5]
                ]
            ],
            [
                // 3. APARTEMEN di BANJARBARU
                'data' => [
                    'name' => 'Skyview Apartment BJB',
                    'slug' => 'skyview-apartment-bjb',
                    'thumbnail' => 'boarding-houses/apart-thumb.jpg',
                    'city_id' => $bjb->id, // [FIX]
                    'category_id' => $catApartemen->id, // [FIX]
                    'description' => 'Apartemen modern dekat Bandara Syamsudin Noor. Keamanan 24 jam dan fully furnished.',
                    'price' => 1800000,
                    'address' => 'Jl. A. Yani Km 33, Banjarbaru',
                ],
                'rooms' => [
                    ['name' => 'Studio Unit', 'room_type' => 'Studio', 'square_feet' => 24, 'capacity' => 2, 'price_per_month' => 1800000, 'is_available' => true, 'images' => ['rooms/apart-1.jpg']]
                ],
                'bonuses' => [
                    ['image' => 'bonuses/security.png', 'name' => '24h Security', 'description' => 'CCTV & Access Card'],
                    ['image' => 'bonuses/wifi.png', 'name' => 'High Speed WiFi', 'description' => 'Up to 100Mbps'],
                ],
                'testimonials' => [
                    ['photo' => 'testimonials/user3.jpg', 'name' => 'Sarah L.', 'content' => 'Praktis banget tinggal di sini, deket bandara.', 'rating' => 4]
                ]
            ],
            [
                // 4. GUEST HOUSE di AMUNTAI
                'data' => [
                    'name' => 'Amuntai Syariah Guest House',
                    'slug' => 'amuntai-syariah-guest-house',
                    'thumbnail' => 'boarding-houses/gh-thumb.jpg',
                    'city_id' => $amuntai->id, // [FIX]
                    'category_id' => $catGuestHouse->id, // [FIX]
                    'description' => 'Penginapan keluarga yang nyaman dan bersih di pusat kota Amuntai. Sesuai syariah Islam.',
                    'price' => 800000,
                    'address' => 'Jl. Basuki Rahmat, Amuntai Tengah',
                ],
                'rooms' => [
                    ['name' => 'Family Room', 'room_type' => 'Double Bed', 'square_feet' => 20, 'capacity' => 3, 'price_per_month' => 800000, 'is_available' => true, 'images' => ['rooms/gh-1.jpg']]
                ],
                'bonuses' => [
                    ['image' => 'bonuses/breakfast.png', 'name' => 'Free Breakfast', 'description' => 'Nasi Kuning'],
                    ['image' => 'bonuses/prayer.png', 'name' => 'Musholla', 'description' => 'Ruang sholat luas'],
                ],
                'testimonials' => [
                    ['photo' => 'testimonials/user4.jpg', 'name' => 'H. Udin', 'content' => 'Alhamdulillah nyaman banar gasan keluarga.', 'rating' => 5]
                ]
            ],
            [
                // 5. CO-LIVING di BARABAI
                'data' => [
                    'name' => 'Barabai Creative Hub',
                    'slug' => 'barabai-creative-hub',
                    'thumbnail' => 'boarding-houses/coliving-thumb.jpg',
                    'city_id' => $barabai->id, // [FIX]
                    'category_id' => $catCoLiving->id, // [FIX]
                    'description' => 'Tempat tinggal sekaligus ruang kerja kreatif untuk anak muda Barabai. Komunitas seru dan fasilitas lengkap.',
                    'price' => 1000000,
                    'address' => 'Jl. Murakata, Barabai',
                ],
                'rooms' => [
                    ['name' => 'Creative Pod', 'room_type' => 'Single Bed', 'square_feet' => 12, 'capacity' => 1, 'price_per_month' => 1000000, 'is_available' => true, 'images' => ['rooms/coliving-1.jpg']]
                ],
                'bonuses' => [
                    ['image' => 'bonuses/workspace.png', 'name' => 'Co-working', 'description' => 'Meja kerja & kursi'],
                    ['image' => 'bonuses/coffee.png', 'name' => 'Pantry', 'description' => 'Dapur bersama'],
                ],
                'testimonials' => [
                    ['photo' => 'testimonials/user5.jpg', 'name' => 'Dika', 'content' => 'Vibes-nya asik buat kerja remote.', 'rating' => 4]
                ]
            ],
        ];

        // EKSEKUSI LOOPING
        foreach ($boardingHouses as $item) {
            // Gunakan firstOrCreate untuk Kos agar tidak duplikat saat di-seed ulang
            $boardingHouse = BoardingHouse::firstOrCreate(
                ['slug' => $item['data']['slug']],
                $item['data']
            );

            // Create Rooms
            foreach ($item['rooms'] as $roomData) {
                $images = $roomData['images'];
                unset($roomData['images']);

                $room = Room::create([
                    'boarding_house_id' => $boardingHouse->id,
                    ...$roomData
                ]);

                // Simpan gambar kamar (Asumsi tabel room_images ada)
                foreach ($images as $img) {
                    if (class_exists('App\Models\RoomImage')) {
                        \App\Models\RoomImage::create([
                            'room_id' => $room->id,
                            'image' => $img
                        ]);
                    }
                }
            }

            foreach ($item['bonuses'] as $bonusData) {
                Bonus::create(['boarding_house_id' => $boardingHouse->id, ...$bonusData]);
            }

            foreach ($item['testimonials'] as $testiData) {
                Testimonial::create(['boarding_house_id' => $boardingHouse->id, ...$testiData]);
            }
        }
    }
}s