<?php

namespace App;
abstract class Regex
{

    public static function firstLastName()
    {
        return "/^[A-ZŽĐŠĆČ][a-zžđšćč]{2,14}(\s[A-ZŽĐŠĆČ][a-zžđšćč]{2,14}){0,1}$/";
    }

    public static function email()
    {
        return "/^[a-z][a-z0-9]{2,14}([\._][a-z0-9]{1,14}){0,4}\@([a-z]{3,5}\.){1,2}[a-z]{2,3}$/";
    }

    public static function password()
    {
        return "/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,16}$/";
    }

    public static function subject()
    {
        return "/^[A-ZŽĐŠĆČ][a-zžđšćč]{2,19}(\s[A-ZŽĐŠĆČa-zžđšćč0-9\@]{1,19}){0,5}$/";
    }

    public static function message()
    {
        return "/^[A-ZŽĐŠĆČ@][A-zŽĐŠĆČžđšćč0-9\(\)\.,?!:\/\;\s\n\*-_@]{1,}$/";
    }

    public static function category()
    {
        return "/^[0-9]$/";
    }

    public static function date()
    {
        return "/^[0-9]{4}\-[0-9]{2}\-[0-9]{2}$/";
    }

    public static function search(){
        return "/^[A-zŽĐŠĆČžđšćč\s\@\-\_]{0,50}$/";
    }
}
