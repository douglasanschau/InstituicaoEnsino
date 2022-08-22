<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Enderecos extends Model
{
    protected $table = "enderecos";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'aluno',
        'logradouro',
        'numero',
        'cidade',
        'estado',
        'created_at',
        'updated_at',
    ];
}



?>