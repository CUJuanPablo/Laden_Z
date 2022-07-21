<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Imeso\Models\Encuestador;
use Modules\Imeso\Models\EncuestadorZona;

class DashboardController extends Controller
{

    public function index()
    {
        return view('inicio');
    }
}