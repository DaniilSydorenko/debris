<?php
/*******************************************************************************
 * Name: App -> JSON -> Shortener
 * Version:
 * Author:
 ******************************************************************************/


// Namespace
namespace App\JSON;
use App\Entities\Url;
use App\Components\Shortener as ShortenerComponent;



/**
 * Shortener class

 *
 */
class Shortener extends \Gaia\Controllers\JSON
{
    public function shortenUrl($url) {
        $Shortener = new ShortenerComponent();
        return $Shortener->shortenUrl($url);
    }
}
