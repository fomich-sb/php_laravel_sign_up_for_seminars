<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends BaseGameModel
{
    protected  $table='materials';
    public $timestamps = false;
    protected $guarded = [];
}