<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contas; // Import the Contas class

class DashboardController extends Controller
{
    public function index()
    {
        $contas = Contas::all();
        return view('sistema\dashboard', ['contas' => $contas]);
    }

    // Adicione outros métodos conforme necessário
}
