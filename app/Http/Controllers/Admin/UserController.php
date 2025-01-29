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
        $userItems = DB::select('SELECT u.*, pu.projects_1, pu.projects_0
            FROM users u 
                LEFT JOIN (SELECT user_id, SUM(IF(status=1, 1, 0) ) projects_1, SUM(IF(status=0, 1, 0) ) projects_0 FROM project_users GROUP BY user_id) pu ON u.id=pu.user_id
            ORDER BY u.name1', []);
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
