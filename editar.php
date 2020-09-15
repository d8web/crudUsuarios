<?php
require_once 'config.php';
require_once 'dao/UserDaoMysql.php';

$id = intval($_GET['id']);
$userEdit = new UserDaoSql($pdo, $base);
$userInfo = $userEdit->findById($id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css">
    <title>Crud</title>
</head>
<body>

    <section class="container">
        <form action="editar_action.php" method="post" class="form-group">
            <div class="title">
                <h1>Editar Usuário</h1>
            </div>

            <?php if(!empty($_SESSION['flash'])): ?>
                <div class="flash">
                    <?=$_SESSION['flash'];?>
                </div>
                <?=$_SESSION['flash'] = '';?>
            <?php endif; ?>

            <label>
                <input type="text" name="name" placeholder="Digite seu Nome" value="<?=$userInfo->name;?>">
            </label>

            <label>
                <input type="text" name="birthdate" id="birthdate" placeholder="Digite sua Data de Nascimento" value="<?=date('d/m/Y', strtotime($userInfo->birthdate));?>">
            </label>

            <label>
                <input type="password" name="password" placeholder="Digite sua Senha">
            </label>

            <label>
                <input type="password" name="password_confirmation" placeholder="Repetir a Senha">
            </label>

            <input type="hidden" name="id" value="<?=$userInfo->id;?>">

            <input type="submit" value="Editar">
        </form>
    </section>

    <script src="https://unpkg.com/imask"></script>
    <script>
        IMask(
            document.getElementById('birthdate'),
            {mask:'00/00/0000'}
        );
    </script>
    
</body>
</html>