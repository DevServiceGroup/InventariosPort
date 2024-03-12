<?php

namespace App\Http\Controllers;

use App\Models\Detalle_movimientos;
use App\Models\Inventarios;
use App\Models\Movimientos;
use Illuminate\Http\Request;

class DatatableController extends Controller
{
    public function productos(Request $request)
    {
        if ($request->filled('month')) {
            $month = $request->input('month');
            $parts = explode('-', $month);
            $startDate = now()->setYear($parts[0])->setMonth($parts[1])->startOfMonth();
            $endDate = now()->setYear($parts[0])->setMonth($parts[1])->endOfMonth();
            $inventarios = Inventarios::whereBetween('created_at', [$startDate, $endDate])
                ->where('movimientos_salida_id', null)
                ->get();
        } else {
            $inventarios = Inventarios::whereBetween('created_at', [1, 1])->get();
        }
        return datatables()->collection($inventarios)->toJson();
    }
    public function verdetalles($id)
    {
        $movimiento = Inventarios::where('movimientos_id', '=', $id)->get();

        return response()->json($movimiento);
    }
    public function verdetallessalida($id)
    {
        $movimiento = Inventarios::where('movimientos_salida_id', '=', $id)->get();

        return response()->json($movimiento);
    }
    public function cant_carros()
    {
        $inventarios = Inventarios::where('movimientos_salida_id',null)->get();
        foreach ($inventarios as $inventario) {
            ${$inventario->linea} = 0;
            foreach ($inventarios as $productos) {
                if ($inventario->linea == $productos->linea) {
                    ${$inventario->linea}++;
                }
            }
            $carros["$inventario->linea"] = ${$inventario->linea};
        }
        empty($carros) ? $carros = null : $carros;
        return response()->json($carros);
    }
}
