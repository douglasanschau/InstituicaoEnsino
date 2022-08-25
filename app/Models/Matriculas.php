<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Matriculas extends Model
{
    protected $table = "matriculas";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'curso',
        'matricula',
        'semestre',
        'situacao',
        'created_at',
        'updated_at',
    ];

    public static function getMatriculas()
    {
        return self::select('matriculas.*', 'matriculas_situacao.situacao')
                    ->join('matriculas_situacao', 'matriculas_situacao.sigla', 'matriculas.situacao')
                    ->get();
    }

    public static function getAlunosCursos()
    {
        return self::select('matriculas.id', 'cursos.nome as curso')
                  ->join('alunos', 'alunos.id', 'matriculas.aluno')
                  ->join('cursos', 'cursos.id', 'matriculas.curso')
                  ->get();
    }

    public static function getMatricula($id_aluno, $curso)
    {
        return self::where('aluno', $id_aluno)
                   ->where('curso', $curso)
                   ->first();
    }

}



?>