<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $fillable = ['nome', 'user_id', 'categoria_id'];
}
