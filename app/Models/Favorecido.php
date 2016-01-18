<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Favorecido extends Model
{
    use SoftDeletes;

    public static $rules = [];
    protected $fillable = ['nome'];
}
