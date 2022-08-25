<?php


namespace App\Http\Controllers;

use App\Models\Enderecos;

use Illuminate\Support\Facades\Validator;

class EnderecosController extends Controller
{

   public function atualizarEndereco($endereco, $id_aluno)
   {
       $acao = isset($endereco['acao']) ? $endereco['acao'] : 'cadastrar';

       switch($acao){
           case 'cadastrar':
            $this->cadastraEndereco($endereco, $id_aluno);
           break;
           case 'editar': 
            $this->editaEndereco($endereco, $id_aluno);
           break;
           case 'excluir':
            $this->excluiEndereco($endereco, $id_aluno);
           break; 
       }
   }

   private function cadastraEndereco($dados, $id_aluno)
   {
       $endereco = Enderecos::where('aluno', $id_aluno)->first();

       if(isset($endereco)){
         $this->editaEndereco($dados, $id_aluno);
       } else {
          $endereco = new Enderecos;
          $endereco->aluno      = $id_aluno;
          $endereco->logradouro = $dados['logradouro'];
          $endereco->numero     = $dados['numero'];
          $endereco->bairro     = $dados['bairro'];
          $endereco->cidade     = $dados['cidade'];
          $endereco->estado     = $dados['estado'];
          $endereco->save();
       }
   }

   private function editaEndereco($dados, $id_aluno)
   {
       $endereco = Enderecos::where('aluno', $id_aluno)->first();

       if(isset($endereco)){
          $endereco->logradouro = $dados['logradouro'];
          $endereco->numero     = $dados['numero'];
          $endereco->bairro     = $dados['bairro'];
          $endereco->cidade     = $dados['cidade'];
          $endereco->estado     = $dados['estado'];
          $endereco->save();
       } else {
         $this->cadastraEndereco($dados, $id_aluno);
       }

   }

   private function excluiEndereco($dados, $id_aluno)
   {
      $endereco = Enderecos::where('id', $dados['id'])->first();

      if(isset($endereco)){
        $endereco->delete();
      }
   }

   public function validarDados($dados)
   {
      $endereco = array (
                    'logradouro' => isset($dados['logradouro']) ? $dados['logradouro'] : null,
                    'numero' => isset($dados['numero']) ? intval($dados['numero']) : null,
                    'bairro' => isset($dados['bairro']) ? $dados['bairro'] : null,
                    'cidade' => isset($dados['cidade']) ? $dados['cidade'] : null,
                    'estado' => isset($dados['estado']) ? $dados['estado'] : null
                  );

      $rules     = $this->getValidatorRules();
      $messages  = $this->getValidatorMessages();
      $validator = Validator::make($endereco, $rules, $messages);

      if($validator->fails()){
        return array('error' => true, 'message' => $validator->errors()->first());
      }

      return $endereco;
   }

   private function getValidatorRules()
   {
        return [
            'logradouro'      => 'required|max:100',
            'numero'          => 'required|numeric|digits_between:1,11',
            'bairro'          => 'required|max:100',
            'cidade'          => 'required|max:100',
            'estado'          => 'required|max:2'
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