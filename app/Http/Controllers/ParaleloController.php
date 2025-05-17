<?php

namespace App\Http\Controllers;

use App\Models\Paralelo;
use Illuminate\Http\Request;

class ParaleloController extends Controller
{
    //Transacciones
    //Devolver al usuario todos los paralelos que estan registrados en la bd
        public function index(){
            return Paralelo::all();
        }
        //guardado
public function store(Request $request){
    $request->validate(['nombre'=> 'required| string| max:20| unique:paralelos']);
    }
}