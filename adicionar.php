<?php
require 'config.php';
require 'dao/UserDaoMysql.php';

$userDao = new UserDaoSql($pdo, $base);
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
        <form action="adicionar_action.php" method="post" class="form-group">
            <div class="title">
                <h1>Adicionar Usuário</h1>
            </div>

            <?php if(!empty($_SESSION['flash'])): ?>
                <div class="flash">
                    <?=$_SESSION['flash'];?>
                </div>
                <?=$_SESSION['flash'] = '';?>
            <?php endif; ?>
            <label>

                <input type="text" name="name" placeholder="Digite seu Nome">
            </label>

            <label>
                <input type="email" name="email" placeholder="Digite seu E-mail">
            </label>

            <label>
                <input type="password" name="password" placeholder="Digite sua Senha">
            </label>

            <label>
                <input type="text" name="birthdate" id="birthdate" placeholder="Digite sua Data de Nascimento">
            </label>

            <input type="submit" value="Adicionar">
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