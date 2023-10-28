<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $guarded = [] ;
    public function category(){
        return $this->belongsTo(Category::class,"category_id","id");
    }
    public function hobbies()
    {
        return $this->belongsToMany(Hobby::class, 'user_hobbies', 'profile_id', 'hobby_id');
    }

}
