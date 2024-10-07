<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory, HasUuids;
    
    protected $fillable = [
        'invoice_id',
        'product', // baggages or ticket shopping
        'quantity',
        'price'
    ];
}
