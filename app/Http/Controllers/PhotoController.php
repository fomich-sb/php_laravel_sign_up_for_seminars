<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Photo;
use App\Models\ProjectUser;
use Illuminate\Support\Facades\Auth;

class PhotoController extends Controller
{

    public function actionUpload()
    {
        $user = Auth::user();
        $elId = intval(request()->get('elId'));
        $type = request()->get('type');
        if($type != "place" && $type != "project" && $type != "user")
            return $this->errorResponseJSON("Ошибочный тип");

        if(    $type == "place"   && !$user->admin 
            || $type == "project" && !$user->admin && App(ProjectUser::class)->where('project_id', $elId)->where('user_id', $user->id)->where('status', '>', 0)->count()==0
            || $type == "user"  && !$user->admin && $elId != $user->id
            ) 
            return $this->errorResponseJSON("Ошибка доступа");

        $response = Utils::loadImage('photos');
        foreach($response['files'] as $file){
            $photo = new Photo();
            if($type == "place")
                $photo->place_id = $elId;
            elseif($type == "project")
                $photo->project_id = $elId;
            elseif($type == "user")
                $photo->user_id = $elId;

            $photo->file = $file['fileName'];
            $photo->origin_file = $file['originFileName'];
            $photo->creator_id = $user->id;
            $photo->save();
        }
        
        return $this->successResponseJSON($response);
    }

    public function actionDelete()
    {
        $user = Auth::user();
        $photoId = intval(request()->get('photoId'));
        $photo = App(Photo::class)->findOrFail($photoId);

        if(!$user->admin && $user->id != $photo->creator_id)
            return $this->errorResponseJSON("Ошибка доступа");

        Utils::deleteImage('photos', $photo->file);
        $photo->delete();
        return $this->successResponseJSON();
    }
}
