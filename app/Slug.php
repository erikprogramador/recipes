<?php

namespace App;

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class Slug
{
    /**
     * Create a slug by the string passed
     *
     * @param  string
     * @return string
     */
    public static function make(string $string) : string
    {
        return str_replace(' ', '-', strtolower($string));
    }
}
