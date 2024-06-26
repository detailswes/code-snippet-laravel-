<?php

use App\Models\File;
use Illuminate\Support\Facades\Storage;

function slugify($text)
{
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

//TO SHOW SITE LOGO IMAGE

function getSiteLogo()
{
    $logo = File::siteLogo()->first();
    if (optional($logo)->path && $logo->path != '') {
        return url(Storage::url($logo->path));
    } else {
        return url('../img/logo.png');
    }
}
