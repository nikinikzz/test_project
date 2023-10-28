<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hobby extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function profiles()
    {
        return $this->belongsToMany(Profile::class, 'user_hobbies', 'hobby_id', 'profile_id');
    }

}
