<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cursos extends Model
{
    protected $table = "cursos";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'carga_horaria',
        'ativo',
        'created_at',
        'updated_at',
    ];

    public static function getCursos()
    {
        return self::where('ativo', 1)
                    ->orderBy('nome')
                    ->get();
    }
}



?>