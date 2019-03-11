<?php

namespace App;

use PDOException;
use App\DB;

class Update
{
    public static function edit($id, $name, $age){
        try{
            $db = DB::Instance();
            $query = "UPDATE users SET `name` =:nm, `age` =:age WHERE id =:id";
            $array = [":id"=> $id, ":nm" => $name, ":age" => $age];
            $stmt = $db->prepare($query);
            $stmt->execute($array);
            return [
                "state" => "Success"
            ];
        }catch (PDOException $exception){
            return Errors::updateError($exception->getMessage(), $name);
        }
    }
}