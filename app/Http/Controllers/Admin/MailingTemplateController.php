<?php

namespace App\Http\Controllers\Admin;

use App\Models\MailingTemplate;

class MailingTemplateController  extends AdminController
{
    public function getModelClass()
    {
        return MailingTemplate::class;
    }
}
