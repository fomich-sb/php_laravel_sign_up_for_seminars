<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TelegramClient
{
    public function sendMessage(&$user, $message, $try=1)
    {        
        $response = Http::post(FacadesRequest::root() . "/madeline/sendMessage.php", 
        [
            'telegramId' => $user->telegram_id,
            'phone' => $user->phone,
            'firstName' => $user->name2 . ' ' . $user->name3,
            'lastName' => $user->name1,
            'message' => $message,
        ]);
        $responseContent = $response->getBody()->getContents();
        if(strpos($responseContent, 'SUCCESS')!==false){
            preg_match('/telegramId=([0-9]+)/', $responseContent, $matches);
            if(count($matches)>1 && $user->telegram_id != $matches[1]){
                $user->telegram_id != $matches[1];
                $user->save();
            }
            return ['result' => 'Код отправлен в Telegram.'];;
        }
        elseif($user->telegram_id && $try==1) {
            $user->telegram_id = null;
            $user->save();
            return $this->sendMessage($user, $message, $try++);
        }
        else
        {
            if(strpos($responseContent, 'ERROR: NO TELEGRAM')>=0)
                return ['error' => 'К сожалению, мы не нашли Вас в Telegram.'];

            return ['error' => 'Ошибка отправки сообщения в Telegram.'];
        }
    }

    public function sendMessages($userItems, $message, $try=1)
    {        
        $data = [];
        foreach($userItems as $user)
        {
            $data[] = [
                'telegramId' => $user->telegram_id,
                'phone' => $user->phone,
                'firstName' => $user->name2 . ' ' . $user->name3,
                'lastName' => $user->name1,
                'message' => $message,
            ];
        }
        $response = Http::post(FacadesRequest::root() . "/madeline/sendMessages.php", $data);
        $responseContent = $response->getBody()->getContents();

     /*   if(strpos($responseContent, 'SUCCESS') >= 0){
            preg_match('/telegramId=([0-9]+)/', $responseContent, $matches);
            if(count($matches)>1 && $user->telegram_id != $matches[1]){
                $user->telegram_id != $matches[1];
                $user->save();
            }
            return null;
        }
        elseif($user->telegram_id && $try==1) {
            $user->telegram_id = null;
            $user->save();
            $this->sendMessage($user, $message, $try++);
        }
        else
        {
            if(strpos($responseContent, 'ERROR: NO TELEGRAM')>=0)
                return ['error' => 'К сожалению, мы не нашли вас в Telegram. Установите Telegram на свой телефон.'];

            return ['error' => 'Ошибка отправки сообщения в Telegram.'];
        }*/
    }
}