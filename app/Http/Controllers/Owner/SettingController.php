<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function edit()
    {
        $setting = StoreSetting::firstOrNew();
        return view('owner.settings.edit', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'province' => 'required|string',
            'city' => 'required|string',
            'district' => 'required|string',
            'bank_name' => 'nullable|string|max:255',
            'bank_account_number' => 'nullable|string|max:255',
            'bank_account_holder' => 'nullable|string|max:255',
            'qris_image' => 'nullable|image|max:2048',
        ]);

        $setting = StoreSetting::firstOrNew();
        
        $data = $request->except(['qris_image', '_token', '_method']);
        
        if ($request->hasFile('qris_image')) {
            // Delete old image if exists
            if ($setting->qris_image && Storage::disk('public')->exists($setting->qris_image)) {
                Storage::disk('public')->delete($setting->qris_image);
            }
            $path = $request->file('qris_image')->store('payment-methods', 'public');
            $data['qris_image'] = $path;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('owner.settings.edit')->with('success', 'Pengaturan toko berhasil diperbarui');
    }
}
