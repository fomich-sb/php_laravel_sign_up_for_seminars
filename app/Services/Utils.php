<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use Intervention\Image\ImageManager;

class Utils
{
    function getModelClass($modelName)
    {
        $tmpModelClassPath = 'App\\Models\\'.$modelName;
        if(class_exists($tmpModelClassPath))
            return $tmpModelClassPath;

        abort(404, 'Не найдена модель для '.$modelName);
    }

    function getControllerClass($controllerName)
    {
        $tmpControllerClassPath = 'App\\Http\\Controllers\\'.ucfirst($controllerName).'Controller';
        if(class_exists($tmpControllerClassPath))
            return $tmpControllerClassPath;

        abort(404, 'Не найден контроллер '.ucfirst($controllerName).'Controller');
    }
    
    function getAdminControllerClass($controllerName)
    {
        $tmpControllerClassPath = 'App\\Http\\Controllers\\Admin\\'.ucfirst($controllerName).'Controller';
        if(class_exists($tmpControllerClassPath))
            return $tmpControllerClassPath;

        $tmpControllerClassPath = 'App\\Http\\Controllers\\Game\\Admin\\'.ucfirst($controllerName).'Controller';
        if(class_exists($tmpControllerClassPath))
            return $tmpControllerClassPath;

        abort(404, 'Не найден контроллер '.ucfirst($controllerName).'Controller');
    }

    function generateCode($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ0123456789";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    function generateString($length=6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPRQSTUVWXYZ";
        $code = "";
        $clen = strlen($chars) - 1;
        while (strlen($code) < $length) {
                $code .= $chars[mt_rand(0,$clen)];
        }
        return $code;
    }

    function isPhone($phone)  
    {
        $phone2 = preg_replace("/[^0-9]/", '', $phone);
        if (substr($phone2, 0, 1) == "9" && strlen($phone2) == 10)
            $phone2 = '7'.$phone2;
        if (substr($phone2, 0, 1) == "7" && strlen($phone2) != 11 || strlen($phone2) < 8) 
            return false;
        return $phone2;
    }

    function deleteDirectory($path) {
        if (is_dir($path) === true)
        {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file)
                $this->deleteDirectory(realpath($path) . '/' . $file);
            return rmdir($path);
        }
        else if (is_file($path) === true)
            return unlink($path);

