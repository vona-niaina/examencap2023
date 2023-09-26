<?php

namespace App\Http\Controllers\clientContro;

use App\Models\Examen;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
    public function index()
    {
        $examens= Examen::orderBy('created_at', 'desc')->get();

        return view('cliAcc',[
            'examens' => $examens,
            //dd($examens)
            //'ciscoForm' => new Cisco()
        ]);
    }//end func
}
