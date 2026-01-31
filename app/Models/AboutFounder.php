<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutFounder extends Model
{
    protected $fillable = [
        'name',
        'role',
        'bio',
        'photo',
        'order',
    ];
}
