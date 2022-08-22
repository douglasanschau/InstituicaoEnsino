<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Alunos extends Model
{
    protected $table = "alunos";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'sobrenome',
        'data_nascimento',
        'email',
        'rg',
        'cpf',
        'nome_mae',
        'nome_pai',
        'created_at',
        'updated_at',
    ];

    public static function getAlunos()
    {
        return self::orderBy('nome')
                    ->orderBy('sobrenome')
                    ->get();
    }
}



?>