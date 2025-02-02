<?php
namespace App\Models;

use App\Facades\Utils;
use App\Models\BaseGameModel;

class MailingTemplate extends BaseGameModel
{
    protected  $table='mailing_templates';
    public $timestamps = false;
    protected $guarded = [];
}