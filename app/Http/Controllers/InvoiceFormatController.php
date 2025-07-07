<?php

namespace App\Http\Controllers;

use App\Models\InvoiceFormat;
use App\Http\Requests\StoreInvoiceFormatRequest;
use App\Http\Requests\UpdateInvoiceFormatRequest;

class InvoiceFormatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.formats.index', [
            'formats' => InvoiceFormat::where('user_id', auth()->user()->id)->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.formats.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceFormatRequest $request)
    {

        $validated = $request->validated();
        $validated['user_id'] = auth()->user()->id;

        $validated['slug']= str($request['name'])->slug();
        $nomor = 1;
        while (InvoiceFormat::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = str($validated['name'])->slug() . '-' . $nomor;
            $nomor++;
        }

        InvoiceFormat::create($validated);
        return redirect()->route('formats.index')->with('status', 'Format Invoice berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceFormat $format)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceFormat $format)
    {
        if( $format->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }
        return view('pages.formats.edit', [
            'format' => $format,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceFormatRequest $request, InvoiceFormat $format)
    {
        if( $format->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sender_title' => 'required|string|max:255',
            'sender_label' => 'required|string|max:255',
            'receiver_title' => 'required|string|max:255',
            'receiver_label' => 'required|string|max:255',
            'invoice_date_label' => 'required|string|max:255',
            'invoice_address_label' => 'required|string|max:255',
            'item_label' => 'required|string|max:255',
            'quantity_label' => 'required|string|max:255',
            'price_label' => 'required|string|max:255',
            'price_total_label' => 'required|string|max:255',
            'subtotal_label' => 'required|string|max:255',
            'discount_label' => 'nullable|string|max:255',
            'shipment_label' => 'nullable|string|max:255',
            'tax_label' => 'nullable|string|max:255',
            'service_label' => 'nullable|string|max:255',
            'bill_total_label' => 'required|string|max:255',
            'payment_method_label' => 'required|string|max:255',
            'payment_method_name' => 'required|string|max:255',
            'payment_method_number' => 'required|string|max:255',
        ]);

        $slug = str($validated['name'])->slug();
        $nomor = 1;
        while (InvoiceFormat::where('slug', $slug)->where('id', '!=', $format->id)->exists()) {
            $slug = str($validated['name'])->slug() . '-' . $nomor;
            $nomor++;
        }
        $validated['slug'] = $slug;
        $format->update($validated);
        return redirect()->route('formats.index')->with('status', 'Pengaturan invoice berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceFormat $format)
    {
        if( $format->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }

        $format->delete();
        return redirect()->route('formats.index')->with('status', 'Pengaturan invoice berhasil dihapus.');
    }
}
