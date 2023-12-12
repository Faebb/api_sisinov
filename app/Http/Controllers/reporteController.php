<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Contracts\Service\Attribute\Required;

class reporteController extends Controller
{
    public function repnov(Request $request)
    {

        $dataA = $request->all();

        $tipoNovedad = $dataA['tipoNovedad'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad')
            ->join('tp_novedad', 'novedad.T_Nov', '=', 'tp_novedad.T_Nov')
            ->select('tp_novedad.Nombre_Tn', DB::raw('COUNT(*) as cantidad'));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('novedad.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('novedad.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('novedad.Fe_Nov', '<=', $enddate);
        }

        if ($tipoNovedad !== null) {
            $query->where('novedad.T_Nov', '=', $tipoNovedad);
        }

        $query->groupBy('tp_novedad.Nombre_Tn');

        try {
            $results = $query->get();

            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'name' => $result->Nombre_Tn,
                    'value' => $result->cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Hubo un error al obtener los datos: ' . $e->getMessage()], 500);
        }
    }

    public function repnovsector(Request $request)
    {

        $dataA = $request->all();

        $tipoNovedad = $dataA['tipoNovedad'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad')
            ->join('tp_novedad', 'novedad.T_Nov', '=', 'tp_novedad.T_Nov')
            ->join('sede', 'novedad.ID_S', '=', 'sede.ID_S')
            ->select('sede.Sec_V', DB::raw('COUNT(*) as cantidad'));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('novedad.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('novedad.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('novedad.Fe_Nov', '<=', $enddate);
        }

        if ($tipoNovedad !== null) {
            $query->where('novedad.T_Nov', '=', $tipoNovedad);
        }

        $query->groupBy('sede.Sec_V');

        try {
            $results = $query->get();

            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'name' => 'Sector' . $result->Sec_V,
                    'value' => $result->cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => 'Hubo un error al obtener las empresas: ' . $e->getMessage()], 500);
        }
    }
    public function repnovdia(Request $request)
    {
        $dataA = $request->all();

        $tipoNovedad = $dataA['tipoNovedad'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad as n')
            ->join('tp_novedad as tn', 'n.T_Nov', '=', 'tn.T_Nov')
            ->select(DB::raw("
                CASE DAYOFWEEK(n.Fe_Nov)
                  WHEN 1 THEN 'Domingo'
                  WHEN 2 THEN 'Lunes'
                  WHEN 3 THEN 'Martes'
                  WHEN 4 THEN 'Miércoles'
                  WHEN 5 THEN 'Jueves'
                  WHEN 6 THEN 'Viernes'
                  WHEN 7 THEN 'Sábado'
                END AS Dia_Semana,
                COUNT(*) AS cantidad
            "));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($tipoNovedad !== null) {
            $query->where('n.T_Nov', '=', $tipoNovedad);
        }

        $query->groupBy('Dia_Semana')
            ->orderByRaw('MIN(DAYOFWEEK(n.Fe_Nov))');

        try {
            $results = $query->get();

            // Extraer solo los datos y crear un nuevo array
            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'name' => $result->Dia_Semana,
                    'novedades' => $result->cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener las empresas: " . $e->getMessage();
            return array(); // Devuelve un array vacío en caso de error
        }
    }
    public function repnovhora(Request $request)
    {

        $dataA = $request->all();

        $tipoNovedad = $dataA['tipoNovedad'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad as n')
            ->join('tp_novedad as tn', 'n.T_Nov', '=', 'tn.T_Nov')
            ->select(DB::raw("
                CONCAT(LPAD(HOUR(n.Fe_Nov), 2, '0'), ':00 - ', LPAD(HOUR(n.Fe_Nov) + 1, 2, '0'), ':00') AS Rango_Hora,
                COUNT(*) AS cantidad
            "));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($tipoNovedad !== null) {
            $query->where('n.T_Nov', '=', $tipoNovedad);
        }

        $query->groupBy('Rango_Hora')
            ->orderBy('Rango_Hora');

        try {
            $results = $query->get();

            // Extraer solo los datos y crear un nuevo array
            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'name' => $result->Rango_Hora,
                    'novedades' => $result->cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener las empresas: " . $e->getMessage();
            return array(); // Devuelve un array vacío en caso de error
        }
    }

    public function repempresanov(Request $request)
    {
        $dataA = $request->all();

        $ltempresa = $dataA['ltempresa'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad as n')
            ->join('sede as s', 'n.ID_S', '=', 's.ID_S')
            ->join('empresa as e', 's.id_e', '=', 'e.id_e')
            ->select('e.Nom_E', DB::raw('COUNT(*) as cantidad'));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($ltempresa !== null) {
            $query->where('e.id_e', '=', $ltempresa);
        }

        $query->groupBy('e.Nom_E');

        try {
            $results = $query->get();

            // Extract only the data and create a new array
            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'name' => $result->Nom_E,
                    'value' => $result->cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener los datos: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }

    public function repsedenov(Request $request)
    {

        $dataA = $request->all();

        $ltempresa = $dataA['ltempresa'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad as n')
            ->join('sede as s', 'n.ID_S', '=', 's.ID_S')
            ->join('empresa as e', 's.id_e', '=', 'e.id_e')
            ->select('e.Nom_E', 's.Dic_S', DB::raw('COUNT(*) as cantidad'));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($ltempresa !== null) {
            $query->where('e.id_e', '=', $ltempresa);
        }

        $query->groupBy('e.Nom_E', 's.Dic_S');

        try {
            $results = $query->get();

            // Extract only the data and create a new array
            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'name' => $result->Dic_S,
                    'value' => $result->cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener los datos: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }

    public function rephistnov(Request $request)
    {
        $dataA = $request->all();

        $ltempresa = $dataA['ltempresa'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad as n')
            ->join('tp_novedad as tn', 'n.T_Nov', '=', 'tn.T_Nov')
            ->join('sede as s', 'n.ID_S', '=', 's.ID_S')
            ->join('empresa as e', 's.id_e', '=', 'e.id_e')
            ->select(DB::raw("
                EXTRACT(YEAR_MONTH FROM n.Fe_Nov) AS MesAnio,
                COUNT(*) AS Cantidad
            "));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($ltempresa !== null) {
            $query->where('e.id_e', '=', $ltempresa);
        }

        // Obtener el tipo de novedad más ocurrido
        $tipoNovedadData = $this->getTipoNovedadMasOcurrido($startdate, $enddate, $ltempresa);

        if (!empty($tipoNovedadData)) {
            $tipoNovedad = $tipoNovedadData['TipoNovedad'];
            $query->where('tn.T_Nov', '=', $tipoNovedad);
        }

        $query->groupBy('MesAnio')
            ->orderBy('MesAnio');

        try {
            $results = $query->get();

            // Extract only the data and create a new array
            $data = array();
            foreach ($results as $result) {
                $data[] = array(
                    'Nombre_nov' => $tipoNovedadData['NombreNovedad'],
                    'MesAnio' => $result->MesAnio,
                    'Novedad' => $result->Cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener los datos: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }

    public function repsedetpnov(Request $request)
    {

        $dataA = $request->all();

        $ltempresa = $dataA['ltempresa'];
        $startdate = $dataA['startDate'];
        $enddate = $dataA['endDate'];

        $query = DB::table('novedad as n')
            ->join('tp_novedad as tn', 'n.T_Nov', '=', 'tn.T_Nov')
            ->join('sede as s', 'n.ID_S', '=', 's.ID_S')
            ->join('empresa as e', 's.id_e', '=', 'e.id_e')
            ->select('s.Dic_S', 'tn.Nombre_Tn', DB::raw('COUNT(tn.Nombre_Tn) as cantidad'));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($ltempresa !== null) {
            $query->where('e.id_e', '=', $ltempresa);
        }

        $query->groupBy('s.Dic_S', 'tn.Nombre_Tn');

        try {
            $results = $query->get();

            // Extract only the data and create a new array
            $data = array();
            foreach ($results as $result) {
                $sede = $result->Dic_S;
                $novedad = $result->Nombre_Tn;
                $cantidad = $result->cantidad;

                if (!isset($data[$sede])) {
                    $data[$sede] = array();
                }

                $data[$sede][] = array(
                    'name' => $novedad,
                    'cantidad' => $cantidad
                );
            }

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener los datos: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }

    public function getTipoNovedadMasOcurrido($startdate = null, $enddate = null, $ltempresa = null)
    {
        $query = DB::table('novedad as n')
            ->join('tp_novedad as tn', 'n.T_Nov', '=', 'tn.T_Nov')
            ->join('sede as s', 'n.ID_S', '=', 's.ID_S')
            ->join('empresa as e', 's.id_e', '=', 'e.id_e')
            ->select('tn.T_Nov AS TipoNovedad', 'tn.Nombre_Tn', DB::raw('COUNT(*) as Cantidad'));

        if ($startdate !== null && $enddate !== null) {
            $query->whereBetween('n.Fe_Nov', [$startdate, $enddate]);
        } elseif ($startdate !== null) {
            $query->where('n.Fe_Nov', '>=', $startdate);
        } elseif ($enddate !== null) {
            $query->where('n.Fe_Nov', '<=', $enddate);
        }

        if ($ltempresa !== null) {
            $query->where('e.id_e', '=', $ltempresa);
        }

        $query->groupBy('TipoNovedad', 'Nombre_Tn')
            ->orderBy('Cantidad', 'desc')
            ->limit(1);

        try {
            $result = $query->first();

            // Extract only the data and create a new array
            $data = array(
                'TipoNovedad' => $result->TipoNovedad,
                'NombreNovedad' => $result->Nombre_Tn,
                'Cantidad' => $result->Cantidad
            );

            return $data;
        } catch (\Exception $e) {
            echo "Hubo un error al obtener los datos: " . $e->getMessage();
            return array(); // Return an empty array in case of an error
        }
    }
    public function readtrazabilidad()
    {
        try {
            $result = DB::table('trazabilidad')
                ->select('ID_Tra', 'descripcion')
                ->orderBy('ID_Tra', 'desc')
                ->get();

            if ($result->isEmpty()) {
                return response()->json([
                    'error' => true,
                    'status' => 'error',
                    'message' => 'No results found',
                    'data' => [],
                ], 404);
            } else {
                return response()->json([
                    'error' => false,
                    'status' => 'success',
                    'data' => $result,
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'status' => 'error',
                'message' => 'Método no válido' . $e->getMessage()
            ], 500);
        }
    }
}
