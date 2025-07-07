<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'invoice_code';
    }

    protected $casts = [
        'invoice_date' => 'date'
    ];

    // relationships
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoice_setting() : BelongsTo
    {
        return $this->belongsTo(InvoiceFormat::class);
    }

    public function items() : HasMany
    {
        return $this->hasMany(Item::class);
    }
}
