<?php
require 'config.php';
require 'dao/UserDaoMysql.php';

$userDao = new UserDaoSql($pdo, $base);
$users = $userDao->selectAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?=$base;?>/assets/css/style.css">
    <title>Crud - Usuários</title>
</head>
<body>
    
    <section class="container itens">
        <section class="title">
            <h1>Crud Usuários</h1>
        </section>
        <a class="btn edit" href="adicionar.php">Adicionar Usuário</a>
        <div class="wrapper-table">
            <table width="100%">
                <thead>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th>
                </thead>

                <?php if($users): ?>
                    <?php foreach($users as $item): ?>
                        <tbody>
                            <td><?=$item['id'];?></td>
                            <td><?=$item['name'];?></td>
                            <td><?=$item['email'];?></td>
                            <td><?=date('d/m/Y', strtotime($item['birthdate']));?></td>
                            <td>
                                <a class="btn edit" href="editar.php?id=<?=$item['id'];?>">
                                    Editar
                                </a>
                                <a class="btn del" href="excluir.php?id=<?=$item['id'];?>"
                                    onclick="return confirm('Deseja realmente excluir?')">
                                    Excluir
                                </a>
                            </td>
                        </tbody>
                    <?php endforeach; ?>
                <?php endif; ?>

            </table>
        </div>
    </section>

</body>
</html>