<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Schedule;
use App\Models\Service;
use App\Models\Cart;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_role')->insert([
            'user_role_name' => 'Admin'
        ]);

        DB::table('user_role')->insert([
            'user_role_name' => 'Member'
        ]);

        DB::table('users')->insert([
            'user_role_id' => 1,
            'username' => 'Admin',
            'name' => 'Admin Admin Admin',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Your Heart my Darling',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'province_id' => 26,
            'city_id' => 166,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'user_role_id' => 2,
            'username' => 'indahmursyida',
            'name' => 'Indah Mursyida Bahrina',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Jalan KH Iskandar Muda',
            'email' => 'indahbahrina@gmail.com',
            'password' => bcrypt('member'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'province_id' => 3,
            'city_id' => 457,
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'user_role_id' => 1,
            'username' => 'Member2',
            'name' => 'Member2 Member2 Member2',
            'birthdate' => '2001-06-18',
            'phone' => '081285879816',
            'address' => 'Jalan KH Iskandar Tua',
            'email' => 'yesikaa02@gmail.com',
            'password' => bcrypt('member'),
            'profile_picture' => 'profile-images/profile_picture_default.jpg',
            'is_banned' => false,
            'province_id' => 3,
            'city_id' => 456,
            'email_verified_at' => now()
        ]);

        Category::create([
            'category_name' => 'Healthy Food'
        ]);

        Category::create([
            'category_name' => 'Body Care'
        ]);


        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '01-11-2022 10.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '01-11-2022 11.00'),
            'status' => 'Booked'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '02-11-2022 11.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '02-11-2022 12.00'),
            'status' => 'Booked'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '03-11-2022 13.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '03-11-2022 14.00'),
            'status' => 'Available'
        ]);

        Schedule::create([
            'start_time' => Carbon::createFromFormat('d-m-Y H.i', '04-11-2022 13.00'),
            'end_time' => Carbon::createFromFormat('d-m-Y H.i', '04-11-2022 14.00'),
            'status' => 'Available'
        ]);

        Cart::create([
            'user_id' => 2,
            'service_id' => 2,
            'schedule_id' => 2,
            'home_service' => 1,
        ]);

        Cart::create([
            'user_id' => 2,
            'service_id' => 1,
            'schedule_id' => 1,
            'home_service' => 0
        ]);

        Cart::create([
            'user_id' => 2,
            'product_id' => 1,
            'quantity' => 1
        ]);

        Cart::create([
            'user_id' => 2,
            'product_id' => 2,
            'quantity' => 3
        ]);

        Product::create([
            'name' => 'Susu Almond (Small)',
            'category_id' => '1',
            'description' => "Manfaat Susu Almond
1. Mengurangi resiko penyakit jantung
2. Mencegah kanker
3. Menurunkan kadar kolestrol jahat
4. Meningkatkan kinerja dan kecerdasan otak
5. Menguatkan tulang
6. Tinggi antioksidan
7. Mengurangi resiko penyakit diabetes
8. Baik untuk diet
9. Tinggi kandungan vitamin E
10. Sangat baik dikonsumsi bumil dan busui untuk tumbuh kembang si kecil",
            'size' => '250 ml',
            'price' => '27000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susualmond.jpg'
        ]);

        Product::create([
            'name' => 'Susu Almond (Medium)',
            'category_id' => '1',
            'description' => "Manfaat Susu Almond
1. Mengurangi resiko penyakit jantung
2. Mencegah kanker
3. Menurunkan kadar kolestrol jahat
4. Meningkatkan kinerja dan kecerdasan otak
5. Menguatkan tulang
6. Tinggi antioksidan
7. Mengurangi resiko penyakit diabetes
8. Baik untuk diet
9. Tinggi kandungan vitamin E
10. Sangat baik dikonsumsi bumil dan busui untuk tumbuh kembang si kecil",
            'size' => '500 ml',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susualmond.jpg'
        ]);

        Product::create([
            'name' => 'Susu Almond (Large)',
            'category_id' => '1',
            'description' => "Manfaat Susu Almond
1. Mengurangi resiko penyakit jantung
2. Mencegah kanker
3. Menurunkan kadar kolestrol jahat
4. Meningkatkan kinerja dan kecerdasan otak
5. Menguatkan tulang
6. Tinggi antioksidan
7. Mengurangi resiko penyakit diabetes
8. Baik untuk diet
9. Tinggi kandungan vitamin E
10. Sangat baik dikonsumsi bumil dan busui untuk tumbuh kembang si kecil",
            'size' => '1000 ml',
            'price' => '95000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/susualmond.jpg'
        ]);

        Product::create([
            'name' => 'Sari Lemon California (Small)',
            'category_id' => '1',
            'description' => "Manfaat Sari Lemon California
1. Proses detox (racun) dalam tubuh
2. Menurunkan berat badan
3. Mencerahkan wajah dan menghilangkan jerawat
4. Menurunkan kolestrol, diabetes dan asam urat
5. Mengobati sakit tenggorokan & batuk
6. Mengobati maag
7. Mengatasi sembelit
8. Mencegah timbulnya sakit kanker
9. Mencegah bau mulut",
            'size' => '250 ml',
            'price' => '60000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/lemon.jpg'
        ]);

        Product::create([
            'name' => 'Sari Lemon California (Medium)',
            'category_id' => '1',
            'description' => "Manfaat Sari Lemon California
1. Proses detox (racun) dalam tubuh
2. Menurunkan berat badan
3. Mencerahkan wajah dan menghilangkan jerawat
4. Menurunkan kolestrol, diabetes dan asam urat
5. Mengobati sakit tenggorokan & batuk
6. Mengobati maag
7. Mengatasi sembelit
8. Mencegah timbulnya sakit kanker
9. Mencegah bau mulut",
            'size' => '500 ml',
            'price' => '100000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/lemon.jpg'
        ]);

        Product::create([
            'name' => 'Safron',
            'category_id' => '1',
            'description' => "Manfaat Safron Afghanistan
* Melancarkan peredaran darah
* Mencegah pertumbuhan sel kanker
* Mengatasi sistem gangguan pencernaan
* Mencegah stress & depresi
* Mempercepat pengeringan luka
* Meringankan batuk
* Menghilangkan jerawat
* Mencegah peradangan paru-paru mengurangi penyakit insomnia
* Menurunkan kadar kolestrol dalam darah
* Mengembalikan stamina tubuh menguatkan sistem imun sebagai anti aging",
            'size' => '1 gr',
            'price' => '110000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/safron.jpg'
        ]);

        Product::create([
            'name' => 'Chiaseed (Small)',
            'category_id' => '1',
            'description' => "Manfaat Chiaseed
* Memberikan tambahan energi bagi tubuh
* Membantu proses pembentukan tulang dan gigi
* Kaya akan asam lemak dan omega-3
* Memerangi kanker payudara dan kanker lainnya
* Mencegah penuaan dini
* Membantu proses detoksivikasi
* Membantu menyeimbangkan berat badan
* Membantu menurunkan kolestrol
* Menurunkan resiko penyakit diabetes
* Menstabilkan tekanan darah",
            'size' => '100 gr',
            'price' => '25000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/chiaseed.jpg'
        ]);

        Product::create([
            'name' => 'Chiaseed (Medium)',
            'category_id' => '1',
            'description' => "Manfaat Chiaseed
* Memberikan tambahan energi bagi tubuh
* Membantu proses pembentukan tulang dan gigi
* Kaya akan asam lemak dan omega-3
* Memerangi kanker payudara dan kanker lainnya
* Mencegah penuaan dini
* Membantu proses detoksivikasi
* Membantu menyeimbangkan berat badan
* Membantu menurunkan kolestrol
* Menurunkan resiko penyakit diabetes
* Menstabilkan tekanan darah",
            'size' => '250 gr',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/chiaseed.jpg'
        ]);

        Product::create([
            'name' => 'Granola Honey',
            'category_id' => '1',
            'description' => "Komposisi:
Almond, mede, cranberry, rolled oat,
kismis kuning, kismis hitam, pumpkin,
sunflower
Manfaat Granola Honey
* Memperbaiki sistem pencernaan
* Meningkatkan sistem kekebalan tubuh
* Membantu menurunkan berat badan
* Meningkatkan energi
* Menurunkan kolestrol
* Mendukung kehamilan yang sehat
* Mengatur tekanan darah
* Mengatasi beberapa kondisi medis
* Mengandung protein nabati yang tinggi",
            'size' => ' gr',
            'price' => '65000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/granola.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Small)',
            'category_id' => '1',
            'description' => "Fungsi madu ternyata tidak sebatas menjadi pemanis alami bagi makanan ataupun bahan masker untuk memperhalus kulit wajah. Tak hanya itu, madu juga memiliki untuk penyembuhan luka karena:
1 Senyawa antibakteri
2. PH rendah
3. Kandungan qula alami
4. Antioksidan",
            'size' => '250 gr',
            'price' => '50000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/madu.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Medium)',
            'category_id' => '1',
            'description' => "Fungsi madu ternyata tidak sebatas menjadi pemanis alami bagi makanan ataupun bahan masker untuk memperhalus kulit wajah. Tak hanya itu, madu juga memiliki untuk penyembuhan luka karena:
1 Senyawa antibakteri
2. PH rendah
3. Kandungan qula alami
4. Antioksidan",
            'size' => '500 gr',
            'price' => '95000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/madu.jpg'
        ]);

        Product::create([
            'name' => 'Madu Hutan (Large)',
            'category_id' => '1',
            'description' => "Fungsi madu ternyata tidak sebatas menjadi pemanis alami bagi makanan ataupun bahan masker untuk memperhalus kulit wajah. Tak hanya itu, madu juga memiliki untuk penyembuhan luka karena:
1 Senyawa antibakteri
2. PH rendah
3. Kandungan qula alami
4. Antioksidan",
            'size' => '1000 gr',
            'price' => '180000',
            'expired_date' => Carbon::create('2024', '08', '23'),
            'stock' => '20',
            'image_path' => '/product-images/madu.jpg'
        ]);

        Service::create([
            'name' => 'Bekam',
            'category_id' => '2',
            'description' => "Manfaat Bekam (Sunnah dan Steril)
ㆍ Membuang sel-sel darah yang mati
ㆍ Menstabilkan tekanan darah
ㆍ Melancarkan peredaran darah
ㆍ Mengeluarkan toksin dalam tubuh
ㆍ Menghilangkan angin dalam badan
ㆍ Mengurangi kolestrol dalam tubuh
ㆍ Meringankan tubuh
ㆍ Melegakan sakit kepala
ㆍ Mengatasi kelelahan",
            'duration' => '30',
            'price' => '150000',
            'image_path' => '/service-images/bekam.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah dan Setrika Wajah',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah
ㆍMencegah penuaan dini
ㆍMelancarkan peredaran darah
ㆍMerelaksasi otot wajah
ㆍMenghilangkan stress
ㆍMengatasi sinusitis
ㆍMengecilkan pori-pori
ㆍDetox kulit secara alami
ㆍMembuat wajah lebih bercahaya
Manfaat Setrika Wajah
ㆍMengencangkan kulit wajah yang sudah mulai mengendur
ㆍMembantu menghilangkan garis-garis halus dan keriput
ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda
ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.
ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini
ㆍUntuk menghilangkan masalah pada kantung mata",
            'duration' => '60',
            'price' => '225000',
            'image_path' => '/service-images/ps.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Lumi SPA, Setrika Wajah, Masker',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah
ㆍMencegah penuaan dini
ㆍMelancarkan peredaran darah
ㆍMerelaksasi otot wajah
ㆍMenghilangkan stress
ㆍMengatasi sinusitis
ㆍMengecilkan pori-pori
ㆍDetox kulit secara alami
ㆍMembuat wajah lebih bercahaya

Manfaat Lumi SPA
ㆍMembersihkan pori-pori dengan sempurna
ㆍTeknologi Oscillation mampu mengangkat kotoran dan minyak di wajah
ㆍMengangkat sel-sel kulit mati
ㆍMampu meningkatkan kesehatan kulit wajah
ㆍDapat mengurangi tanda-tanda penuaan
ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal
ㆍMengatasijerawat dan masalah kulit wajah
ㆍMerangsang produksi kolagen

Manfaat Setrika Wajah
ㆍMengencangkan kulit wajah yang sudah mulai mengendur
ㆍMembantu menghilangkan garis-garis halus dan keriput
ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda
ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.
ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini
ㆍUntuk menghilangkan masalah pada kantung mata

Manfaat Masker
ㆍMemberi nutrisi ke kulit wajah
ㆍMelembabkan kulit wajah
ㆍMengencangkan kulit wajah
ㆍMenghaluskan kulit wajah
ㆍMencerahkan kulit wajah
ㆍEksfoliasi kulif wajah
ㆍMeredakan masalah kulit wajah",
            'duration' => '50',
            'price' => '325000',
            'image_path' => '/service-images/plsm.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah dan Lumi SPA',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah
ㆍMencegah penuaan dini
ㆍMelancarkan peredaran darah
ㆍMerelaksasi otot wajah
ㆍMenghilangkan stress
ㆍMengatasi sinusitis
ㆍMengecilkan pori-pori
ㆍDetox kulit secara alami
ㆍMembuat wajah lebih bercahaya

Manfaat Lumi SPA
ㆍMembersihkan pori-pori dengan sempurna
Teknologi Oscillation mampu mengangkat kotoran dan minyak di wajah
Mengangkat sel-sel kulit mati
ㆍMampu meningkatkan kesehatan kulit wajah
Dapat mengurangi tanda-tanda penuaan
ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal
ㆍMengatasijerawat dan masalah kulit wajah
ㆍMerangsang produksi kolagen",
            'duration' => '50',
            'price' => '175000',
            'image_path' => '/service-images/pl.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Lumi SPA, dan Setrika Wajah',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah
ㆍMencegah penuaan dini
ㆍMelancarkan peredaran darah
ㆍMerelaksasi otot wajah
ㆍMenghilangkan stress
ㆍMengatasi sinusitis
ㆍMengecilkan pori-pori
ㆍDetox kulit secara alami
ㆍMembuat wajah lebih bercahaya

Manfaat Lumi SPA
ㆍMembersihkan pori-pori dengan sempurna
Teknologi Oscillation mampu mengangkat kotoran dan minyak di wajah
Mengangkat sel-sel kulit mati
ㆍMampu meningkatkan kesehatan kulit wajah
Dapat mengurangi tanda-tanda penuaan
ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal
ㆍMengatasijerawat dan masalah kulit wajah
ㆍMerangsang produksi kolagen

Manfaat Setrika Wajah
ㆍMengencangkan kulit wajah yang sudah mulai mengendur
ㆍMembantu menghilangkan garis-garis halus dan keriput
ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda
ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.
ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini
ㆍUntuk menghilangkan masalah pada kantung mata",
            'duration' => '50',
            'price' => '275000',
            'image_path' => '/service-images/pls.jpg'
        ]);

        Service::create([
            'name' => 'Paket Pijat Stres Wajah, Lumi SPA, Setrika Wajah, Masker, Totok Inner Beauty',
            'category_id' => '2',
            'description' => "Manfaat Pijat Stres Wajah
ㆍMencegah penuaan dini
ㆍMelancarkan peredaran darah
ㆍMerelaksasi otot wajah
ㆍMenghilangkan stress
ㆍMengatasi sinusitis
ㆍMengecilkan pori-pori
ㆍDetox kulit secara alami
ㆍMembuat wajah lebih bercahaya

Manfaat Lumi SPA
ㆍMembersihkan pori-pori dengan sempurna
Teknologi Oscillation mampu mengangkat kotoran dan minyak di wajah
Mengangkat sel-sel kulit mati
ㆍMampu meningkatkan kesehatan kulit wajah
Dapat mengurangi tanda-tanda penuaan
ㆍTeknologi putaran silikon head LumiSpa mampu secara nyata menghasilkean sistem pembersih wajah yang maksimal
ㆍMengatasijerawat dan masalah kulit wajah
ㆍMerangsang produksi kolagen

Manfaat Setrika Wajah
ㆍMengencangkan kulit wajah yang sudah mulai mengendur
ㆍMembantu menghilangkan garis-garis halus dan keriput
ㆍMenghilangkan flek hitam yang membandel bertahan di wajah anda
ㆍMembantu mengecilkan pori-pori sehingga anda tidak mudah berjerawat dan berkomedo.
ㆍWajah akan menjadi lebih cerah karena sel-sel kulit mati akan diangkat dengan menggunakan alat setrika wajah ini
ㆍUntuk menghilangkan masalah pada kantung mata

Manfaat Masker Wajah
ㆍMemberi nutrisi ke kulit wajah
ㆍMelembabkan kulit wajah
ㆍMengencangkan kulit wajah
ㆍMenghaluskan kulit wajah
ㆍMencerahkan kulit wajah
ㆍEksfoliasi kulif wajah
ㆍMeredakan masalah kulit wajah",
            'duration' => '120',
            'price' => '385000',
            'image_path' => '/service-images/plsmt.jpeg'
        ]);

        Service::create([
            'name' => 'Paket Totok Punggung dan Bekam',
            'category_id' => '2',
            'description' => "Manfaat Totok Punggung
Metode pengobatan yang dilakukan dengan
menggunakan jari untuk memberikan stimulan pada
titik /simpul syaraf tertentu yang terpusat di area
tulang belakang, yang mana titik /simpul tersebut itu
terkoneksi langsung dengan keluhan penyakit atau
organ yang sedang mengalami gangguan.

Manfaat Bekam (Sunnah dan Steril)
ㆍ Membuang sel-sel darah yang mati
ㆍ Menstabilkan tekanan darah
ㆍ Melancarkan peredaran darah
ㆍ Mengeluarkan toksin dalam tubuh
ㆍ Menghilangkan angin dalam badan
ㆍ Mengurangi kolestrol dalam tubuh
ㆍ Meringankan tubuh
ㆍ Melegakan sakit kepala
ㆍ Mengatasi kelelahan",
            'duration' => '80',
            'price' => '250000',
            'image_path' => '/service-images/ps.jpg'
        ]);

        Service::create([
            'name' => 'Totok Punggung',
            'category_id' => '2',
            'description' => 'Manfaat Totok Punggung
Metode pengobatan yang dilakukan dengan
menggunakan jari untuk memberikan stimulan pada
titik /simpul syaraf tertentu yang terpusat di area
tulang belakang, yang mana titik /simpul tersebut itu
terkoneksi langsung dengan keluhan penyakit atau
organ yang sedang mengalami gangguan.',
            'duration' => '30',
            'price' => '100000',
            'image_path' => '/service-images/totokpunggung.jpg'
        ]);

        Service::create([
            'name' => 'Akupuntur Kecantikan & Kesehatan',
            'category_id' => '2',
            'description' => 'Deskripsi Akupuntur Kecantikan & Kesehatan',
            'duration' => '30',
            'price' => '125000',
            'image_path' => '/service-images/.jpg'
        ]);

        Service::create([
            'name' => 'Fashdu',
            'category_id' => '2',
            'description' => 'Deskripsi Fashdu',
            'duration' => '30',
            'price' => '100000',
            'image_path' => '/service-images/.jpg'
        ]);
    }
}
