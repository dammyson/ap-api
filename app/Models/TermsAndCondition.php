<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class TermsAndCondition extends Model
{
    use HasUuids;
    
    protected $fillable = [
        'version',
        'title',
        'content',
        'effective_at',
    ];

    protected $casts = [
        'effective_at' => 'datetime',
    ];

    public function acceptances()
    {
        return $this->hasMany(UserTermsAcceptance::class);
    }


}
