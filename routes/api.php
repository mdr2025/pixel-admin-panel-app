<?php


use Illuminate\Support\Facades\Route;
use PixelApp\Helpers\PixelGlobalHelpers;

PixelGlobalHelpers::requirePhpFiles(__DIR__ . '/CompanyModule'); 
  

Route::get('Unauthorized', function () {
    return response()->json(['message' => 'Unauthorized'], 401);
})->middleware('reqLimit');
 
 