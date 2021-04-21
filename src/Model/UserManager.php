<?php

namespace App\Model;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    public function selectOneByPseudo($pseudo)
    {
        $pseudo = ucfirst(strtolower($pseudo));

        // prepared request
        $query = 'SELECT * FROM ' . self::TABLE . ' WHERE pseudo=:pseudo';
        $statement = $this->pdo->prepare($query);
        $statement->bindValue(':pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}