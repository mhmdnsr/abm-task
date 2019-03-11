<?php

include_once "App/autoloader.php";

use App\Read;
use App\Create;
use App\Update;
use App\Delete;

function getUser($read, $id)
{
    $user = $read->one($id);

    if (count($user) > 0)
        return $user;
    else
        return false;
}

function createUser($params)
{
    if (isset($params['name']) && isset($params['age'])) {
        return Create::add($params['name'], $params['age']);
    } else
        return [
            "state" => "Not Found"
        ];
}

function updateUser($params)
{
    if (isset($params['id']) && isset($params['name']) && isset($params['age'])) {
        $id = $params['id'];
        $name = $params['name'];
        $age = $params['age'];
        $read = new Read();
        $user = getUser($read, $id);
        if ($user)
            return Update::edit($id, $name, $age);
        else
            return [
                "state" => "Not Found"
            ];
    } else
        return [
            "state" => "Not Found"
        ];
}

function deleteUser($params)
{
    if (isset($params['id'])) {
        $id = $params['id'];
        $read = new Read();
        $user = getUser($read, $id);
        if ($user)
            return Delete::one($id, $user[0]->getName());
        else
            return [
                "state" => "Not Found"
            ];
    } else
        return [
            "state" => "Not Found"
        ];
}

function readAll()
{
    $read = new Read();
    return $read->all();
}

function toJson($data)
{
    return json_encode($data);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST) && isset($_POST['target'])) {
        $target = $_POST['target'];
        if (strtolower($target) === 'all')
            echo toJson(readAll());
        elseif (strtolower($target) === 'create') {
            if (isset($_POST['param'])) {
                $params = $_POST['param'];
                echo toJson(createUser($params));
            } else
                return [
                    "state" => "Not Found"
                ];
        } elseif (strtolower($target) === 'delete') {
            if (isset($_POST['param'])) {
                $params = $_POST['param'];
                echo toJson(deleteUser($params));
            } else
                return [
                    "state" => "Not Found"
                ];
        } elseif (strtolower($target) === 'update') {
            if (isset($_POST['param'])) {
                $params = $_POST['param'];
                echo toJson(updateUser($params));
            } else
                return [
                    "state" => "Not Found"
                ];
        }
    }
}

//Create::add("Mohamed", 25);

//print_r(Update::edit(5, 'Mido', 23));

//print_r(Delete::all());

//$read = new Read();
//$json = json_encode($read->all());
//
//echo $json;