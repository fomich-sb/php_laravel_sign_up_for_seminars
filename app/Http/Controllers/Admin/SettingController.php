<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SettingController extends AdminController
{


    public function actionIndex()
    {
        $dataRender['blockContent'] = view('/admin/settingList', [
            'setting' => App(Setting::class)->updateCache(),
        ]);

        return $this->renderAdmin($dataRender);
    }

    public function actionTelegram()
    {
        $dataRender['blockContent'] = view('/admin/settingsTelegram', [
          //  'userItems' => $userItems,
        ]);

        return $this->renderAdmin($dataRender);
    }

    public function actionSave()
    {
        $params = App(Setting::class)->params;
        foreach($params as $key=>$param)
            if(request()->get($key))
                App(Setting::class)->set($key, request()->get($key));
        

        return $this->successResponseJSON($response);
    }
}
