<?php
require "Query.php";

function update($campo, $valor, $id, $password = null)
{
    $row = null;
    $query = new Query();
    $sql = "SELECT * FROM `users` WHERE `id` = '{$id}';";
    $row = $query->getFirst($sql);
    if ($row){

        switch ($campo){

            case "email":
                if ($row[$campo] != $valor){

                    $sql = "SELECT * FROM `users` WHERE `email` = '{$valor}' AND `id` != '{$id}';";
                    $row = $query->getFirst($sql);
                    if (!$row){
                        $sql = "UPDATE `users` SET `{$campo}`='{$valor}' WHERE  `id`={$id};";
                        $row = $query->save($sql);
                        return "update";
                    }else{
                        return "error";
                    }

                }else{
                    return "sin cambios";
                }
                break;
            case "password":
                if ($password != null){

                    if (password_verify($password, $row[$campo])){

                        $nuevo_password = password_hash($valor, PASSWORD_DEFAULT);
                        $sql = "UPDATE `users` SET `{$campo}`='{$nuevo_password}' WHERE  `id`={$id};";
                        $row = $query->save($sql);
                        return "update";

                    }else{
                        return "error";
                    }

                }else{
                    return "sin cambios";
                }
                break;

            default:
                if ($row[$campo] != $valor){
                    $sql = "UPDATE `users` SET `{$campo}`='{$valor}' WHERE  `id`={$id};";
                    $row = $query->save($sql);
                    return "update";
                }else{
                    return "sin cambios";
                }
                break;
        }

    }else{
        return false;
    }

}



$name = null;
$telefono = null;
$email = null;
$error = null;
$password = null;
$data=array();

$data['name'] = false;
$data['email'] = false;
$data['telefono'] = false;
$data['error'] = false;


if (!empty($_POST['name'])){
    $update = update('name', ucwords($_POST['name']), $_POST['id']);
    if ($update == "update"){
        $data['name'] = ucwords($_POST['name']);
        $name = true;
    }
}
if (!empty($_POST['telefono'])){
    $update = update('telefono', $_POST['telefono'], $_POST['id']);
    if ($update == "update"){
        $data['telefono'] = $_POST['telefono'];
        $telefono = true;
    }
}
if (!empty($_POST['email'])){
    $update = update('email', strtolower($_POST['email']), $_POST['id']);
    if ($update == "update"){
        $data['email'] = strtolower($_POST['email']);
        $email = true;
    }else{
        if ($update == "error"){
            $error = "email";
        }
    }

}


if (!empty($_POST['password']) && !empty($_POST['nuevo_password'])){
    $update = update("password", $_POST['nuevo_password'], $_POST['id'], $_POST['password']);
    if ($update == "update"){
        $password = true;
    }else{
        if ($update == "error"){
            $error = "password";
        }
    }

}


if ($name || $email || $password || $telefono){
    $data['success'] = true;
    $data['message'] = "Cambios Guardados Correctamente";
}else{

    switch ($error){

        case "email":
            $data['success'] = false;
            $data['error'] = "Email NO disponible";
            $data['message'] = "El correo electronico ya ha sido registrado anteriormente.";
        break;
        case "password":
            $data['success'] = false;
            $data['error'] = "Contraseña Incorrecta";
            $data['message'] = "Password Incorrecto.";
        break;

        default:
            $data['success'] = false;
            $data['message'] = "No se realizo ningun cambio.";
        break;
    }

}


echo json_encode($data, JSON_UNESCAPED_UNICODE);

?>