<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class AdminController extends Controller
{

    public function actionDelete()
    {

        $element_id = intval(request()->get('id'));
        if(!$element_id>0) {
            return $this->errorResponseJSON('Проверьте параметры');
        }

        $elementModel = $this->getModelClass();
        $element = App($elementModel)->findOrFail($element_id);

        if(!$element->delete()) {
            return $this->errorResponseJSON("Ошибка удаления");
        }
        $response['id']=$element_id;

        return $this->successResponseJSON($response);
    }

    public function actionAdd($dopSetItems=[])
    {
        $curUser = Auth::user();
        if(!$curUser->admin)
            return $this->errorResponseJSON("Не хватает прав");

        $response['ids'] = array();

        $cnt = intval(request()->get('cnt', 1));
            
        $elementModelClass = $this->getModelClass();

        $rootField = request()->get('root_field');
        $rootId = intval(request()->get('root_id', 0));

        for($i=0; $i < $cnt; $i++)
        {
            $element = new $elementModelClass();
            
            if($rootField && $rootId > 0)
            {
                $element->$rootField = $rootId;
                foreach($dopSetItems as $prop=>$value)
                    $element->$prop = $value;
            }
            $element->save();

            if($element->id) {
                if(!isset($response['error']))
                    $response['success'] = 1;
                $response['ids'][] = $element->id;
            }
            else {
                return $this->errorResponseJSON("Не удалось добавить элемент", $response);
            }
        }

        return $this->successResponseJSON($response);
    }
}