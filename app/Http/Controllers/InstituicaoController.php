<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Cursos;
use App\Models\Matriculas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

use App\Controllers\CursosController;

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

    public function novoCurso(Request $request)
    {
        $dados  = $request->all();
        $curso  = new CursosController;
        $valida = $curso->validarCurso($dados);

        if($valida['error']){
            return json_encode(array('validator_fail' => $valida['message']));
        }

        $curso->cadastraCurso($valida['dados']);

        return json_encode(array('cadastro' => 'ok'));
    }

}

?>