<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Cursos;
use App\Models\Matriculas;
use App\Models\Estados;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Yajra\Datatables\Facades\Datatables;

use App\Http\Controllers\AlunosController;
use App\Http\Controllers\CursosController;
use App\Http\Controllers\EnderecosController;
use App\Http\Controllers\MatriculasController;

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

        $info = array(
            'alunos'              => Alunos::select('id', 'nome', 'sobrenome')->orderBy('nome')->orderBy('sobrenome')->groupBy('id')->get(),
            'cursos'              => Cursos::select('id', 'nome')->where('ativo', 1)->orderBy('nome')->groupBy('id')->get(),
            'matriculas_situacao' => DB::table('matriculas_situacao')->select('sigla', 'situacao')->groupBy('id')->get(),
            'estados'             => Estados::select('id', 'sigla')->orderBy('sigla')->get(),
        );

        return view('matriculas', compact('info'));
    }

    public function listaAlunos()
    {
        $alunos = Alunos::select('alunos.id', 'matriculas.id as id_matricula', 'alunos.nome as aluno', 'alunos.email', 'cursos.nome as curso', 'matriculas_situacao.situacao')
                          ->join('matriculas', 'matriculas.aluno', 'alunos.id')
                          ->join('cursos', 'cursos.id', 'matriculas.curso')
                          ->join('matriculas_situacao', 'matriculas_situacao.sigla', 'matriculas.situacao')
                          ->where('cursos.ativo', 1)
                          ->orderBy('alunos.nome')
                          ->orderBy('matriculas.situacao')
                          ->get();

        return datatables($alunos)->toJson();
    }

    public function infoAluno(Request $request)
    {
       $id_aluno = $request->id;
       $id_matricula = $request->id_matricula;

       $aluno = new AlunosController;
       $info = $aluno->getInfo($id_aluno, $id_matricula);

       return json_encode($info);
    }

    public function matriculasInstituicao(Request $request)
    {
        $dados = array (
            'aluno'     => $request->except(['logradouro', 'numero', 'bairro', 'cidade', 'estado', 'curso', 'situacao', 'semestre']),
            'endereco'  => $request->only(['acao','logradouro', 'numero', 'bairro', 'cidade', 'estado']),
            'matricula' => $request->only(['acao','curso', 'situacao', 'semestre'])
        );

        foreach($dados as $tipo => $dado){
            $info[$tipo] = $this->validarMatriculas($dado, $tipo);

            if(isset($info[$tipo]['error'])){
                return json_encode(array('validator_fails' => $info[$tipo]['message']));
            }
        }

        $aluno = new AlunosController;
        $id_aluno = $aluno->verificaCadastro($info['aluno']);
        $aluno->atualizarAluno($info['aluno'], $id_aluno);

        if(is_null($id_aluno)){
            $id_aluno = $aluno->verificaCadastro($info['aluno']);
        }

        $endereco   = new EnderecosController;
        $endereco->atualizarEndereco($info['endereco'], $id_aluno);

        $matricula  = new MatriculasController;
        $matricula->atualizarMatricula($dados['matricula'], $id_aluno);

        return json_encode(array('registro' => 'ok'));
    }

    private function validarMatriculas($dados, $tipo)
    {
        switch($tipo){
            case 'aluno':
                $aluno  = new AlunosController;
                $info   = $aluno->validarDados($dados);
            break;
            case 'endereco':
                $endereco = new EnderecosController;
                $info     = $endereco->validarDados($dados);
            break;
            default:
                $matricula  = new MatriculasController;
                $info       = $matricula->verificarInfoMatriculas($dados);
            break;
        }

        return $info;
    }

}

?>