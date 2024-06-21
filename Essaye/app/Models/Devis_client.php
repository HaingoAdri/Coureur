<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Devis_client extends Model
{
    use HasFactory;
    protected $table = 'devis_client';
    protected $fillable = ['id','numero','date_devis','date_debut','maison_data', 'finition','lieu'];

    public function getDevis_Id($id){
        $sql = "select id from devis_client where id = '$id'";
        $request = DB::select($sql);
        // var_dump($sql);
        return $request;
    }
}
