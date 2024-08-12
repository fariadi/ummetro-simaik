<?php

namespace App\Helpers;
use Illuminate\Support\Facades\DB;

class RequestFilterHelper {
    
    public static function fieldKey($allowKey = null, $params = null){

        if(empty($allowKey))
            return null;
            
        $params    = collect($params);
    
        $setToKey  = collect($allowKey)->keys();
        $recordKey = $params->only($setToKey);
        $valuesKey = [];
        foreach ($recordKey as $key => $value) {
            $valuesKey[] = [$allowKey[$key], '=', $value];
        }

        return $valuesKey;
    }

    public static function nomFormulir($allowKey = []){
        /** ****************************************************
         * $allowKey[] = ['jenis_penerimaan_id', '=', $jenis_pendrimaan_id];
         * $allowKey[] = ['tahun', '=', $tahun]
         * ******************************************************
         * SUBSTR("010240001", 6, 4) => 0001
         */
        $formulir = DB::table('formulir')
             ->select(DB::raw('substr(formulir.nomor,6, 4) as kode'))
             ->where($allowKey)
             ->orderBy('kode','desc')
             ->first();

        $kode = (!empty($formulir)) ? intval($formulir->kode) + 1 : 1;
        $kode = str_pad($kode,4,'0',STR_PAD_LEFT);
        return $kode;
    }
}