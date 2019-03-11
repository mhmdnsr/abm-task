<?php

namespace App;

use PDO;
use PDOException;
use App\DB;
use App\Errors;
use App\User;

class Read
{
    private $db;

    public function __construct()
    {
        $this->db = DB::Instance();
    }

    public function all()
    {
        try {
            $query = "SELECT * FROM users ORDER BY id ASC";
            $array = [];
            $stmt = $this->db->prepare($query);
            $stmt->execute($array);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this-> prepareUsers($results);
        } catch (PDOException $exception) {
            return Errors::readError($exception->getMessage());
        }
    }

    public function one($id)
    {
        try {
            $query = "SELECT * FROM users WHERE id=:id LIMIT 1";
            $array = [":id" => $id];
            $stmt = $this->db->prepare($query);
            $stmt->execute($array);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this-> prepareUsers($results);
        } catch (PDOException $exception) {
            return Errors::readError($exception->getMessage());
        }
    }

    private function prepareUsers($results)
    {
        $users = [];

        foreach ($results as $result){
            $user = new User();
            $user->setID($result['id']);
            $user->setName($result['name']);
            $user->setAge($result['age']);
            array_push($users, $user);
        }
        return $users;
    }
}