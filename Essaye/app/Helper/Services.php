<?php

namespace App\Helper;
use Illuminate\Support\Facades\DB;

class Services
{
    public function initisalisation_table($nom_table){
        $sql = "SELECT pg_get_serial_sequence('$nom_table', 'id');";
        $response_table = DB::select($sql);
        if(count($response_table)>0){
            foreach($response_table as $fk){
                if($fk->pg_get_serial_sequence != null){
                    $seq = "alter sequence $fk->pg_get_serial_sequence restart with 1;";
                    DB::statement(($seq));
                }
            }
        }
        $query = "truncate table $nom_table cascade";
        $result = DB::statement($query);
        return $result;
    }

    public function restartsequence($seq){
        DB::statement("alter sequence $seq restart with 1");
    }
}
