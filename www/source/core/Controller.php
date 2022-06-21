<?php

namespace App\core;

use App\app\views\MembersView;

class Controller
{
    public function returnPagePath($page){
        return MembersView::createViewPath($page);
    }

    public function returnHandlerPath($file){
        return MembersView::createhandlerPath($file);
    }
}