<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Redirect;

class BrandController extends Controller
{
    public function edit() {
        return view('pages.brand.edit');
    }

    public function update(Request $request) {


        // validasi
        $validated = $request->validate([
            'brand_name' => 'required|string|max:255',
            'brand_logo_path' => 'file|image|max:2048',
            'phone_number' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:10',
        ]);


        // upload logo jika ada
        if( $request->hasFile('brand_logo_path') ) {
            if(Auth::user()->brand_logo_path != '') {
                Storage::delete(Auth::user()->brand_logo_path);
            }

            $validated['brand_logo_path'] = $request->file('brand_logo_path')->store('brand-logos');
        }

        // bikin slug dari brand_name
        $validated['brand_slug'] = str($validated['brand_name'])->slug();
        $nomor = 1;
        while( User::where('brand_slug', $validated['brand_slug'])->exists() ) {
            $validated['brand_slug'] = str($validated['brand_name'])->slug() . '-' . $nomor;
            $nomor++;
        }


        User::where('id', Auth::user()->id)->update($validated);
        return Redirect::route('brand.edit')->with('status', 'brand-updated');
    }
}
