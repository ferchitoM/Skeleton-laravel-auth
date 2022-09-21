<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function saveImage($image, $path = 'public') {

        //* NEW IMAGE NAME
        $filename = time() . '.png';

        //* SAVE IMAGE
        Storage::disk($path)->put($filename, base64_decode($image));

        //* RETURN THE PATH
        //* THE URL BASE IS: localhost:8000
        return URL::to('/') . '/storage/' . $path . '/' . $filename;

        //* NEXT USE COMMAND: php artisan storage:link
    }
}
