<?php

namespace App\Http\Controllers;

use App\Imports\EntradasImport;
use App\Models\Inventarios;
use App\Models\Movimientos;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EntradasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movimientos = Movimientos::where('tipo', '=', 'entrada')->get();
        return view('entradas')->with('movimientos', $movimientos);
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
        if ($request->hasFile('archivo')) {
            $archivo = $request->file('archivo');

            if ($request->filled('unico')) {
                $ubicacion = $request->input('unico');
                Excel::import(new EntradasImport($ubicacion), $archivo);
            } else {
                $ubicacion = null;
                Excel::import(new EntradasImport($ubicacion), $archivo);
            }
            // $movimientos->cant_vehiculos=


            return back()->with('error', 'no');
        } else if ($request->filled('num_inicial') && $request->filled('num_final') && $request->filled('ubi')) {
            $inicial = $request->input('num_inicial');
            for ($inicial; $inicial <=  $request->input('num_final'); $inicial++) {
                $carro = Inventarios::where('inventario', $inicial)->first();
                if (!empty($carro)) {
                    $carro->ubicacion = $request->input('ubi');
                    $carro->save();
                } else {
                    return back()->with('error','si');
                }
            }
            return back()->with('error', 'no');
        } else {
            return back()->with('error', 'si');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventarios $entradas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inventarios $entradas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventarios $entradas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventarios $entradas)
    {
        //
    }
}
