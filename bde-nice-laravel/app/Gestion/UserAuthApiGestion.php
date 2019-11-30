<?php


namespace App\Gestion;

class UserAuthApiGestion
{
    const API_USER = 1;
    const API_PASSWORD = '$2y$10$yRryXxcXaRJ4Azw76wzNt.po12nAXqPF3oPJqyyBfxktz3QoenM6y';

    static function authenticate()
    {
        return APIRequestGestion::post('/authenticate', null,
        [
            'id'       => self::API_USER,
            'password' => self::API_PASSWORD
        ])->{'token'};
    }
}
