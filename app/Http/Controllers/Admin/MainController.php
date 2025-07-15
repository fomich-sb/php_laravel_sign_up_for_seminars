<?php

namespace App\Http\Controllers\Admin;

class MainController extends AdminController
{
    public function actionIndex()
    {
        return App(ProjectController::class)->actionIndexProjectList();
    }
}
