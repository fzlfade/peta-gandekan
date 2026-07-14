<?php

namespace App\Http\Controllers;

use App\Models\Warga;

class PetaController extends Controller
{
    public function index()
    {
        $residents = Warga::all();

        return view('peta', compact('residents'));
    }
}
