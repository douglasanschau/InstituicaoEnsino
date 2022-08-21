<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Cursos;
use App\Models\Matriculas;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

use App\Http\Controllers\CursosController;

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
                             'cursos' => Cursos::where('ativo', 1)->count(),
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
                                  ->where('ativo', 1)
                                  ->orderBy('nome')
                                  ->get();

        return datatables($cursos)->toJson();
    }

    public function cursosInstituicao(Request $request)
    {
        $dados  = $request->all();
        $curso  = new CursosController;
        $valida = isset($dados['acao']) && $dados['acao'] != 'desativar' ? $curso->validarCurso($dados) : null;

        if(isset($valida['error']) && $valida['error']){
            return json_encode(array('validator_fail' => $valida['message']));
        }   

        $retorno = isset($valida['cursos']) ? $curso->atualizaCursos($valida['cursos']) : $curso->atualizaCursos($dados);
    
        return json_encode($retorno);
    }

    public function matriculas()
    {
        return view('matriculas');
    }

    public function listaAlunos()
    {
        $alunos = Alunos::select('alunos.id', 'alunos.nome as aluno', 'alunos.email', 'cursos.nome as curso', 'matriculas_situacao.situacao')
                          ->join('matriculas', 'matriculas.aluno', 'alunos.id')
                          ->join('cursos', 'cursos.id', 'matriculas.curso')
                          ->join('matriculas_situacao', 'matriculas_situacao.sigla', 'matriculas.situacao')
                          ->where('cursos.ativo', 1)
                          ->orderBy('alunos.nome')
                          ->orderBy('matriculas.situacao')
                          ->get();

        return datatables($alunos)->toJson();
    }


}

?>