<?php
require "Query.php";
require "Mailer.php";

function recuperarPassword($email)
{
    $row = null;
    $query = new Query();
    $sql = "SELECT * FROM `users` WHERE `email` = '{$email}';";
    $row = $query->getFirst($sql);
    if ($row){
        //cambio la clave
        $nuevo_password = $query->generate_string(8);
        $password = password_hash($nuevo_password, PASSWORD_DEFAULT);
        $sql = "UPDATE `users` SET `password`='{$password}' WHERE  `id`={$row['id']};";
        $row = $query->save($sql);
        return $nuevo_password;
    }else{
        return false;
    }
}

$data=array();

if (empty($_POST['email'])) {
    $data['success'] = false;
    $data['message'] = 'Campos Vacios al enviar los datos';
    echo(json_encode($data));
}else{

	$resultado = recuperarPassword($_POST['email']);
	if ($resultado){
        $data['success'] = true;
        $data['message'] = "La nueva clave fue enviada por correo: ".$resultado;
        echo(json_encode($data));

        //ENVIO CORREO
        $mailer = new Mailer();
        $subject = 'Nuevo Password';
        $body = 'Hola, este es tu nuevo Password: <h4 style="color: blue">'.$resultado.'</h4> Asegurate de guardar bien la clave.';
        $mailer->enviarEmail($_POST['email'], $subject, $body);

    }else{
        $data['success'] = false;
        $data['message'] = "El correo electronico no coincide con nuestros registros.";
        echo(json_encode($data));
    }
}

