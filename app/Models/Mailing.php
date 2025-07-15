<?php
namespace App\Models;

use App\Facades\Utils;
use App\Models\BaseGameModel;

class Mailing extends BaseGameModel
{
    protected  $table='mailings';
    public $timestamps = false;
    protected $guarded = [];

    public function generateContent(&$project, &$user, $text) {
        $text = Utils::prepareText($text, ['project' => $project, 'user' => $user, ]);
        return $text;
    }

    public function send(&$project, &$user, $text) {
        $text = Utils::prepareText($text, ['project' => $project, 'user' => $user, ]);
        Utils::sendMessage($user, $text);
        return;
    }
}