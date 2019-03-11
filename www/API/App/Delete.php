<?php

namespace App;

use PDOException;
use App\DB;

class Delete
{
    public static function all()
    {
        try {
            $db = DB::Instance();
            $query = "DELETE FROM users";
            $array = [];
            $stmt = $db->prepare($query);
            $stmt->execute($array);
            return [
                "state" => "Success"
            ];
        } catch (PDOException $exception) {
            return Errors::deleteError($exception->getMessage(), "All Users");
        }
    }

    public static function one($id, $name)
    {
        try {
            $db = DB::Instance();
            $query = "DELETE FROM users WHERE id =:id";
            $array = [":id" => $id];
            $stmt = $db->prepare($query);
            $stmt->execute($array);
            return [
                "state" => "Success"
            ];
        } catch (PDOException $exception) {
            return Errors::deleteError($exception->getMessage(), $name);
        }
    }
}