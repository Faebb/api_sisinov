<?php

namespace App\Http\Controllers;

use App\Models\Trazabilidad;
use Illuminate\Http\Request;

class reporteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Trazabilidad::all();
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Trazabilidad $trazabilidad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Trazabilidad $trazabilidad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Trazabilidad $trazabilidad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Trazabilidad $trazabilidad)
    {
        //
    }
}
