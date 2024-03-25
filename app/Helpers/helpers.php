<?php

use App\Models\WavierSnapshot;
use App\Settings\GeneralSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

function getSettings($key)
{
    return app(GeneralSettings::class)->$key ?? null;
}


function getSelected(): string
{
    if (request()->routeIs('users.*')) {
        return 'tab_two';
    } elseif (request()->routeIs('permissions.*')) {
        return 'tab_three';
    } elseif (request()->routeIs('roles.*')) {
        return 'tab_three';
    } elseif (request()->routeIs('database-backups.*')) {
        return 'tab_four';
    } elseif (request()->routeIs('general-settings.*')) {
        return 'tab_five';
    } elseif (request()->routeIs('dashboards.*')) {
        return 'tab_one';
    } else {
        return 'tab_one';
    }
}

function storeBase64Image($signature, $imagePath){
    $image_64 = base64_decode($signature);
    $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];   // .jpg .png .pdf
    $imageName = $imagePath.'.'.$extension;
    $replace = substr($image_64, 0, strpos($image_64, ',')+1); 
    $image = str_replace($replace, '', $image_64); 
    $image = str_replace(' ', '+', $image); 
    Storage::disk('public')->put($imageName, base64_decode($image));
}

function generateUniqueCode()
{
    do {
        $code = 'W'.random_int(001, 999).'D'.Carbon::now()->timestamp;
    } while (WavierSnapshot::where("title", "=", $code)->exists());
     
    return $code;
}