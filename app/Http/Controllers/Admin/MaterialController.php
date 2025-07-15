<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Material;

class MaterialController extends AdminController
{
    public function actionUploadFile()
    {
        $materialId = intval(request()->get('materialId'));

        $res = Utils::loadFiles(public_path(config('app.uploadMaterialFolder')).'/'.$materialId, 1, false);

        if(isset($res['error']) && $res['error']!='')
            return $this->errorResponseJSON($res['error']);
        
        if(count($res['files'])>0)
            $response = ['url' => $res['files'][0]];
        return $this->successResponseJSON($response);
    }

    public function getModelClass()
    {
        return Material::class;
    }
}
