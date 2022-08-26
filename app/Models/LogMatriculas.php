<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogMatriculas extends Model
{
    protected $table = "log_matriculas";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'registro',
        'created_at',
        'updated_at'   
    ];
}


?>