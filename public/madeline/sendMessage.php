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
    $data = json_decode(file_get_contents('php://input'));
    $telegramId = $data->telegramId != "" ? $data->telegramId : null ;
    if(!$telegramId || $telegramId=="")
    {
        try {
            $phone = $data->phone;
            $conts = $MadelineProto->contacts->resolvePhone(phone: $phone );
            if(count($conts['users'])>0)
                $telegramId = $conts['users'][0]['id'];
        } 
        catch(Exception $e){}
    }

    if(!$telegramId)
    {
        $firstName = $data->firstName;
        $lastName = $data->lastName;

        $contact = ['_' => 'inputPhoneContact', 'client_id' => 0, 'phone' => $phone, 'first_name' => $firstName, 'last_name' => $lastName];
        try {
            $import = $MadelineProto->contacts->importContacts(['contacts' => [$contact]]);
            if(count($import['imported'])>0)
                $telegramId = $import['imported'][0]['user_id'];
        } 
        catch(Exception $e){}
    }

    if(!$telegramId){
        echo ' ERROR: NO TELEGRAM ';
        die;
    }

    try {
        $mes = $MadelineProto->messages->sendMessage(peer: $telegramId, message: $data->message);
    } 
    catch(Exception $e){
        echo ' ERROR: SEND MESSAGE ';
        die;
    }
    echo ' SUCCESSFULL ';
    echo ' telegramId='.$telegramId.' ';

}
