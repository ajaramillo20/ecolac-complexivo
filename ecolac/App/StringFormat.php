<?php

class StringFormat
{
    public static function DateFormat($date)
    {
        return date("d-m-Y", strtotime($date));
    }

    public static function IsNullOrEmptyString($str)
    {
        return (!isset($str) || trim($str) === '');
    }
}