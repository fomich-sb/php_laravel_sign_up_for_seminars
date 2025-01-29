<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SettingsController extends AdminController
{


    public function actionTelegram()
    {
        $dataRender['blockContent'] = view('/admin/settingsTelegram', [
          //  'userItems' => $userItems,
        ]);

        return $this->renderAdmin($dataRender);
    }
   
}
