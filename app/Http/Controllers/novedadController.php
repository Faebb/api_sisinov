<?php

namespace App\Http\Controllers;

use App\Models\Novedad;
use Illuminate\Http\Request;

class novedadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Novedad::all();
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
    public function show(Novedad $novedad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Novedad $novedad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Novedad $novedad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Novedad $novedad)
    {
        //
    }
}
