<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'detail_user_id', 'title', 'course_type_id', 'price', 'discount', 'benerfit',
    ];

    public function courseType()
    {
        return $this->belongsTo(CourseType::class);
    }

    public function detailUser()
    {
        return $this->belongsTo(DetailUser::class);
    }

    public function detailCourse()
    {
        return $this->hasMany(DetailCourse::class);
    }
}
