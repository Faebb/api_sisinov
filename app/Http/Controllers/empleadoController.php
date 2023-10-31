<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;

class empleadoController extends Controller
{
    public function index()
    {
        return Empleado::all();
    }
}
