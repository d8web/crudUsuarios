<?php
session_start();
$base = 'http://localhost/CrudBasico';

$dbHost = 'localhost';
$dbName = 'usuariosCrud';
$dbUser = 'root';
$dbPass = '';

try {
    $pdo = new PDO("mysql:dbname=".$dbName.";host=".$dbHost, $dbUser, $dbPass);
} catch(PDOException $e)
{
    echo 'Erro na conexão com o banco: '.$e->getMessage();
}