<?php
header("Access-Control-Allow-Origin: *");
date_default_timezone_set('America/Caracas');
require('vendor/autoload.php');
$dotenv = Dotenv\Dotenv::createImmutable("../laravel/");
$dotenv->load();
class Conexion
{
    public $CONEXION;

    public function __construct()
    {
        $db_conexion = $_ENV['DB_CONNECTION'];
        $db_host = $_ENV['DB_HOST'];
        $db_port = $_ENV['DB_PORT'];
        $db_database = $_ENV['DB_DATABASE'];
        $db_username = $_ENV['DB_USERNAME'];
        $db_password = $_ENV['DB_PASSWORD'];
        $this->CONEXION = new PDO("$db_conexion:host=$db_host;dbname=$db_database", $db_username, $db_password);
    }

}