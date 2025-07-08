<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
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
            'receiver' => 'required|string|max:255',
            'receiver_email' => 'required|email|max:255',
            'invoice_date' => 'required|date',
            'invoice_address' => 'required',
            'name'  => 'required|array',
            'name.*' => 'required|max:255',
            'quantity' => 'required|array',
            'quantity.*' => 'required|numeric|integer|min:1',
            'price' => 'required|array',
            'price.*' => 'required|numeric|integer|min:0',
            'discount' => 'sometimes|nullable|numeric|integer|min:0',
            'shipment' => 'sometimes|nullable|numeric|integer|min:0',
            'tax' => 'sometimes|nullable|numeric|integer|min:0',
            'service' => 'sometimes|nullable|numeric|integer|min:0',
        ];
    }
    protected function prepareForValidation()
    {
        $this->merge([
            'name' => array_map('trim', $this->input('name', [])),
            'receiver' => trim($this->input('receiver', '')),
            'receiver_email' => trim($this->input('receiver_email', '')),
            'invoice_address' => trim($this->input('invoice_address', '')),
        ]);
    }
}
