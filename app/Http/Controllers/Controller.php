<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use PixelApp\Http\Controllers\PixelBaseController;

class Controller extends PixelBaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
