<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Cursos;
use App\Models\Matriculas;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Facades\Datatables;

class InstituicaoController extends Controller
{
    public function index()
    {
       return view('home');
    }

    public function dadosPainel()
    {      
        $dados['cursos']           = Matriculas::getAlunosCursos()->groupBy('curso')->toArray();
        $dados['matriculas']       = Matriculas::getMatriculas()->groupBy('situacao')->toArray();
        $dados['semestres']        = Matriculas::getMatriculas()->groupBy('semestre')->toArray();

        $dados['cards']  =  array(
                             'alunos' => Matriculas::where('situacao', 'A')->count(),
                             'cursos' => Cursos::count(),
                            );

        return json_encode($dados);
    }

    public function cursos()
    {
       return view('cursos');
    }

    public function listaCursos()
    {
        $cursos = Cursos::select('id', 'nome as curso', 'carga_horaria', 
                                  DB::raw('DATE_FORMAT(created_at, "%d/%m/%Y") as data_cadastro'))
                                  ->orderBy('nome')->get();

        return datatables($cursos)->toJson();
    }


}

?>