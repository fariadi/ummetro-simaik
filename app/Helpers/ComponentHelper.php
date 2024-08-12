<?php

namespace App\Helpers;


use App\Models\Prodi\TblSmsModel;

class ComponentHelper {
    
    public static function listProdi()
    {
        return TblSmsModel::with('jurusan.fakultas')
                            ->orderBy('jenjang_didik', 'DESC')
                            ->get();
    }
}