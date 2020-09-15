<?php
require_once 'config.php';
require_once 'dao/UserDaoMysql.php';

$updateFiels = [];

$name = filter_input(INPUT_POST, 'name');
$password = filter_input(INPUT_POST, 'password');
$password_confirmation = filter_input(INPUT_POST, 'password_confirmation');
$birthdate = filter_input(INPUT_POST, 'birthdate');
$id = intval(filter_input(INPUT_POST, 'id'));

$userDao = new UserDaoSql($pdo, $base);

if($name)
{
    $updateFiels['name'] = $name;
    $updateFiels['id'] = $id;

    if(!empty($password))
    {
        if($password === $password_confirmation)
        {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $updateFiels['password'] = $hash;
        }
        else
        {
            $_SESSION['flash'] = 'Senhas não são iguais!';
            header("Location: ".$base."/editar.php?id=".$id);
            exit;
        }
    }

    if($birthdate)
    {
        $birthdate = explode('/', $birthdate);
        if(count($birthdate) != 3)
        {
            $_SESSION['flash'] = 'Data de nascimento inválida!';
            header("Location: ".$base."/editar.php?id=".$id);
            exit;
        }

        $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
        if(strtotime($birthdate) === false)
        {
            $_SESSION['flash'] = 'Data de nascimento inválida!';
            header("Location: ".$base."/editar.php?id=".$id);
            exit;
        }

        $updateFiels['birthdate'] = $birthdate;
    }

    $userDao->editUser($updateFiels);
    header("Location: ".$base);
}