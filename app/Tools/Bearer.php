<?php

namespace App\Tools;


class Bearer {

    public static function getToken() 
    {
        try {
            $bearer = request()->header('Authorization');
            // parsear
            $parse = explode(" ", $bearer);
            // return 
            return $parse[1];
        } catch (\Throwable $th) {
            return null;
        }
    }

}