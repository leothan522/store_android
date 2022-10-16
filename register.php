<?php
require "Query.php";

function registrar($name, $email, $telefono, $password){
    $query = new Query();
    $row = null;
    $password = password_hash($password, PASSWORD_DEFAULT);
    $date = date("Y-m-d H:i:s");
    $plataforma = 1;

    //consultamos si ya existe el email
    $existe = "select * from `users` where `email` = '{$email}'";
    if ($query->getFirst($existe)){
        return false;
    }

    $sql = "INSERT INTO `users` (`name`, `email`, `password`, `telefono`, `created_at`, `updated_at`) 
            VALUES ('{$name}', '{$email}', '{$password}', '{$telefono}', '{$date}', '{$date}');";
    $query->save($sql);

    $row = $query->getFirst($existe);
    return $row;

}

$data=array();

if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['telefono']) || empty($_POST['password'])) {
    $data['success'] = false;
    $data['message'] = 'Campos Vacios al enviar los datos';
}else{
    $usuario = registrar(ucwords($_POST['name']), $_POST['email'], $_POST['telefono'], $_POST['password']);
    if ($usuario){
        $data['id'] = $usuario['id'];
        $data['name'] = ucwords($usuario['name']);
        $data['email'] = $usuario['email'];
        $data['telefono'] = $usuario['telefono'];
        $data['success'] = true;
        $data['message'] = "Registrado correctamente";
    }else{
        $data['success'] = false;
        $data['message'] = "El correo electronico ya ha sido registrado anteriormente.";
    }

}
echo json_encode($data, JSON_UNESCAPED_UNICODE);

