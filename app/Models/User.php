<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Facades\Utils;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function login(&$user)
    {
        request()->session()->invalidate();
        Auth::login($user, true);
        request()->session()->regenerate();
       /* request()->session()->regenerateToken();*/
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

     /*   if (!file_exists(public_path('madeline/madeline.php'))) {
            copy('https://phar.madelineproto.xyz/madeline.php', public_path('madeline/madeline.php'));
        }*/
    //    include public_path('madeline/madeline.php');

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
    
    public function save(array $options = [])
    {
        if($this->isDirty('phone'))
            $this->telegram_id=null;
            
        return parent::save($options);
    }
}
