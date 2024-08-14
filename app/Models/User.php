<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'eccupation',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * 
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function courses()  {
        return $this->belongsToMany(Course::class,'course_students');
    }

    public function subcribe_transactions() {
        return $this->hasMany(SubcribeTransaction::class);
    }

    public function hasActiveSubcription() {
        $latestSubcription = $this->subcribe_transactions()
        ->where('is_paid',true)
        ->latest('updated_at')
        ->first();

        if (!$latestSubcription) {
            return false;
        }
        $subcribtionEndDate = Carbon::parse($latestSubcription->subcription_start_date)->addMonth(1);
        return Carbon::now()->lessThanOrEqualTo($subcribtionEndDate);
    }
}
