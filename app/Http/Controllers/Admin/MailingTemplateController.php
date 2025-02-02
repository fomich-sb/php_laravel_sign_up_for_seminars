<?php

namespace App\Http\Controllers\Admin;

use App\Facades\Utils;
use App\Models\MailingTemplate;
use App\Models\Photo;
use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MailingTemplateController  extends AdminController
{
 
    public function getModelClass()
    {
        return MailingTemplate::class;
    }
}
