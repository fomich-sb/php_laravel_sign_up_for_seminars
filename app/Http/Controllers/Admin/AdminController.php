<?php

namespace App\Http\Controllers\Admin;

use App\Facades\L;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

abstract class AdminController extends Controller
{

   /* public function actionDelete()
    {
        if($this->editOnlyAdmin && !Auth::user()->admin) {
            return $this->errorResponseJSON("Не хватает прав");
        }

        $element_id = intval(request()->get('id'));
        if(!$element_id>0) {
            return $this->errorResponseJSON(L::get('Проверьте параметры'));
        }

        $elementModel = $this->getModelClass();
        $element = App($elementModel)->findOrFail($element_id);

        if(!$element->delete()) {
            return $this->errorResponseJSON("Ошибка удаления");
        }
        $response['id']=$element_id;

        return $this->successResponseJSON($response);
    }
    public function actionSetWithParams($element_id=null, $property=null, $value=null)
    {
        if($this->editOnlyAdmin && !Auth::user()->isAdminGame()) {
            return $this->errorResponseJSON("Не хватает прав");
        }

        if(!isset($element_id))
            $element_id = intval(request()->get('id'));
        if(!isset($property))
            $property = request()->get('prop');
        if(!isset($value))
            $value = request()->get('val');

        if(!$element_id>0)
        {
            return $this->errorResponseJSON(L::get('Проверьте параметры'));
        }

        $elementModel = $this->getModelClass();
        $element = App($elementModel)->findOrFail($element_id);

        $element->$property = $value;
        try{
            if(!$element->save())
                return $this->errorResponseJSON("Ошибка сохранения");
        } catch(Exeption $e){
            return $this->errorResponseJSON("Ошибка сохранения" . $e);
        }
        return $this->successResponseJSON();
    }

    public function actionSet()
    {
        $element_id = intval(request()->get('id'));
        $property = request()->get('prop');
        $value = request()->get('val');

        return $this->actionSetWithParams($element_id, $property, $value);
    }*/

    public function actionAdd($dopSetItems=[])
    {
        $curUser = Auth::user();
        if(!$curUser->admin)
            return $this->errorResponseJSON("Не хватает прав");

        $response['ids'] = array();

        $cnt = 1;
        if(request()->get('cnt'))
            $cnt = intval(request()->get('cnt'));
            
        $elementModelClass = $this->getModelClass();
        for($i=0; $i < $cnt; $i++)
        {
            $element = new $elementModelClass();
            if(request()->get('root_field')
                && strlen(request()->get('root_field'))>0
                && request()->get('root_id')
                && intval(request()->get('root_id'))>0)
                {
                    $rootField = request()->get('root_field');
                    $rootId = request()->get('root_id');
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

   /* public function actionSetSort($startN = 1)
    {
        if($this->editOnlyAdmin && !Auth::user()->isAdminGame())
            return $this->errorResponseJSON("Не хватает прав");

        if(!request()->get('ids')) {
            return $this->errorResponseJSON(L::get('Проверьте параметры'));
        }

        $element_ids = request()->get('ids');
        
        foreach($element_ids as $e_id)
        {
            $element_id = intval($e_id);
            if(!$element_id>0)
            {
                return $this->errorResponseJSON(L::get('Проверьте параметры'));
            }

                $elementModel = $this->getModelClass();
                $element = App($elementModel)->findOrFail($element_id);

                $element->num = $startN;
                $startN++;
                try{
                    if(!$element->save())
                        return $this->errorResponseJSON("Ошибка сохранения");
                } catch(Exeption $e){
                    return $this->errorResponseJSON("Ошибка сохранения" . $e);
                }
        }

        return $this->successResponseJSON();
    }
*/
}