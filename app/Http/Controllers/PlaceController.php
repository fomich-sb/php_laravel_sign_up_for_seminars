<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Facades\Utils;
use App\Models\Photo;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{

    public function actionGetCardContent()
    {
        $placeId = intval(request()->get('placeId'));
        $place = App(Place::class)->findOrFail($placeId);
        $photoItems = App(Photo::class)->where('place_id', $placeId)->orderBy('num')->orderBy('id')->get();

        $dataRender = [
            'place' => $place,
            'photoItems' => $photoItems,
        ];

        $response['blockContent'] = view('place/placeCard', $dataRender)->render();
        return $this->successResponseJSON($response);
    }
    
}
