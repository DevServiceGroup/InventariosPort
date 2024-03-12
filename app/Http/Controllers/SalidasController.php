<?php

namespace App\Http\Controllers;

use App\Models\Inventarios;
use App\Models\Movimientos;
use App\Models\Salidas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalidasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admin = User::find(Auth::id())->getRoleNames()->first()=='admin' ?  "si":'no';
        $movimientos = Movimientos::where('tipo', '=', 'salida')->get();

        return view('salidas')->with('movimientos', $movimientos)->with('admin',$admin);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->filled('tipo_vehiculo') && $request->filled('inventarios') && $request->filled('placa_vehiculo')) {
            $salida = new Movimientos();
            $cant_carros = explode('-', $request->input('inventarios'));
            $salida->cant_carros = count($cant_carros);
            $salida->save();
            foreach ($cant_carros as $cant_carro) {
                $carro = Inventarios::where('inventario', $cant_carro)->first();
                if ($carro->movimientos_salida_id != null) {
                    return back()->with('yasalio', 'si');
                }
                $carro->movimientos_salida_id = $salida->id;
                $carro->save();
            }
            $salida->vehiculo = $request->input('tipo_vehiculo');
            $salida->placa_vehiculo = $request->input('placa_vehiculo');
            $salida->tipo = 'salida';
            $salida->save();
            return back()->with('error', 'no');
        } else {
            return back()->with('error', 'si');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimientos $salidas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimientos $salidas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimientos $salidas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimientos $salidas)
    {
        //
    }
}
