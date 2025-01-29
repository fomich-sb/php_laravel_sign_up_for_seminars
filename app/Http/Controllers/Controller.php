<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    private $defaltAction = 'index';
    private $action;

    public function runAction($action) {
        $this->action = $action ?: $this->defaltAction;
        $method = 'action' . ucfirst($this->action);
        if (method_exists($this, $method)) {
            return $this->$method();
        } else {
            if(config('app.debug', false))
                return $this::class." 404 нет такого экшена ".$method;
            else
                abort(404);
        }
    }

    public function renderAdmin($dataRender) {
        if(!isset($dataRender['bodyClass']))
            $dataRender['bodyClass'] = 'body_admin';

        return view('/layouts/admin', $dataRender);
    }

    public function errorResponseJSON(string $error, &$response = []) {
        $response['success']=0;
        $response['error']=$error;
        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }

    public function successResponseJSON(&$response = []) {
        $response['success']=1;
        return response()->json($response, 200, [], JSON_UNESCAPED_UNICODE | JSON_NUMERIC_CHECK);
    }
}
