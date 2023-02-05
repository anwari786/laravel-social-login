<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SocialAuth extends Model
{
    use HasFactory;

    //socialauth model
    protected $fillable = ['user_id', 'provider_name', 'provider_id', 'avatar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}