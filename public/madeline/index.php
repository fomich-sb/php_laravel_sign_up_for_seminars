<?php
error_reporting(E_ERROR | E_PARSE);
// PHP 8.2+ is required.

if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
include 'madeline.php';

$MadelineProto = new \danog\MadelineProto\API('session.madeline');
$MadelineProto->start();

$me = $MadelineProto->getSelf();
//$MadelineProto->logger($me);

if (!$me['bot']) {
  /*  $contact = ['_' => 'inputPhoneContact', 'client_id' => 0, 'phone' => '+79522101637', 'first_name' => 'ddd', 'last_name' => 'eee'];
    $import = $MadelineProto->contacts->importContacts(['contacts' => [$contact]]);
    $MadelineProto->messages->sendMessage(peer: $import['imported'][0]['user_id'], message: "Все хорошо");*/
    $phone = $_GET['phone']; // '+79522101637';
    $firstName = $_GET['firstName']; // 'Михаил';
    $lastName = $_GET['lastName']; // 'Фомин';
 //   $phone = '+79522101637';

    $telegramId = null;
    try {
        $conts = $MadelineProto->contacts->resolvePhone(phone: $phone );
        if(count($conts['users'])>0)
            $telegramId = $conts['users'][0]['id'];
    } 
    catch(Exception $e){}

    if(!$telegramId)
    {
        $contact = ['_' => 'inputPhoneContact', 'client_id' => 0, 'phone' => $phone, 'first_name' => $firstName, 'last_name' => $lastName];
        $import = $MadelineProto->contacts->importContacts(['contacts' => [$contact]]);
        if(count($import['imported'])>0)
            $telegramId = $import['imported'][0]['user_id'];
    }

    if(!$telegramId){
        echo ' ERROR: NO TELEGRAM ';
        die;
    }

    $mes = $MadelineProto->messages->sendMessage(peer: $telegramId, message: "С сервисом все хорошо!");
    var_dump($mes);
   // $MadelineProto->messages->sendMessage(peer: '@fomichsb', message: "С сервисом все хорошо!");

  /*  $MadelineProto->channels->joinChannel(channel: '@MadelineProto');

    try {
        $MadelineProto->messages->importChatInvite(hash: 'https://t.me/+Por5orOjwgccnt2w');
    } catch (\danog\MadelineProto\RPCErrorException $e) {
        $MadelineProto->logger($e);
    }*/
}
$MadelineProto->echo('OK, done!');

