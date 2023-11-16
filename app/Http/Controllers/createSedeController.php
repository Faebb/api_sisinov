<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sede;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class createSedeController extends Controller
{
    public function createSede(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'Dic_S' => 'required|string|max:80',
            'Sec_V' => 'required|integer|digits:1',
            'id_e' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        DB::beginTransaction();
        try {
            $sede = new Sede([
                'Dic_S' => $data['Dic_S'],
                'Sec_V' => $data['Sec_V'],
                'est_sed' => '0',
                'id_e' => $data['id_e'],
            ]);

            $sede->save();
            DB::commit();
            return response()->json(['message' => 'sede creada con éxito'], 201); // 201 Created  
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear la sede'], 500); // 500 Internal Server Error
        }
    }
}
