<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kabkota;
use Illuminate\Support\Facades\DB;

class KabkotaController extends Controller
{
    public function index()
    {
        $kabkotas = Kabkota::all();
        return view('kabkota', ['kabkotas' => $kabkotas]);
    }
    public function penduduk(){
        $kabkotas = DB::table('kabkotas')
        ->join('kabkota_polygons', 'kabkotas.id', '=', 'kabkota_polygons.kabkota_id')
        ->select('kabkotas.id', 'kabkotas.name', 'kabkotas.kepadatan_penduduk', 'kabkota_polygons.type_polygon', 'kabkota_polygons.polygon')->get();
        
        return view('penduduk', ['kabkotas' => $kabkotas]);
    }

    public function sekolah(){
        $kabkotas = DB::table('kabkotas')
        ->join('kabkota_polygons', 'kabkotas.id', '=', 'kabkota_polygons.kabkota_id')
        ->select('kabkotas.id', 'kabkotas.name', 'kabkotas.sekolah_sma', 'kabkota_polygons.type_polygon', 'kabkota_polygons.polygon')->get();
        
        return view('sekolah', ['kabkotas' => $kabkotas]);
    }
    
    public function rumah_sakit(){
        $kabkotas = DB::table('kabkotas')
        ->join('kabkota_polygons', 'kabkotas.id', '=', 'kabkota_polygons.kabkota_id')
        ->select('kabkotas.id', 'kabkotas.name', 'kabkotas.rumah_sakit', 'kabkota_polygons.type_polygon', 'kabkota_polygons.polygon')->get();
        
        return view('rumah_sakit', ['kabkotas' => $kabkotas]);
    }

    public function data(){
        $kabkotas = $kabkotas = Kabkota::all();
        return view('data', ['kabkotas' => $kabkotas]);
    }
}

