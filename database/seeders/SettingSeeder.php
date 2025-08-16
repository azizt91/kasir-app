<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::updateStoreSettings([
            'store_name' => 'Minimarket POS',
            'store_address' => 'Jl. Contoh No. 123, Jakarta Selatan',
            'store_phone' => '(021) 1234-5678',
            'store_description' => 'Sistem Point of Sale modern untuk mengelola bisnis minimarket Anda dengan mudah dan efisien',
            'store_logo' => null
        ]);
    }
}
