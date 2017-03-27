<?php

namespace App;

class Slug
{
    public static function make(string $string) : string
    {
        return str_replace(' ', '-', strtolower($string));
    }
}
