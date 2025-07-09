<?php

namespace App\Http\Controllers;

use App\Mail\InvoiceSend;
use App\Models\Invoice;
use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\InvoiceFormat;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\LaravelPdf\Facades\Pdf;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.invoices.index', [
            'invoices' => Invoice::with('invoice_formats', 'items')->latest()->get(),
            'invoiceFormats' => InvoiceFormat::where('user_id', auth()->user()->id)->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $invoiceFormat = InvoiceFormat::where('slug', $request->query('invoice_format'))->first();
        return view('pages.invoices.create', [
            'format' => $invoiceFormat,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreInvoiceRequest $request)
    {
        $slug = InvoiceFormat::where('slug', $request->invoice_format)->first();

        if( $slug->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }
        $format = $slug;

        $validated = $request->validated();

        $invoiceCode = 'INV-' . strtoupper(auth()->user()->brand_slug) . '-' . Carbon::now()->format('dmY-His');

        $subTotal = 0;
        for( $i = 0; $i < count($validated['name']); $i++ ) {
            $subTotal += $validated['quantity'][$i] * $validated['price'][$i];
        }

        $discount = $validated['discount'] ?? 0;
        $shipment = $validated['shipment'] ?? 0;
        $tax      = $validated['tax'] ?? 0;
        $service  = $validated['service'] ?? 0;

        $billTotal = $subTotal - $discount + $shipment + $tax + $service;

        $invoice = Invoice::create([
            'user_id' => auth()->user()->id,
            'invoice_format_id' => $format->id,
            'invoice_code' => $invoiceCode,
            'receiver' => $validated['receiver'],
            'receiver_email' => $validated['receiver_email'],
            'invoice_date' => $validated['invoice_date'],
            'invoice_address' => $validated['invoice_address'],
            'subtotal' => $subTotal,
            'discount' => $discount,
            'shipment' => $shipment,
            'tax' => $tax,
            'service' => $service,
            'bill_total' => $billTotal,
        ]);

        for( $i = 0; $i < count($validated['name']); $i++ )
        {
            Item::create([
                'invoice_id' => $invoice->id,
                'name' => $validated['name'][$i],
                'price' => $validated['price'][$i],
                'quantity' => $validated['quantity'][$i],
            ]);
        }

        return redirect()->route('invoices.index')->with('status', 'Invoice berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        if( $invoice->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }
        $invoiceFormat = InvoiceFormat::where('id', $invoice->invoice_format_id)->first();
        return view('pages.invoices.edit', [
            'format' => $invoiceFormat,
            'invoice' => $invoice->load('items', 'invoice_formats')
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        if( $invoice->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validated();

        $subTotal = 0;
        for( $i = 0; $i < count($validated['name']); $i++ ) {
            $subTotal += $validated['quantity'][$i] * $validated['price'][$i];
        }

        $discount = $validated['discount'] ?? 0;
        $shipment = $validated['shipment'] ?? 0;
        $tax      = $validated['tax'] ?? 0;
        $service  = $validated['service'] ?? 0;

        $invoice->receiver = $validated['receiver'];
        $invoice->receiver_email = $validated['receiver_email'];
        $invoice->invoice_date = $validated['invoice_date'];
        $invoice->invoice_address = $validated['invoice_address'];
        $invoice->subtotal = $subTotal;
        $invoice->discount = $discount;
        $invoice->shipment = $shipment;
        $invoice->tax = $tax;
        $invoice->service = $service;
        $invoice->bill_total = $subTotal - $discount + $shipment + $tax + $service;
        $invoice->save();


        Item::where('invoice_id', $invoice->id)->delete();

        for( $i = 0; $i < count($validated['name']); $i++ )
        {
            Item::create([
                'invoice_id' => $invoice->id,
                'name' => $validated['name'][$i],
                'price' => $validated['price'][$i],
                'quantity' => $validated['quantity'][$i],
            ]);
        }

        return redirect()->route('invoices.edit', $invoice->invoice_code)->with('status', 'Invoice berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        if( $invoice->user_id !== auth()->user()->id ) {
            abort(403, 'Unauthorized action.');
        }

        $invoice->delete();
        return redirect()->route('invoices.index')->with('status', 'Invoice berhasil dihapus.');
    }

    public function pdf(Invoice $invoice)
    {
        return Pdf::view('pages.invoices.pdf', ['invoice' => $invoice->load('user', 'invoice_formats', 'items')])->format('a4')->inline($invoice->invoice_code . '.pdf');
    }

    public function sendEmail(Invoice $invoice)
    {
        $invoice->load('user', 'items', 'invoice_formats');
        $clientEmail = $invoice->receiver_email;
        try {
            Mail::to($clientEmail)->send(new InvoiceSend($invoice));
            return back()->with('status', 'Email invoice berhasil dikirim ke ' . $clientEmail);
        } catch (\Exception $e) {
            return back()->with('status', 'Gagal mengirim email: ' . $e->getMessage());
        }
    }
}
