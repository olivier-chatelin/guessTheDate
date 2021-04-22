<?php

namespace App\Model;

class AdminManager extends AbstractManager
{
    public const TABLE = 'user';

    public function insert(array $user)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (pseudo, 
             password, 
             avatar_id, 
             count_game, 
             created_at, 
             updated_at, 
             is_admin )
            VALUES (:pseudo, :password, :avatar_id, :count_game, :created_at, :updated_at, :is_admin)"
        );
        $statement->bindValue('pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('avatar_id', $user['avatar_id'], \PDO::PARAM_INT);
        $statement->bindValue('count_game', $user['count_game'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $user['created_at'], \PDO::PARAM_STR);
        $statement->bindValue('updated_at', $user['updated_at'], \PDO::PARAM_STR);
        $statement->bindValue('is_admin', $user['is_admin'], \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function update($user)
    {
        $statement = $this->pdo->prepare(
            "UPDATE " . self::TABLE .
            " SET 
            pseudo = :pseudo, 
            password = :password, 
            avatar_id = :avatar_id, 
            count_game = :count_game, 
            created_at = :created_at,
             updated_at = :updated_at,
             is_admin = :is_admin
             WHERE id = :id"
        );
        $statement->bindValue('id', $user['id'], \PDO::PARAM_INT);
        $statement->bindValue('pseudo', $user['pseudo'], \PDO::PARAM_STR);
        $statement->bindValue('password', $user['password'], \PDO::PARAM_STR);
        $statement->bindValue('avatar_id', $user['avatar_id'], \PDO::PARAM_INT);
        $statement->bindValue('count_game', $user['count_game'], \PDO::PARAM_INT);
        $statement->bindValue('created_at', $user['created_at'], \PDO::PARAM_STR);
        $statement->bindValue('updated_at', $user['updated_at'], \PDO::PARAM_STR);
        $statement->bindValue('is_admin', $user['is_admin'], \PDO::PARAM_INT);
        $statement->execute();
    }
}
