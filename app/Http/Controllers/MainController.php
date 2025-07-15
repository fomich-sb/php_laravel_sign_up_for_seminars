<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class MainController extends Controller
{
    public function actionIndex()
    {
        return App(ProjectController::class)->actionIndex();
    }
}
