<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'birth',
        'phone',
        'address',
    ];

    public function user() {
        return $this->hasOne(User::class);
    }

    public function diary()
    {
        return $this->hasMany(Diary::class);
    }

    public function education()
    {
        return $this->hasMany(Education::class);
    }

    public function course()
    {
        return $this->hasMany(Course::class);
    }

    
}
