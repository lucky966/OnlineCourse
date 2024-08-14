<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'name',
        'slug',
        'path_trailer',
        'about',
        'thumbnail',
        'teacher_id',
        'category_id',
    ];

    public function category()  {
        return $this->belongsTo(Category::class);
    }
    public function teacher()  {
        return $this->belongsTo(Teacher::class);
    }
    public function courseVideo() {
        return $this->hasMany(CourseVideo::class);
    }
    public function courseKeyPoints()  {
        return $this->hasMany(CourseKeypoint::class);
    }

    public function student ()  {
     return $this->belongsToMany(User::class,'course_students');
    }
}
