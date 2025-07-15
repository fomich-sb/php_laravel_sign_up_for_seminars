<?php

namespace App\Models;

use App\Facades\Utils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function login(&$user)
    {
        request()->session()->invalidate();
        Auth::login($user, true);
        request()->session()->regenerate();
    }

    public function sendLoginCode($phone, $messagerType=null)
    {
        $user = App(User::class)->where('phone', $phone)->first();
        $newUser=false;
        if(!$user)
        {
            $user = new User();
            $user->phone = $phone;
            $newUser = true;
        }
        if($messagerType !== null)
            $user->messager_type = $messagerType;

        if(!$user->login_code){
            $user->login_code = random_int(10000,99999);
        }
        $user->save();

        $message = App(Setting::class)->get('authoring_code_text');
        if(strlen(trim($message))>0){
            $res = Utils::sendMessage($user, Utils::prepareText($message, ['user' => $user]));
            if($newUser && isset($res['error'])){
                $user->messager_type = $user->messager_type == 0 ? 1 : 0;
                $user->save();
                return Utils::sendMessage($user, Utils::prepareText($message, ['user' => $user]));
            }
            return $res;
        }
    }
    
    public function getAllUserList() {
        return DB::select('SELECT u.*, pu.projects_1, pu.projects_0
            FROM users u 
                LEFT JOIN (SELECT user_id, SUM(IF(status=1, 1, 0) ) projects_1, SUM(IF(status=0, 1, 0) ) projects_0 FROM project_users GROUP BY user_id) pu ON u.id=pu.user_id
            ORDER BY u.name1', []);
    }

    public function save(array $options = [])
    {
        if($this->isDirty('phone'))
            $this->telegram_id=null;
            
        return parent::save($options);
    }
}
