<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Project;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function actionIndex()
    {
        return App(ProjectController::class)->actionIndex();
    }
}
