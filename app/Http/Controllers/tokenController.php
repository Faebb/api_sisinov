<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tokenController extends Controller
{
    public function token($token)
{
    $resuls = DB::table('token')
        ->where('nToken', $token)
        ->where('fechaVencimiento', '>', now())
        ->count() > 0;

    return $resuls;
}
}
