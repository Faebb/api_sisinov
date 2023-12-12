<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class novedadUpdateTpNovedadController extends Controller
{    
    public function update(Request $request){
        $datosModel = $request->all();
    
        
    
        
    
        try {
            DB::table('novedad')
                ->where('ID_Nov', $datosModel["ID_Nov"])
                ->update([
                    'T_Nov' => $datosModel["T_Nov"],
                    'Des_Nov' => $datosModel["Des_Nov"],
                    'id_em' => $datosModel["id_em"]
                ]);
    
            return response()->json([
                'error' => false,
                'status' => 'success',
                'message' => 'Update successful',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'Update failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
}
