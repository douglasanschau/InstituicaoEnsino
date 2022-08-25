<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Enderecos;
use App\Models\Matriculas;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AlunosController extends controller 
{
    public function getInfo($id, $id_matricula = null)
    {
        $info = array(
            'aluno'    => Alunos::select("*", DB::raw('DATE_FORMAT(data_nascimento , "%d/%m/%Y") as data_nascimento'))->where('id', $id)->first(),
            'endereco' => Enderecos::where('aluno', $id)->first(),
        );

        if(isset($id_matricula)){
            $info['matricula'] = Matriculas::where('id', $id_matricula)->first();
        }

        return $info;
    }

    public function verificaCadastro($dados = array())
    {
       $cpf   = isset($dados['cpf']) ? $dados['cpf'] : null;
       $email = isset($dados['email']) ? $dados['email'] : null;


        $aluno = Alunos::select('id')
                    ->where([['cpf', '!=', ''], ['email', "!=", ""]])
                    ->where(function($query) use($cpf, $email){
                            $query->where('cpf', $cpf)
                                ->orWhere('email', $email);
                    })
                    ->whereNotNull('cpf')
                    ->first();

       return isset($aluno) ? $aluno->id : null;
    }

    public function atualizarAluno($aluno, $id_aluno)
    {
      $acao = isset($aluno['acao']) ? $aluno['acao'] : 'cadastrar';
      
      if(is_null($id_aluno)){
          return $this->cadastraAluno($aluno);
      } else if($acao == 'editar' && !is_null($id_aluno) || $acao == "cadastrar" && !is_null($id_aluno)){
          $this->editaAluno($aluno, $id_aluno);
      } else {
          $this->excluiAluno($aluno, $id_aluno);
      }

    }

    private function cadastraAluno($dados)
    {
        $aluno = new Alunos;
        $aluno->nome            = $dados['nome'];
        $aluno->sobrenome       = $dados['sobrenome'];
        $aluno->email           = $dados['email'];
        $aluno->data_nascimento = $dados['data_nascimento'];
        $aluno->rg              = $dados['rg'];
        $aluno->cpf             = $dados['cpf'];
        $aluno->nome_mae        = $dados['nome_mae'];
        $aluno->nome_pai        = $dados['nome_pai'];
        $aluno->save();

        return $aluno->id;
    }

    private function editaAluno($dados, $id_aluno)
    {
        $aluno = Alunos::where('id', $id_aluno)->first();

        if(isset($aluno)){
            $aluno->nome            = $dados['nome'];
            $aluno->sobrenome       = $dados['sobrenome'];
            $aluno->email           = $dados['email'];
            $aluno->data_nascimento = $dados['data_nascimento'];
            $aluno->rg              = $dados['rg'];
            $aluno->cpf             = $dados['cpf'];
            $aluno->nome_mae        = $dados['nome_mae'];
            $aluno->nome_pai        = $dados['nome_pai'];
            $aluno->save();
        }
    }

    private function excluiAluno($dados, $id_aluno)
    {
        $aluno = Alunos::where('id', $id_aluno)->first();

        if(isset($aluno)){
            $aluno->delete();
        }
    }

    public function validarDados($dados)
    {
        $aluno = array(
                  'nome' => isset($dados['nome_aluno']) ? $dados['nome_aluno'] : null,
                  'sobrenome' => isset($dados['sobrenome_aluno']) ? $dados['sobrenome_aluno'] : null,
                  'email'     => isset($dados['email_aluno']) ? $dados['email_aluno'] : null,
                  'data_nascimento' => isset($dados['nascimento_aluno']) ? date('Y-m-d', strtotime($dados['nascimento_aluno'])) : null,
                  'rg' => isset($dados['rg_aluno']) ? str_replace('.', '', $dados['rg_aluno']) : null,
                  'cpf' => isset($dados['cpf_aluno']) ? str_replace('.', '', $dados['cpf_aluno']) : null,
                  'nome_mae' => isset($dados['mae_aluno']) ? $dados['mae_aluno'] : null,
                  'nome_pai' => isset($dados['pai_aluno']) ? $dados['pai_aluno'] : null
                );

        $rules     = $this->getValidatorRules();
        $messages  = $this->getValidatorMessages();
        $validator = Validator::make($aluno, $rules, $messages);

        if($validator->fails()){
            return array('error' => true, 'message' => $validator->errors()->first());
        }

        return $aluno;
    }

    private function getValidatorRules()
    {
        return [
            'nome'            => 'required|max:80',
            'sobrenome'       => 'required|max:150',
            'email'           => 'required|email',
            'data_nascimento' => 'required|date',
            'rg'              => 'required|numeric|digits:11',
            'cpf'             => 'required|numeric|digits:11',
            'nome_mae'        => 'required|max:150',
            'nome_pai'        => 'required|max:150'
        ];
    }

    private function getValidatorMessages()
    {
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'max' => 'O campo :attribute não aceita mais de :max caracteres.',
            'numeric' => 'O campo :attribute aceita somente caracteres numéricos.',
            'digits' => 'O campo :attribute deve ter :digits digitos.',
            'date' => 'O campo :attribute deve atender o padrão data, mês e ano.'
        ];
    }
}


?>