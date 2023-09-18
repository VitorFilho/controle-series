<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
        //$series = Serie::all();
        $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = session('mensagem.sucesso');
        $request->session()->forget('mensagem.sucesso');


        return view('series.index')->with('series', $series)->with('mensagemSucesso, $mensagemSucesso');
    }

    public function create()
    {
        return view(view:'series.create');
    }

    public function store(Request $request)//método usado para criar a série
    {
        $request->validate([//reposta de redirecionamento
            'nome'=>['required', 'min:3']
        ]);
        $serie = Serie::create($request->all());
        //$request->session()->flash('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");

        return to_route(route:'series.index')->with("Série '{$serie->nome}' adicionada com sucesso");
    }

    public function destroy(Serie $serie, Request $request)
    {
        $serie->delete();
        //$request->session()->flash('mensagem.sucesso', "Serie '{ $serie->nome}' removida com sucesso");
        //redirecionando rota
        return to_route('series.index')->with('mensagem.sucesso', "Serie '{$serie->nome}' removida com sucesso.");
    }

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }


    public function update(Serie $series, Request $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
        ->with('mensagem.sucesso', "Serie '{$series->nome}' atualizada com sucesso ");
    }
}


