<?php

namespace App\Http\Controllers;

use App\Http\Requests\SeriesFormRequest;
use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request)
    {
         $series = Serie::all();
        // $series = Serie::query()->orderBy('nome')->get();
        $mensagemSucesso = session('mensagem.sucesso');
        //$request->session()->forget('mensagem.sucesso');


        return view('series.index')->with('series', $series)
        ->with('mensagemSucesso, $mensagemSucesso');
    }

    public function create()
    {
        return view(view:'series.create');
    }

    public function store(SeriesFormRequest $request)//método usado para criar a série
    {
        //dd($request->all());
        $serie = Serie::create($request->all());

        for($i = 1; $i <= $request->seasonsQtd; $i++){
            $season = $serie->season()->create([
                 'number' => $i,
            ]);
            for($j = 1; $j <= $request->episodesPerSeason; $j++){
                $season->episodes()->create([
                    'number' => $j
                ]);
            }

        }

        return to_route(route:'series.index')
        ->with("Série '{$serie->nome}' adicionada com sucesso");
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

       // dd($series->temporadas());
        return view('series.edit')->with('serie', $series);
    }


    public function update(Serie $series, SeriesFormRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
        ->with('mensagem.sucesso', "Serie '{$series->nome}' atualizada com sucesso ");
    }
}


