<?php
namespace App\Models;

use App\Models\BaseGameModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Place extends BaseGameModel
{
    protected  $table='places';
    public $timestamps = false;
    protected $guarded = [];
    use SoftDeletes;

}