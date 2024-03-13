<?php

namespace App\Imports;

use App\Models\Detalle_movimientos;
use App\Models\Inventarios;
use App\Models\Movimientos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class EntradasImport implements ToCollection
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

    private $ubi;

    // Constructor que acepta la variable
    public function __construct($ubi)
    {
        $this->ubi = $ubi;
    }

    public function collection(Collection $rows)
    {
        $movimientos = new Movimientos();
        $movimientos->tipo = 'entrada';

        $cant_carros = 0;

        foreach ($rows as $row) {
            if (Inventarios::where('inventario', '=', $row[8])->exists()) {
                return redirect()->route('admin.entradas.index')->with('duplicado', 'si');  
            } else {
                $movimientos->save();
                $inventario = new Inventarios();
                $inventario->ubicacion = $this->ubi;
                $inventario->buque = $row[0];
                $inventario->color = $row[5];
                $inventario->inventario = $row[8];
                $inventario->linea = $row[12];
                $inventario->movimientos_id = $movimientos->id;
                $inventario->save();
                $cant_carros++;
            }
        }
        $movimientos->cant_carros = $cant_carros;
        $movimientos->motonave = $row[0];
        $movimientos->save();
        // $detallemovimientos = new Detalle_movimientos();
        // $detallemovimientos->;
        return redirect()->route('admin.entradas.index')->with('error', 'no');  ;
    }
}
