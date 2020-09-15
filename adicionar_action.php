<?php
require_once 'config.php';
require_once 'models/User.php';
require_once 'dao/UserDaoMysql.php';

$name = filter_input(INPUT_POST, 'name');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$birthdate = filter_input(INPUT_POST, 'birthdate');

if($name && $email && $password && $birthdate) {

    $birthdate = explode('/', $birthdate);
    if(count($birthdate) !== 3)
    {
        $_SESSION['flash'] = 'Data de Nascimento inválida!';
        header("Location: ".$base."/adicionar.php");
        exit;
    }

    $birthdate = $birthdate[2].'-'.$birthdate[1].'-'.$birthdate[0];
    if(strtotime($birthdate) === false)
    {
        $_SESSION['flash'] = 'Data de Nascimento inválida!';
        header("Location: ".$base."/adicionar.php");
        exit;
    }

    $userDao = new UserDaoSql($pdo, $base);

    if($userDao->findByEmail($email) === false)
    {
        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->birthdate = $birthdate;

        $userDao->addUser($user);
        header("Location: ".$base);
    }
    else {
        $_SESSION['flash'] = 'Email já existe!';
        header("Location: ".$base."/adicionar.php");
        exit;
    }
}
else 
{
    $_SESSION['flash'] = 'Todos os campos precisam ser preenchidos!';
    header("Location: ".$base."/adicionar.php");
    exit;
}