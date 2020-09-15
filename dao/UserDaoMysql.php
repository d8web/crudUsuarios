<?php
require_once 'models/User.php';

class UserDaoSql implements UserDaoMysql
{
    private $pdo;
    private $base;

    public function __construct(PDO $pdo, $base)
    {
        $this->pdo = $pdo;
        $this->base = $base;
    }

    private function generateUser( array $array )
    {
        if($array)
        {
            $user = new User();
            $user->id = $array['id'] ?? 0;
            $user->name = $array['name'] ?? '';
            $user->email = $array['email'] ?? '';
            $user->password = $array['password'] ?? '';
            $user->birthdate = $array['birthdate'] ?? '';

            return $user;
        }
    }

    public function selectAll()
    {
        $sql = $this->pdo->query("SELECT * FROM usuarios");
        $sql->execute();

        if($sql->rowCount() > 0)
        {
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    public function findByEmail($email)
    {
        if(!empty($email))
        {
            $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
            $sql->bindValue(':email', $email);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                if($user)
                {
                    return $user;
                }
            }
            else
            {
                return false;
            }
        }
    }

    public function findById($id)
    {
        if(!empty($id))
        {
            $sql = $this->pdo->prepare("SELECT * FROM usuarios WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

            if($sql->rowCount() > 0)
            {
                $data = $sql->fetch(PDO::FETCH_ASSOC);
                $user = $this->generateUser($data);

                if($user)
                {
                    return $user;
                }
            }
        }
    }

    public function addUser(User $user)
    {
        $hash = password_hash($user->password, PASSWORD_DEFAULT);

        $sql = $this->pdo->prepare("INSERT INTO usuarios (
            name,
            email,
            password,
            birthdate
        )
        VALUES 
        (
            :name,
            :email,
            :password,
            :birthdate
        )");

        $sql->bindValue(':name', $user->name);
        $sql->bindValue(':email', $user->email);
        $sql->bindValue(':password', $hash);
        $sql->bindValue(':birthdate', $user->birthdate);
        $sql->execute();
    }

    public function editUser($updateFields)
    {
        if(!empty($updateFields['password'])) {
            $sql = $this->pdo->prepare("UPDATE usuarios SET 
                    name = :name,
                    password = :password,
                    birthdate = :birthdate
                WHERE id = :id");
            $sql->bindValue(':name', $updateFields['name']);
            $sql->bindValue(':password', $updateFields['password']);
            $sql->bindValue(':birthdate', $updateFields['birthdate']);
            $sql->bindValue(':id', $updateFields['id']);
            $sql->execute();
        }
        else
        {
            $sql = $this->pdo->prepare("UPDATE usuarios SET 
                    name = :name,
                    birthdate = :birthdate
                WHERE id = :id");
            $sql->bindValue(':name', $updateFields['name']);
            $sql->bindValue(':birthdate', $updateFields['birthdate']);
            $sql->bindValue(':id', $updateFields['id']);
            $sql->execute();
        }
    }

    public function deleteUser($id)
    {
        if($id)
        {
            $sql = $this->pdo->prepare("DELETE FROM usuarios WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
        }
    }
}