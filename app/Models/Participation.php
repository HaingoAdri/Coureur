<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Participation extends Model
{
    use HasFactory;
    protected $table = 'participation';
    protected $fillable = ['id','id_etape','id_coureur','id_equipe','heure_depart','heure_arrivee','date_arrivee'];

    public function get_participation($equipe){
        $response = DB::select("select * from pview_participation where nom_equipe = '$equipe' order by rang_etape asc");
        return $response;
    }
}
