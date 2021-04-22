<?php

namespace App\Model;

class AvatarManager extends AbstractManager
{
    public const TABLE = 'avatar';

    public function insert(array $avatar)
    {
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE .
            " (image)
            VALUES (:image)"
        );
        $statement->bindValue('image', $avatar['image'], \PDO::PARAM_STR);
        return $statement->execute();
    }
}
