<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Sabberworm\CSS\Property\Selector;
use Illuminate\Pagination\Paginator;

class Maison_travaux extends Model
{
    use HasFactory;
    protected $table = 'maison_travaux';
    protected $fillable = ['id','maison_data','type_travaux','quantite'];

    public function getMaison_travaux(){
        $result = DB::table("view_maison_data")->paginate(3);
        return $result;
    }

    public function getMaison_montant(){
        $result = DB::select("select * from montant_par_maison");
        return $result;
    }
}
