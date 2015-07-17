<?php
/*******************************************************************************
 * Name: App -> JSON -> Shortener
 * Version: 1.0
 * Author: Daniil Sydorenko (daniildeveloper@gmail.com)
 ******************************************************************************/


// Namespace
namespace App\JSON;
use App\Entities\Url;
use App\Components\Shortener as ShortenerComponent;



/**
 * Shortener class
 */
class Shortener extends \Gaia\Controllers\JSON
{

    /**
     * Main method, use Shortener Component
     * @param $url
     * @return array
     */
    public function shortenUrl($url) {
        $Shortener = new ShortenerComponent();
        return $Shortener->shortenUrl($url);
    }
}
