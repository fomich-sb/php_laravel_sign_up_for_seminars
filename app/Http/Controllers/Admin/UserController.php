<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Support\Facades\DB;

class UserController extends AdminController
{
    public function actionIndex()
    {
        if (request()->get('user_id')) {
      /*      $user_id = intval(request()->get('user_id'));
            $user = App(User::class)->findOrFail($user_id);
            return $this->actionIndexUser($user);*/
        } else {
            return $this->actionIndexUserList();
        }
    }

    public function actionIndexUserList($dataRender = [])
    {
        $userItems = App(User::class)->getAllUserList(); 
        $userTagItems = App(UserTag::class)->whereIn('user_id', array_column($userItems, 'id'))->orderBy('tag')->get();
        $dataRender['blockContent'] = view('/admin/userList', [
            'userItems' => $userItems,
            'userTagItems' => $userTagItems->groupBy('user_id'),
            'tagItems' => $userTagItems->unique('tag')->pluck('tag'),
        ]);

        return $this->renderAdmin($dataRender);
    }

    public function getModelClass()
    {
        return User::class;
    }
   
}
