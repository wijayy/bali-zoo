<?php

/**
 * This file is part of the IndoRegion package.
 *
 * (c) Azis Hapidin <azishapidin.com | azishapidin@gmail.com>
 *
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use AzisHapidin\IndoRegion\RawDataGetter;
use Illuminate\Support\Facades\DB;

class IndoRegionProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @deprecated
     *
     * @return void
     */
    public function run()
    {
        // Get Data
        $provinces = [
            [
                "id" => 1,
                "name" => "NUSA TENGGARA BARAT (NTB)"
            ],
            [
                "id" => 2,
                "name" => "NUSA TENGGARA BARAT"
            ],
            [
                "id" => 3,
                "name" => "MALUKU"
            ],
            [
                "id" => 4,
                "name" => "KALIMANTAN SELATAN"
            ],
            [
                "id" => 5,
                "name" => "KALIMANTAN TENGAH"
            ],
            [
                "id" => 6,
                "name" => "JAWA BARAT"
            ],
            [
                "id" => 7,
                "name" => "BENGKULU"
            ],
            [
                "id" => 8,
                "name" => "KALIMANTAN TIMUR"
            ],
            [
                "id" => 9,
                "name" => "KEPULAUAN RIAU"
            ],
            [
                "id" => 10,
                "name" => "NANGGROE ACEH DARUSSALAM (NAD)"
            ],
            [
                "id" => 11,
                "name" => "DKI JAKARTA"
            ],
            [
                "id" => 12,
                "name" => "BANTEN"
            ],
            [
                "id" => 13,
                "name" => "JAWA TENGAH"
            ],
            [
                "id" => 14,
                "name" => "JAMBI"
            ],
            [
                "id" => 15,
                "name" => "PAPUA"
            ],
            [
                "id" => 16,
                "name" => "BALI"
            ],
            [
                "id" => 17,
                "name" => "SUMATERA UTARA"
            ],
            [
                "id" => 18,
                "name" => "GORONTALO"
            ],
            [
                "id" => 19,
                "name" => "JAWA TIMUR"
            ],
            [
                "id" => 20,
                "name" => "DI YOGYAKARTA"
            ],
            [
                "id" => 21,
                "name" => "SULAWESI TENGGARA"
            ],
            [
                "id" => 22,
                "name" => "NUSA TENGGARA TIMUR (NTT)"
            ],
            [
                "id" => 23,
                "name" => "SULAWESI UTARA"
            ],
            [
                "id" => 24,
                "name" => "SUMATERA BARAT"
            ],
            [
                "id" => 25,
                "name" => "BANGKA BELITUNG"
            ],
            [
                "id" => 26,
                "name" => "RIAU"
            ],
            [
                "id" => 27,
                "name" => "SUMATERA SELATAN"
            ],
            [
                "id" => 28,
                "name" => "SULAWESI TENGAH"
            ],
            [
                "id" => 29,
                "name" => "KALIMANTAN BARAT"
            ],
            [
                "id" => 30,
                "name" => "PAPUA BARAT"
            ],
            [
                "id" => 31,
                "name" => "LAMPUNG"
            ],
            [
                "id" => 32,
                "name" => "KALIMANTAN UTARA"
            ],
            [
                "id" => 33,
                "name" => "MALUKU UTARA"
            ],
            [
                "id" => 34,
                "name" => "SULAWESI SELATAN"
            ],
            [
                "id" => 35,
                "name" => "SULAWESI BARAT"
            ]
        ];

        // Insert Data to Database
        DB::table('provinces')->insert($provinces);
    }
}
