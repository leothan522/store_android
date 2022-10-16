<?php
require "Conexion.php";
class Query
{
    public function getFirst($sql)
    {
        $conexion = new Conexion();
        $statement = $conexion->CONEXION->prepare($sql);
        $statement->execute();
        $row = $statement->fetch();
        return $row;
    }

    public function save($sql)
    {
        $conexion = new Conexion();
        $statement = $conexion->CONEXION->prepare($sql);
        $statement->execute();
        return $statement;
    }

    public function getAll($sql)
    {
        $conexion = new Conexion();
        $statement = $conexion->CONEXION->prepare($sql);
        $statement->execute();
        $rows = array();
        while ($result = $statement->fetch()) {
            array_push($rows, $result);
        }
        return $rows;
    }

    function generate_string($strength = 16) {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
        return $random_string;
    }

}