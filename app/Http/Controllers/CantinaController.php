<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cantina;

class CantinaController extends Controller
{
    public function listarCantinas($id_escola)
    {
        $cantinas = Cantina::where('id_escola',$id_escola)->get();
        return response()->json($cantinas);
    }
}
