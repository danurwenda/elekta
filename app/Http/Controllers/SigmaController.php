<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use File;

class SigmaController extends Controller {

    public static function getGraph($id) {
        return File::get(public_path("/resource/graph/$id.json"));
    }

}
