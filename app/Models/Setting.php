<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'store_name',
        'store_address',
        'store_phone',
        'store_logo',
        'store_description',
    ];

    /**
     * Get the store settings (singleton pattern)
     */
    public static function getStoreSettings()
    {
        $settings = self::first();

        if (!$settings) {
            $settings = self::create([
                'store_name' => 'Minimarket POS',
                'store_address' => 'Jl. Contoh No. 123',
                'store_phone' => '(021) 1234567',
                'store_description' => 'Sistem Point of Sale modern untuk mengelola bisnis minimarket Anda dengan mudah dan efisien'
            ]);
        }

        return $settings;
    }

    /**
     * Update store settings
     */
    public static function updateStoreSettings($data)
    {
        $settings = self::getStoreSettings();
        $settings->update($data);
        return $settings;
    }
}
