<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Show the settings form
     */
    public function index()
    {
        $settings = Setting::getStoreSettings();
        
        return view('settings.index', compact('settings'));
    }

    /**
     * Update the settings
     */
    public function update(Request $request)
    {
        
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string|max:500',
            'store_phone' => 'nullable|string|max:50',
            'store_description' => 'nullable|string|max:1000',
            'store_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['store_name', 'store_address', 'store_phone', 'store_description']);
        
        // Handle logo upload
        if ($request->hasFile('store_logo')) {
            $settings = Setting::getStoreSettings();
            
            // Delete old logo if exists
            if ($settings->store_logo && Storage::disk('public')->exists($settings->store_logo)) {
                Storage::disk('public')->delete($settings->store_logo);
            }
            
            // Store new logo
            $logoPath = $request->file('store_logo')->store('logos', 'public');
            $data['store_logo'] = $logoPath;
        }

        Setting::updateStoreSettings($data);

        return redirect()->route('settings.index')
            ->with('success', 'Pengaturan berhasil disimpan');
    }
}
