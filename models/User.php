<?php
class User
{
    public $id;
    public $name;
    public $email;
    public $password;
    public $birthdate;
}

interface UserDaoMysql
{
    public function selectAll();
    public function addUser(User $user);
    public function findById($id);
    public function editUser($updateFields);
    public function deleteUser($id);
}