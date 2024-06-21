<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    use HasFactory;
    protected $table = 'etape';
    protected $fillable = ['id','nom','longueur_km','coureurs_par_equipe','rang_etape','id_course','date_depart','heure_depart'];
}
