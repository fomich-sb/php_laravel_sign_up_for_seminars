<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Project;
use App\Models\ProjectUser;
use App\Models\User;
use App\Models\UserTag;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function actionSendLoginCode()
    {
        $phone = Utils::isPhone(request()->get('phone', ''));
        if(!$phone)
            return $this->errorResponseJSON("Проверьте номер телефона");

        $messagerType = intval(request()->get('messagerType'));

        $response = App(User::class)->sendLoginCode($phone, $messagerType);
        if($response==null || !isset($response['error']))
            return $this->successResponseJSON($response);
        else
            return $this->errorResponseJSON($response['error']);
    }

    public function actionCheckLoginCode()
    {
        $phone = Utils::isPhone(request()->get('phone', ''));
        if($phone) {
            $userItems = App(User::class)->where('phone', $phone)->get();
            if(count($userItems) > 0) {
                $code = intval(request()->get('code'));
                $user = $userItems[0];
                if($user->login_code === $code){
                    $user->login_code = null;
                    $user->save();
                    App(User::class)->login($user);
                    return $this->successResponseJSON($response);
                }
                else 
                    return $this->errorResponseJSON("Проверьте код");
            }
        }
        return $this->errorResponseJSON("Проверьте номер телефона");
    }

    public function actionGetCardContent()
    {
        $userId = intval(request()->get('userId'));
        $user = App(User::class)->findOrFail($userId);

        $dataRender = [
            'user' => $user,
        ];
        $response['blockContent'] = view('user/userCard', $dataRender)->render();
        return $this->successResponseJSON($response);
    }

    public function actionGetCardEditContent()
    {
        $curUser = Auth::user();
        $userId = intval(request()->get('userId'));

        if($userId){
            if($curUser->id != $userId && !$curUser->admin)
                return $this->errorResponseJSON("Не хватает прав");
            $user = App(User::class)->findOrFail($userId);
        }
        else {
            $user = $curUser;
        }
        $projectUser = null;
        if(request()->get('projectId'))
            $projectUser = App(ProjectUser::class)->where('user_id', $user->id)->where('project_id', intval(request()->get('projectId')))->first();

        $dataRender = [
            'curUser' => $curUser,
            'user' => $user,
            'projectUser' => $projectUser,
        ];
        if($curUser->admin){
            $dataRender['allTags'] = App(UserTag::class)->select('tag')->distinct()->get();
            $dataRender['tags'] = App(UserTag::class)->where('user_id', $user->id)->select('tag')->orderBy('id')->get();
        }

        $response['blockContent'] = view('user/userCardEdit', $dataRender)->render();
        return $this->successResponseJSON($response);
    }

    public function actionSave()
    {
        $curUser = Auth::user();
        $userId = intval(request()->get('userId'));
        if($curUser->id != $userId && !$curUser->admin)
            return $this->errorResponseJSON("Не хватает прав");

        $user = App(User::class)->findOrFail($userId);
        if($curUser->admin){
            $phone = Utils::isPhone(request()->get('phone', ''));
            if(!$phone)
                return $this->errorResponseJSON("Проверьте номер телефона");
            $user->phone = $phone;
        }
        $user->image = trim(request()->get('image'));
        $user->name1 = trim(request()->get('name1'));
        $user->name2 = trim(request()->get('name2'));
        $user->name3 = trim(request()->get('name3'));
        $user->name_en1 = trim(request()->get('nameEn1'));
        $user->name_en2 = trim(request()->get('nameEn2'));
        $user->gender = intval(request()->get('gender'));
        $user->messager_type = intval(request()->get('messagerType'));
        if($curUser->admin && request()->get('autoApprove'))
            $user->auto_approve = intval(request()->get('autoApprove'));
        if($curUser->admin && request()->get('descr'))
            $user->descr = request()->get('descr');
        if($curUser->admin && request()->get('admin') && $curUser->id != $user->id)
            $user->admin = intval(request()->get('admin'));
        if($curUser->admin && request()->get('tamada'))
            $user->tamada = intval(request()->get('tamada'));
            
        $user->save();

        if(request()->get('projectId')){
            $projectUser = App(ProjectUser::class)->where('user_id', $user->id)->where('project_id', intval(request()->get('projectId')))->first();
            if($projectUser){
                $projectUser->participation_type = intval(request()->get('participationType'));
                $projectUser->save();
            }
        }
        
        if($curUser->admin && request()->get('tags')){
            $tags = request()->get('tags');
            foreach($tags as $tag){
                App(UserTag::class)->firstOrCreate(['tag' => $tag, 'user_id' => $user->id]);
            }
            App(UserTag::class)->where('user_id', $user->id)->whereNotIn('tag',  $tags)->delete();
        }

        return $this->successResponseJSON($response);
    }


    public function actionSetImage()
    {
        $curUser = Auth::user();
        $userId = intval(request()->get('userId'));
        if($curUser->id != $userId && !$curUser->admin)
            return $this->errorResponseJSON("Не хватает прав");

        $res = Utils::loadImage('avatars');
        if(count($res['errors'])>0)
            return $this->errorResponseJSON($res['errors'][0]);

        if(count($res['files'])>0)
            $response = ['image' => $res['files'][0]['fileName']];
        return $this->successResponseJSON($response);
    }
    
    public function actionGetLoginForm()
    {
        $response['blockContent'] = view('user/loginForm', [])->render();
        return $this->successResponseJSON($response);
    }
    
    public function actionLogout()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return $this->successResponseJSON();
    }
}
