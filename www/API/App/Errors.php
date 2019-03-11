<?php

namespace App;


class Errors
{
    public static function readError($error)
    {
        return
            [
                "error" => $error,
                "message" => "Failed to load users!"
            ];
    }

    public static function createError($error, $user_name)
    {
        return
            [
                "error" => $error,
                "message" => "Failed to create user ($user_name)!"
            ];
    }

    public static function updateError($error, $user_name)
    {
        return
            [
                "error" => $error,
                "message" => "Failed to update user ($user_name)!"
            ];
    }

    public static function deleteError($error, $user_name)
    {
        return
            [
                "error" => $error,
                "message" => "Failed to delete user ($user_name)!"
            ];
    }
}