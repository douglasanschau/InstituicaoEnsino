<?php


namespace App\Http\Controllers;


use App\Models\Alunos;
use App\Models\Cursos;
use App\Models\LogMatriculas;
use App\Models\Matriculas;

use Illuminate\Support\Facades\DB;

class MatriculasController extends Controller
{
    public function verificarInfoMatriculas($dados)
    {
      $curso         = isset($dados['curso']) ? Cursos::where('id', $dados['curso'])->first() : null;
      $situacao      = isset($dados['situacao']) ? DB::table('matriculas_situacao')->where('sigla', $dados['situacao'])->first() : null;
      $message_error = is_null($curso) ? 'Curso não encontrado!' : 'Situação de matricula inválida!';


      if(is_null($curso) || is_null($situacao)){
        return array('error' => true, 'message' => $message_error);
      }
    }

    public function atualizarMatricula($dados, $id_aluno = null)
    {
       $acao      = isset($dados['acao']) ? $dados['acao'] : 'cadastrar';

       switch($acao){
         case 'cadastrar':
          $this->cadastraMatricula($dados, $id_aluno);
         break;
         case 'editar':
           $this->editaMatricula($dados, $id_aluno);
         break;
         default:
          $this->excluiMatricula($dados);
         break;
       }

    }

    private function cadastraMatricula($dados, $id_aluno)
    {
        $matricula = Matriculas::getMatricula($id_aluno, $dados['curso']);

        if(is_null($matricula)){ 
          $matricula = new Matriculas;
          $matricula->curso    = $dados['curso'];
          $matricula->aluno    = $id_aluno;
          $matricula->semestre = $dados['semestre'];
          $matricula->situacao = $dados['situacao'];
          $matricula->save();
        } else {
          $this->editaMatricula($dados, $matricula->aluno);
        }
    }

    private function  editaMatricula($dados, $id_aluno)
    {
      $matricula = Matriculas::getMatricula($id_aluno, $dados['curso']);

      if(is_null($matricula)){
        $this->cadastraMatricula($dados, $id_aluno);
      } else {
        $matricula->curso    = $dados['curso'];
        $matricula->semestre = $dados['semestre'];
        $matricula->situacao = $dados['situacao'];
        $matricula->save();
      }
    }

    private function excluiMatricula($dados)
    {
      $matricula = Matriculas::where('id', $dados['id'])->first();
      if(!is_null($matricula)){
        $this->registraLogMatricula($matricula->aluno, $matricula->curso);
        $matricula->delete();
      }
    }

    private function registraLogMatricula($aluno, $curso)
    {
      $aluno = Alunos::select('nome')->where('id', $aluno)->first();
      $aluno = ucfirst($aluno->nome);
      $curso = Cursos::select('nome')->where('id', $curso)->first();
      $curso = ucfirst($curso->nome);

      $log = new LogMatriculas;
      $log->registro = "{$aluno} teve seu registro no curso de {$curso} excluído.";
      $log->save();
    }


}