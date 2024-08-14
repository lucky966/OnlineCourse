<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcribeTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'total_amount',
        'is_paid',
        'proof',
        'user_id',
        'subcription_start_date',
    ];
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
