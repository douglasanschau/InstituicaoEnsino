<?php

namespace App\Http\Controllers;

use App\Models\Cursos;
use Illuminate\Support\Facades\Validator;

class CursosController extends controller
{
   public static function cadastraCurso($dados)
   {
      $curso = new Cursos;
      $curso->nome          = $dados['nome'];
      $curso->carga_horaria = $dados['carga_horaria'];
      $curso->save();
   }

   public static function validarCurso($dados)
   {
       $curso  = array (
                   'nome' => $dados['curso'],
                   'carga_horaria' => $dados['carga_horaria']
                 );

       $rules     = $this->getValidatorRules();
       $messages  = $this->getValidatorMessages();
       $validator = Validator::make($curso, $rules, $messages);

       if($validator->fails()){
            return array('error' => true, 'message' => $validator->getMessages());
       }

       return array('error' => false, 'dados' => $dados);
   }

   private function getValidatorRules()
   {
       return [
           'nome'          => 'required|max:100',
           'carga_horaria' => 'required|max:5|numeric'
       ];
   }

   private function getValidatorMessages()
   {
       return [
           'required' => 'O campo :attribute é obrigatório!',
           'max' => 'O campo :attribute não aceita mais de :5 caracteres.',
           'numeric' => 'O campo :attribute aceita somente caracteres numéricos.'
       ];
   }
}


?>