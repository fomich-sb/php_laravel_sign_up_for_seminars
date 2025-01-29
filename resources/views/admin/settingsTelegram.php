<?php
/*$settings = (new \danog\MadelineProto\Settings\AppInfo)
    ->setApiId(config('services.telegram.api_id'))
    ->setApiHash(config('services.telegram.api_hash'));
$MadelineProto = new \danog\MadelineProto\API(storage_path('session.madeline'), $settings);

$MadelineProto->start();
$me = $MadelineProto->getSelf();
$MadelineProto->logger($me);
if (!$me['bot']) {
    $MadelineProto->messages->sendMessage(peer: '@fomichsb', message: "!!!");
}*/

use Illuminate\Support\Facades\Auth;

?>
<div class='projectContentSector'>
    <iframe src='/madeline/?phone=<?=Auth::user()->phone?>&firstName=<?=Auth::user()->name2.' '.Auth::user()->name3?>&lastName=<?=Auth::user()->name1?>' style="width: 100%; height: 100%;">
</div>