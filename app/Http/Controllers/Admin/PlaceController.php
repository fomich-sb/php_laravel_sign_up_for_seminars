<?php

namespace App\Http\Controllers\Admin;

use App\Models\Photo;
use App\Models\Place;

class PlaceController extends AdminController
{

    public function actionIndex()
    {
        if (request()->get('place_id')) {
       /*     $place_id = intval(request()->get('place_id'));
            $place = App(Place::class)->findOrFail($place_id);
            return $this->actionIndexPlace($place);*/
        } else {
            return $this->actionIndexPlaceList();
        }
    }

    public function actionIndexPlaceList($dataRender = [])
    {
        $placeItems = App(Place::class)->all();
        $dataRender['blockContent'] = view('/admin/place/placeList', [
            'placeItems' => $placeItems,
        ]);
        return $this->renderAdmin($dataRender);
    }

    public function actionGetCardContent()
    {
        $placeId = intval(request()->get('placeId'));
        $place = App(Place::class)->findOrFail($placeId);
        $photoItems = App(Photo::class)->where('place_id', $placeId)->orderBy('num')->orderBy('id')->get();

        $dataRender = [
            'place' => $place,
            'photoItems' => $photoItems,
        ];

        $response['blockContent'] = view('admin/place/placeCard', $dataRender)->render();
        return $this->successResponseJSON($response);
    }
    
    public function actionSave()
    {
        $placeId = intval(request()->get('placeId'));
        $place = App(Place::class)->findOrFail($placeId);
        $place->caption = request()->get('caption');
        $place->code = request()->get('code');
        $place->address = request()->get('address');
        $place->map_link = request()->get('map_link');
        $place->descr = request()->get('descr');
        $place->save();

        return $this->successResponseJSON();
    }

    public function getModelClass()
    {
        return Place::class;
    }
   
}
