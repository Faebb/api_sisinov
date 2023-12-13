<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class tokenController extends Controller
{
    public function token($token)
    {
        $count = DB::table('token')
            ->where('nToken', $token)
            ->where('fechaVencimiento', '>', Carbon::now())
            ->count();
    
        return $count > 0;
    }
}
