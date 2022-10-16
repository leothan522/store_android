<?php
require "Query.php";

function getUsuarios(){
    $query = new Query();
    $sql = "SELECT * FROM `users`";
    $rows = $query->getAll($sql);
    return $rows;
}

$data = array();

$data = getUsuarios();

echo json_encode($data, JSON_UNESCAPED_UNICODE);