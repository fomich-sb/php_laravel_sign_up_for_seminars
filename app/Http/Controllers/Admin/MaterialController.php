<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\Photo;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class MaterialController extends AdminController
{
    public function getModelClass()
    {
        return Material::class;
    }
}
