<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Produto;

class Movimento extends Model
{
    protected $fillable = [
        'produto_id',
        'quantidade',
        'tipo',
    ];

    public function Produto(){
        return $this->belongsTo(Produto::class, 'produto_id');
    }

}
