<?php

namespace App\Helpers;

use HTMLPurifier;
use HTMLPurifier_Config;

class HtmlSanitizer
{
    public static function sanitize($html)
    {
        $config = HTMLPurifier_Config::createDefault();
        $purifier = new HTMLPurifier($config);

        return $purifier->purify($html);
    }
}
