<?php

namespace App;

use PDOException;
use App\DB;

class Create
{
    public static function add($name, $age)
    {
        try {
            $db = DB::Instance();
            $query = "INSERT INTO users (`name`, `age`) VALUES (:nm, :age)";
            $array = [":nm" => $name, ":age" => $age];
            $stmt = $db->prepare($query);
            $stmt->execute($array);
            return [
                "state" => "Success"
            ];
        } catch (PDOException $exception) {
            return Errors::createError($exception->getMessage(), $name);
        }
    }
}