<?php

namespace App\Http\Controllers;

use App\Models\Alunos;
use App\Models\Cursos;
use App\Models\Matriculas;

class InstituicaoController extends Controller
{
    public function index()
    {
       return view('home');
    }

    public function dadosPainel()
    {
        $dados['cursos']     = Cursos::getCursos()->toArray();
        $dados['alunos']     = Alunos::getAlunos()->toArray();
        $dados['matriculas'] = Matriculas::getMatriculas()->groupBy('situacao')->toArray();

        return json_encode($dados);
    }


}

?>