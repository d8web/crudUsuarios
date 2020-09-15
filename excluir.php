<?php
require_once 'config.php';
require_once 'dao/UserDaoMysql.php';

$id = intval($_GET['id']);
$user = new UserDaoSql($pdo, $base);

if($user->findById($id))
{
    $user->deleteUser($id);
}

header("Location: ".$base);
exit;