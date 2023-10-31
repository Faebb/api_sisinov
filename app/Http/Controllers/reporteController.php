<?php

namespace App\Http\Controllers;

use App\Models\Trazabilidad;
use Illuminate\Http\Request;

class reporteController extends Controller
{ 
    public function index()
    {
        return Trazabilidad::all();
    }
}
