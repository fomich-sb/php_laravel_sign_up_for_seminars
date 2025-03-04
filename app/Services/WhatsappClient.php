<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Request as FacadesRequest;

class WhatsappClient
{

    public function sendMessage(&$user, $message, $try=1)
    {        
        $server=config('services.whatsapp.server');
        $sessionId=config('services.whatsapp.session_id');
        $response = Http::post($server.'/client/sendMessage/'.$sessionId, [
            'chatId' => $user->phone . '@c.us',  
            "contentType" => "string",
            "content" => $message
        ]);

        if($response->status()==200){
            if(!$this->checkRegisteredUser($user))
                return ['error' => 'К сожалению, мы не нашли Вас в WhatsApp.'];
            else
                return ['result' => 'Код отправлен в WhatsApp.'];
        }
        else
            return ['error' => 'Ошибка отправки сообщения в WhatsApp.'];   
    }

    public function checkRegisteredUser(&$user)
    {        
        $server=config('services.whatsapp.server');
        $sessionId=config('services.whatsapp.session_id');
        $response = Http::post($server.'/client/isRegisteredUser/'.$sessionId, [
            'number' => $user->phone,  
        ]);
        return json_decode($response->getBody()->getContents())->result;
    }
}