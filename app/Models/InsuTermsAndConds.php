<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuTermsAndConds extends Model
{
    //
    use HasFactory, HasUuids;

    protected $fillable = [
        'version',
        'title',
        'content',
        'effective_at',
       
    ];
}
