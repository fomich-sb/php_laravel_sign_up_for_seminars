<?php

namespace App\Services;

use danog\MadelineProto\API;
use danog\MadelineProto\Settings;
use danog\MadelineProto\Logger;

class TelegramService
{
    protected $madeline;
    protected $initialized = false;

    public function initialize()
    {
        if ($this->initialized) {
            return;
        }

        // Подавляем вывод
        ob_start();
        
        $sessionPath = storage_path('app/madeline/session.madeline');
        
        $settings = new Settings;
        $settings->getAppInfo()->setApiId(config('madelineproto.app_info.api_id'));
        $settings->getAppInfo()->setApiHash(config('madelineproto.app_info.api_hash'));
        
        $this->madeline = new API($sessionPath, $settings);
        $this->initialized = true;
        
        // Очищаем буфер
        ob_end_clean();
    }

    /*
    public function __construct()
    {
        $sessionPath = storage_path('app/madeline/session.madeline');
        
        $settings = new Settings;
        $settings->getAppInfo()->setApiId(config('madelineproto.app_info.api_id'));
        $settings->getAppInfo()->setApiHash(config('madelineproto.app_info.api_hash'));
        
        $this->madeline = new API($sessionPath, $settings);
    }*/

 
    public function start()
    {
        $this->madeline->start();
    }

    /**
     * Отправка сообщения с правильной обработкой peer
     */
    public function sendMessage(&$user, $message)
    {
        $this->initialize(); // Инициализируем только при вызове метода
        
        ob_start(); // Буферизуем вывод метода
        
        try {
            $this->madeline->start();
            
            if (!$user->telegram_id) {
                $user->telegram_id = $this->resolvePhoneToPeer($user);
                $user->save();
            }
            
            $result = $this->madeline->messages->sendMessage([
                'peer' => $user->telegram_id,
                'message' => $message,
                'parse_mode' => 'HTML'
            ]);
            
            ob_end_clean(); // Очищаем буфер
            return $result;
            
        } catch (\Exception $e) {
            ob_end_clean(); // Очищаем буфер при ошибке
            throw new \Exception("Telegram error: " . $e->getMessage());
        }
    }

    /**
     * Преобразование номера телефона в peer
     */
    protected function resolvePhoneToPeer(&$user)
    {
        try {
            // Импортируем контакт
            $imported = $this->madeline->contacts->importContacts([
                'contacts' => [
                    [
                        '_' => 'inputPhoneContact',
                        /*'client_id' => random_int(1, 1000000),*/
                        'phone' => $this->normalizePhone($user->phone),
                        'first_name' => $user->name2 . ' ' . $user->name3,
                        'last_name' => $user->name1
                    ]
                ]
            ]);
            
            if (!empty($imported['users'])) {
                return $imported['users'][0]['id'];
            }
            
            throw new \Exception("Could not import contact with phone: {$user->phone}");
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to resolve phone {$user->phone}: " . $e->getMessage());
        }
    }

    /**
     * Нормализация номера телефона
     */
    protected function normalizePhone($phone)
    {
        // Удаляем все нецифровые символы
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // Если номер начинается с 7 или 8, заменяем на +7
        if (preg_match('/^[78]\d{10}$/', $phone)) {
            $phone = '+7' . substr($phone, 1);
        }
        
        // Если номер без кода страны, добавляем +7 (для России)
        if (preg_match('/^\d{10}$/', $phone)) {
            $phone = '+7' . $phone;
        }
        
        return $phone;
    }

    /**
     * Получение информации о пользователе
     */
 /*   public function getPeerInfo(&$user)
    {
        try {
            $this->start();
            
            if (!$user->telegram_id) {
                $user->telegram_id = $this->resolvePhoneToPeer($user);
                $user->save();
            }

            $info = $this->madeline->getInfo($user->telegram_id);
            return $info;
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to get peer info: " . $e->getMessage());
        }
    }*/

    /**
     * Поиск пользователя по username
     */
 /*  public function resolveUsername($username)
    {
        try {
            $this->start();
            
            // Убедимся, что username начинается с @
            if (!str_starts_with($username, '@')) {
                $username = '@' . $username;
            }
            
            $result = $this->madeline->contacts->resolveUsername($username);
            return $result;
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to resolve username {$username}: " . $e->getMessage());
        }
    }*/

    /**
     * Получение всех контактов
     */
  /*  public function getContacts()
    {
        try {
            $this->start();
            
            $contacts = $this->madeline->contacts->getContacts();
            return $contacts;
            
        } catch (\Exception $e) {
            throw new \Exception("Failed to get contacts: " . $e->getMessage());
        }
    }*/

    public function logout()
    {
        $this->madeline->logout();
    }
}