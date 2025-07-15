<?php

namespace App\Http\Controllers;

use App\Facades\Utils;
use Illuminate\Support\Facades\Auth;

class RouteController extends Controller
{
    public function activitiesAction($controllerName = 'main', $action = 'index')
    {
        $controllerClass = Utils::getActivitiesControllerClass(ucfirst($controllerName));
        $controller = new $controllerClass();

        return $controller->runAction($action);
    }

    public function adminAction($controllerName = 'main', $action = 'index')
    {
        if (!Auth::user() || !Auth::user()->admin) {
            return redirect()->route('root');
        } else {
            $controllerClass = Utils::getAdminControllerClass(ucfirst($controllerName));
            $controller = new $controllerClass();
            return $controller->runAction($action);
        }
    }
    public function action($controllerName = 'main', $action = 'index')
    {
        if ($controllerName == 'admin')
            return $this->adminAction($action);

        $controllerClass = Utils::getControllerClass(ucfirst($controllerName));
        $controller = new $controllerClass();

        return $controller->runAction($action);
    }
    public function actionPost($controllerName = null, $action = null)
    {
        if(!$action)
            return $this->action(null, $controllerName);
        return $this->action($controllerName, $action );
    }
}
