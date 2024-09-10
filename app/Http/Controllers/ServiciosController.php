<?php

namespace App\Http\Controllers;


class ServiciosController extends Controller
{

    public function index()
    {
        //Vista inicial de anexo 30 divida en tarjetas
        return view('armonia.servicios.index');
    }
}
