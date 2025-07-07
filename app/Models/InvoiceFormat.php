<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InvoiceFormat extends Model
{
    /** @use HasFactory<\Database\Factories\InvoiceFormatFactory> */
    use HasFactory;

    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // relationships
    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function invoices() : HasMany
    {
        return $this->hasMany(Invoice::class);
    }
}
