<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Project;
use App\Models\User;

class UserController extends Controller
{
    public function getSendLoginCode()
    {
        $phone = Utils::isPhone(request()->get('phone', ''));
        if(!$phone)
            $this->errorResponseJSON("Проверьте номер телефона");

        $userItems = App(User::class)->where('phone', $phone)->get();
        if(count($userItems) == 0)
            $this->errorResponseJSON("Проверьте номер телефона");

        $user = $userItems[0];
        if(!$user->login_code){
            $user->login_code = random_int(10000,99999);
            $user->save();
        }

        return $this->successResponseJSON($response);
    }
    
}
