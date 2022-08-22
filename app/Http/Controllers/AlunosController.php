<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Enderecos;

use Illuminate\Support\Facades\Validator;

class AlunosController extends controller 
{
    public function getInfo($id)
    {
        $info = array(
            'aluno'    => Alunos::where('id', $id)->first(),
            'endereco' => Enderecos::where('aluno', $id)->first(),
        );

        return $info;
    }

    public function validarDados($dados)
    {
        $aluno = array(
                  'nome' => isset($dados['nome_aluno']) ? $dados['nome_aluno'] : null,
                  'sobrenome' => isset($dados['sobrenome_aluno']) ? $dados['sobrenome_aluno'] : null,
                  'email'     => isset($dados['email_aluno']) ? $dados['email_aluno'] : null,
                  'data_nascimento' => isset($dados['nascimento_aluno']) ? date('Y-m-d', strtotime($dados['nascimento_aluno'])) : null,
                  'rg' => isset($dados['rg_aluno']) ? (int) str_replace('.', '', $dados['rg_aluno']) : null,
                  'cpf' => isset($dados['cpf_aluno']) ? (int) str_replace('.', '', $dados['cpf_aluno']) : null,
                  'nome_mae' => isset($dados['mae_aluno']) ? $dados['mae_aluno'] : null,
                  'pai_aluno' => isset($dados['pai_aluno']) ? $dados['pai_aluno'] : null
                );

        $rules     = $this->getValidatorRules();
        $messages  = $this->getValidatorMessages();
        $validator = Validator::make($aluno, $rules, $messages);

        if($validator->fails()){
            return array('error' => true, 'message' => $validator->error()->first());
        }

        return array('error' => false, 'aluno' => $aluno);
    }


    private function getValidatorRules($tipo)
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
        $rules =  [
                    'required' => 'O campo :attribute é obrigatório!',
                    'max' => 'O campo :attribute não aceita mais de :max caracteres.',
                    'numeric' => 'O campo :attribute aceita somente caracteres numéricos.',
                    'digits' => 'O campo :attribute deve ter :value digitos.',
                    'date' => 'O campo :attribute deve atender o padrão data, mês e ano.'
                ];

    }
}


?>