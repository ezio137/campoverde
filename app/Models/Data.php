<?php

namespace App;

use App\Services\DateHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data extends Model
{
    use SoftDeletes;

    public $rules = [];
    protected $table = 'datas';
    protected $fillable = ['data'];

    public static function mesesOptions()
    {
        $mesesOptions = Data::lists('data', 'id')->all();
        return array_map(function ($mes) {
            return DateHelper::exibirDataMes($mes);
        }, $mesesOptions);
    }
}
