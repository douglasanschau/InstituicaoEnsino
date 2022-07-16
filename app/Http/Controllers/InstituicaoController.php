<?php

namespace App\Http\Controllers;

use App\Models\Cursos;


class InstituicaoController extends Controller
{
    public function index()
    {
       $infos = $this->dadosPainel();
       dd($dados);
    }

    private function dadosPainel()
    {
        $dados['cursos'] = Cursos::getCursos()->toArray();
        //$dados['alunos'] = Alunos::getAlunos()->toArray();
        return $dados;
    }


}

?>