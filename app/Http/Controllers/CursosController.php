<?php

namespace App\Http\Controllers;

use App\Models\Cursos;

use Illuminate\Support\Facades\Validator;

class CursosController extends controller
{

   public static function atualizaCursos($dados)
   {  
     $acao = isset($dados['acao']) ? $dados['acao'] : null;
    
     switch($acao) {
        case 'cadastrar':
          $retorno = CursosController::cadastraCurso($dados);
        break;
        case 'editar':
          $retorno = CursosController::editaCurso($dados);
        break;
        default:
          $retorno = CursosController::desativaCurso($dados);
        break;
     }
   
     return $retorno;
   }

  
   private function cadastraCurso($dados)
   {
      $curso = new Cursos;
      $curso->nome          = $dados['curso'];
      $curso->carga_horaria = $dados['carga_horaria'];
      $curso->save();

      return array('cadastro' => mensagensSucesso('cadastrar', 'Curso'));
   }

   private function editaCurso($dados)
   {
     $curso = isset($dados['id']) ? Cursos::getCurso($dados['id']) : null;

     if(!is_null($curso)){
        $curso->nome = $dados['curso'];
        $curso->carga_horaria = $dados['carga_horaria'];
        $curso->save();

        return array('editado' =>  mensagensSucesso('editar', 'Curso'));
     }

     return array('validator_fail' => 'Não foi possível editar este curso.');
   }

   private function desativaCurso($dados)
   {
      $curso = isset($dados['id']) ? Cursos::getCurso($dados['id']) : null;

      if(!is_null($curso)){
        $curso->ativo = 0;
        $curso->save();

        return array('desativado' =>  mensagensSucesso('desativar', 'Curso'));
      }

      return array('validator_fail' => 'Não foi possível excluir este curso.');
   }

   public static function validarCurso($dados)
   {
       $curso  = array (
                   'acao' => isset($dados['acao']) ? $dados['acao'] : null,
                   'id'   => isset($dados['id']) ? $dados['id'] : null,
                   'curso' => isset($dados['curso']) ? $dados['curso'] : null,
                   'carga_horaria' => isset($dados['carga_horaria']) ? intval($dados['carga_horaria']) : null,
                 );

       $rules     = CursosController::getValidatorRules();
       $messages  = CursosController::getValidatorMessages();
       $validator = Validator::make($curso, $rules, $messages);

       if($validator->fails()){
            return array('error' => true, 'message' => $validator->errors()->first());
       }

       return array('error' => false, 'curso' => $curso);
   }

   private function getValidatorRules()
   {
       return [
           'curso'          => 'required|max:100',
           'carga_horaria' => 'required|numeric|digits_between:1,5'
       ];
   }

   private function getValidatorMessages()
   {
       return [
           'required' => 'O campo :attribute é obrigatório!',
           'max' => 'O campo :attribute não aceita mais de :max caracteres.',
           'numeric' => 'O campo :attribute aceita somente caracteres numéricos.',
           'digits_between' => 'O campo :attribute não pode ter mais de :max caracteres'
       ];
   }
}


?>