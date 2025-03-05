<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\MailingTemplate;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends AdminController
{


    public function actionIndex()
    {
        $dataRender['blockContent'] = view('/admin/settingList', [
            'setting' => App(Setting::class)->updateCache(),
            'mailingTemplateItems' => App(MailingTemplate::class)->all(),
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

    public function actionServices()
    {
        $dataRender['blockContent'] = view('/admin/settingsServices', [
          //  'userItems' => $userItems,
        ]);

        return $this->renderAdmin($dataRender);
    }

    public function actionSave()
    {
        $fields = request()->get('fields');

        $params = App(Setting::class)->params;
        foreach($params as $key=>$param)
            if(isset($fields[$key]))
                App(Setting::class)->set($key, $fields[$key]);
        

        $mailingTemplatesDeletes = request()->get('mailingTemplatesDeletes');
        foreach($mailingTemplatesDeletes as $mailingTemplateId){
            $item = App(MailingTemplate::class)->find($mailingTemplateId);
            if($item)
                $item->delete();
        }

        $mailingTemplates = request()->get('mailingTemplates');
        foreach($mailingTemplates as $key=>$data)
        {
            $item = App(MailingTemplate::class)->find($key);
            if($item){
                $item->caption = $data['caption'];
                $item->text = $data['text'];
                $item->save();
            }
        }

        return $this->successResponseJSON($response);
    }

    public function actionCheckWhatsApp()
    {
        $response = Utils::sendMessage(Auth::user(), Utils::prepareText('WhatsApp работает!', []));

        if($response==null || !isset($response['error']))
            return $this->successResponseJSON($response);
        else
            return $this->errorResponseJSON($response['error']);
    }
    
}
