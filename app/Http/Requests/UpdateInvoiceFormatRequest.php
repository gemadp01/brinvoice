<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceFormatRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
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
        ];
    }
}
