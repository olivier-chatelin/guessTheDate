<?php

namespace App\Model;

class BadgeManager extends AbstractManager
{
    public function showAll($pseudo)
    {
        $query = "
                SELECT b.id, b.image, b.name, b.description FROM badge b
                 JOIN user_badge ub ON b.id = ub.badge_id
                 JOIN  user u ON ub.user_id = u.id
                 WHERE u.pseudo= :pseudo";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function showBadgesLeft($pseudo)
    {
        $query = "SELECT b.id,b.image, b.name,b.description FROM badge b
                WHERE b.name IS NOT NULL AND b.id NOT IN(
                SELECT b.id  FROM badge b
                JOIN user_badge ub ON b.id = ub.badge_id
                JOIN  user u ON ub.user_id = u.id
                WHERE u.pseudo = :pseudo)";
        $statement = $this->pdo->prepare($query);
        $statement->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
}
