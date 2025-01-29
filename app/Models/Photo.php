<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends BaseGameModel
{
    protected  $table='photos';
    public $timestamps = false;
    protected $guarded = [];
}