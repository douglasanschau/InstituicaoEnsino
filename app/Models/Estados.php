<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Estados extends Model
{
    protected $table = "estados";
    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'nome',
        'sigla',   
    ];
}


?>