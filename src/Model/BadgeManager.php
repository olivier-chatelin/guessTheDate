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

    public function hasTheBadgeBeenGiven(int $userId, int $badgeId)
    {
        $query = 'SELECT user_badge.user_id, user_badge.badge_id FROM user_badge
          WHERE user_badge.user_id=' . $userId . ' AND user_badge.badge_id=' . $badgeId;
        $statement = $this->pdo->query($query);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function getInfoBadgeToGive(int $userId, int $badgeId)
    {
        $query = 'SELECT user.id, badge.id, badge.name, badge.image, badge.description FROM user 
          JOIN user_badge ON user.id=user_badge.user_id
          JOIN badge ON user_badge.badge_id=badge.id
          WHERE user.id=' . $userId . ' AND badge.id=' . $badgeId;
        $statement = $this->pdo->query($query);
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result;
    }

    public function giveNewBadgeToUser(int $userId, int $badgeId)
    {
        $query = 'INSERT INTO user_badge (user_id, badge_id) VALUES (' . $userId . ', ' . $badgeId . ')';
        $statement = $this->pdo->query($query);
        $statement->execute();
        return $statement;
    }
}
