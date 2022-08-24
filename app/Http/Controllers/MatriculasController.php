<?php


namespace App\Http\Controllers;

use App\Cursos;
use App\Matriculas;

class MatriculasController extends Controller
{
    public function verificarInfoMatriculas($dados)
    {
      $curso         = isset($dados['curso']) ? Cursos::where('id', $dados['curso'])->first() : null;
      $situacao      = isset($dados['situacao']) ? DB::table('matriculas_situacao')->where('sigla', $dados['situacao'])->first() : null;
      $message_error = is_null($curso) ? 'Curso não encontrado!' : 'Situação não encontrada!';


      if(is_null($curso) || is_null($situacao)){
        return array('error' => true, 'message' => $message_error);
      }
    }

    public function atualizarMatricula($matricula, $id_aluno)
    {
       $acao   = isset($matricula['acao']) ? $matricula['acao'] : 'cadastrar';
       $editar = Matriculas::where([['curso', $matricula['curso']], ['id_aluno', $id_aluno]])->first();

       if(is_null($editar)){
           $this->cadastraMatricula($matricula);
       } else if($acao == "editar" || $acao == "cadastrar" && isset($editar)){
           $this->editaMatricula($matricula, $editar);
       } else {
           $editar->delete();
       }
    }

    private function cadastraMatricula($dados)
    {

    }


}