        return false;
    }
    
    function loadFiles($targetFolder, $fileReplace = 0, $multiple = true, $uniqueId = false, $allowFileExtension = null) {
        $blacklist = array(".php", ".phtml", ".php3", ".php4", ".html", ".htm", ".exe", ".bat"); 

        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }

        $files = request()->files;
        if(count($files)<1)
            return ['error' => 'Нет файла'];
        
        if(count($files)>1 && !$multiple)
            return ['error' => 'Требуется только 1 файл'];

        $res = [
                'files' => [],
                'error' => '',
                'warning' => '',
                'done' => '',
        ];
        foreach ($files as $file)
        {
            // Загружаем по одному файлу
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $errorCode = $file->getError();
            $newFileName = ($uniqueId ? uniqid() : '') . htmlspecialchars($fileName);

            if ($errorCode !== UPLOAD_ERR_OK || !$file->isValid()) {
                // Массив с названиями ошибок
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE   => 'Размер файла слишком большой', //'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                    UPLOAD_ERR_FORM_SIZE  => 'Размер файла слишком большой', //'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
            /*      UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                    UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                    UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                    UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',*/
                ];
                // Зададим неизвестную ошибку
                $message = 'При загрузке файла произошла ошибка' . '. ';
                // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
                $message .= isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $errorCode;
                // Выведем название ошибки
                
                $res['error'] .= $newFileName . ' ' . $message. '. <br>';
                return $res;
            } 
            // Проверим нужные параметры
           /* if ($fileSize > config('uploadMaxFileSize')) {
                $res['error'] .= $newFileName . ' ' . 'Размер файла слишком большой. <br>';
                return $res;
            }*/
            $fileExtension = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if(in_array($fileExtension, $blacklist)) {	
                $res['error'] .= $newFileName . ' ' . 'Не допускаются файлы с расширением' .' ' .$fileExtension. '. <br>';
                return $res;
            }

            if($allowFileExtension)
                if(!in_array($fileExtension, $allowFileExtension)) {
                    $res['error'] .= $newFileName . ' ' . 'Не допускаются файлы с расширением' .' ' .$fileExtension. '. <br>';
                    return $res;
                }
            $file_exists = file_exists($targetFolder . DIRECTORY_SEPARATOR . $newFileName);
            if ($file_exists && !$fileReplace) {
                $res['error'] .= $newFileName . ' ' . 'Файл существует и не был обновлен' .'. <br>';
            }
            elseif (!$file->move($targetFolder, $newFileName)) {
                $res['error'] .= $newFileName . ' ' . 'При записи файла на диск произошла ошибка. <br>';
                return $res;
            }
            elseif($file_exists){
                $res['warning'] .= $newFileName . ' ' . 'Файл обновлен' .'. <br>';
            }
            else
                $res['done'] .= $newFileName . ' ' . 'Файл загружен' .'. <br>';
            $res['files'][] = $newFileName;

        }
        return $res;
    }

    function loadImage($type, $maxThumbSize = 300, $maxSize = 2048) {
        $targetFolder = public_path(config('app.uploadImageFolder')) . '/' . $type;
        $allowFileExtension = array('jpg', 'png', 'jpeg', 'gif', 'bmp');

        if (!file_exists($targetFolder)) {
            mkdir($targetFolder, 0777, true);
        }
        if (!file_exists($targetFolder.'/thumbs')) {
            mkdir($targetFolder.'/thumbs', 0777, true);
        }

        $files = request()->files;

        $res = ['files' => [], 'errors' => []];
        foreach ($files as $file)
        {
            // Загружаем по одному файлу
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $errorCode = $file->getError();
            if ($errorCode !== UPLOAD_ERR_OK || !$file->isValid()) {
                // Массив с названиями ошибок
                $errorMessages = [
                    UPLOAD_ERR_INI_SIZE   => 'Размер файла слишком большой', //'Размер файла превысил значение upload_max_filesize в конфигурации PHP.',
                    UPLOAD_ERR_FORM_SIZE  => 'Размер файла слишком большой', //'Размер загружаемого файла превысил значение MAX_FILE_SIZE в HTML-форме.',
            /*      UPLOAD_ERR_PARTIAL    => 'Загружаемый файл был получен только частично.',
                    UPLOAD_ERR_NO_FILE    => 'Файл не был загружен.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Отсутствует временная папка.',
                    UPLOAD_ERR_CANT_WRITE => 'Не удалось записать файл на диск.',
                    UPLOAD_ERR_EXTENSION  => 'PHP-расширение остановило загрузку файла.',*/
                ];
                // Зададим неизвестную ошибку
                $message = 'При загрузке файла произошла ошибка' . '. ';
                // Если в массиве нет кода ошибки, скажем, что ошибка неизвестна
                $message .= isset($errorMessages[$errorCode]) ? $errorMessages[$errorCode] : $errorCode;
                // Выведем название ошибки
                
                $res['errors'][] = $fileName.': '.$message;
                continue;
            } 

            // Проверим нужные параметры
       /*     if ($fileSize > config('uploadMaxFileSize')) {
                return ['error' => 'Размер файла слишком большой.'];
            }*/
            if($allowFileExtension)
            {
                $fileExtension = mb_strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if(!in_array($fileExtension, $allowFileExtension)) {
                    $res['errors'][] = $fileName.': '.'Не допускаются файлы с расширением' .' ' .$fileExtension;
                    continue;
                }
            }
            $manager = new ImageManager(
                new \Intervention\Image\Drivers\Gd\Driver()
            );

            $newFileName = \Illuminate\Support\Str::uuid().'.jpg';
            // open an image file
            $img = $manager->read($file);
          //  $img = \Intervention\Image::make($file);
            $img->scaleDown($maxSize, $maxSize, function($constraint) {
                $constraint->aspectRatio();
            })->save($targetFolder.'/'.$newFileName);

            $img->scaleDown($maxThumbSize, $maxThumbSize, function($constraint) {
                $constraint->aspectRatio();
            })->save($targetFolder.'/thumbs/'.$newFileName);

            $res['files'][] = ['originFileName' => $fileName, 'fileName' => $newFileName];
        }
        return $res;
    }
    function deleteImage($type, $fileName) {
        $targetFolder = public_path(config('app.uploadImageFolder')) . '/' . $type;
        if (file_exists($targetFolder.'/'.$fileName)) 
            unlink($targetFolder.'/'.$fileName);
        if (file_exists($targetFolder.'/thumbs/'.$fileName)) 
            unlink($targetFolder.'/thumbs/'.$fileName);
         
    }

    function sendMessage(&$user, $message) {
        if($user->messager_type==0)
            return App(TelegramClient::class)->sendMessage($user, $message);
        elseif($user->messager_type==1)
            return App(WhatsappClient::class)->sendMessage($user, $message);
    }

    function prepareText($str, $objs) {
        $pattern = '/{{[^}]*}}/';
        preg_match_all($pattern, $str, $matches);
        $tables=['user', 'project', 'certificate'];
        foreach($matches[0] as $var){
            $prop = trim(str_replace('}}', '', str_replace('{{', '', $var)));
            if(in_array($prop, ['user_password']))
                continue;
    
            if($prop == 'certificate_qrcode'){    
                if(isset($objs['certificate']->id))
                    $url = config('app.certificateUrl') . '/certificate?uuid=' . $objs['certificate']->url;
                else
                    $url = config('app.certificateUrl') . '/certificate';

                $qrcodeOptions = new \chillerlan\QRCode\QROptions([
                    'imageTransparent'    => false,
                ]);
                
                $str = str_replace($var, "<img style='width:100%; height:100%;' src='" . (new \chillerlan\QRCode\QRCode($qrcodeOptions))->render($url) . "' />", $str);
            }
            elseif($prop == 'root_url'){    
                $str = str_replace($var, Request::root(), $str);
            }
            else {
                foreach($tables as $table)
                    if(str_contains($prop, $table.'_')){
                        $prop2 = substr($prop, strlen($table)+1);
                        if(isset($objs[$table]->$prop2)){
                            $str = str_replace($var, $objs[$table]->$prop2, $str);
                            continue;
                        }
                    }
                $str = str_replace($var, '', $str);
            }
        }
        return $str;
    }
}