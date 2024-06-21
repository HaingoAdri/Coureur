<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_travaux extends Model
{
    use HasFactory;
    protected $table = 'type_travaux';
    protected $fillable = ['id','nom','unite','pu'];
}
