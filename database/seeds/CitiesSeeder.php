<?php

use App\Models\City;
use Illuminate\Database\Seeder;

class CitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $citiesArrAr = [
            "الرياض", "المدينة المنورة", "بريدة", "الدمام", "الاحساء", "القطيف", "خميس مشيط", "الطائف", "حفر الباطن", "الجبيل", "ضباء", "الخرج", "الخبر", "عرعر", "الحوية", "عنيزة", "سكاكا", "الظهران", "الحوطة", "تبوك", "الأفلاج", "القصيم", "مكة", "الشرقية", "نجران", "الحدود الشمالية", "الجوف", "الباحة", "جيزان", "عسير",
        ];

        $citiesArrEn = [
            "Riyadh", "Madinah", "Buraidah", "Dammam", "Al Ahsa", "Qatif", "Khamis Mushait", "Taif", "Hafr Al Batin", "Jubail", "Duba", "Al Kharj", "Al-Khobar", "Arar", "Al-Hawiyah", "Unaizah", "Sakakah", "Dhahran", "Al-Hawa", "Tabuk", "Aflaj", "Qassim", "Makkah", "Sharqiya", "Najran", "Northern Borders", "Jouf", "Baha", "Jizan", "Asir",
        ];

        if (City::count() == 0) {
            foreach ($citiesArrAr as $city) {
                City::create([
                    'name' => $city,
                ]);
            }
        }
    }
}
