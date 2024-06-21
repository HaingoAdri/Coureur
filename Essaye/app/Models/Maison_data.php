<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maison_data extends Model
{
    use HasFactory;
    protected $table = 'maison_data';
    protected $fillable = ['id','nom','descriptions','surface','duree'];
}
